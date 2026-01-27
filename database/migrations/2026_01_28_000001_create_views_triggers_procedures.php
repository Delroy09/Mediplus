<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Simple Views, Triggers, and Stored Procedures for MediPlus
     */
    public function up(): void
    {
        // Clean up first
        $this->down();

        // ============================================
        // VIEWS (Simple read-only queries)
        // ============================================

        // View 1: Patient list with assigned doctor name
        DB::statement("
            CREATE VIEW vw_patient_with_doctor AS
            SELECT 
                p.id AS patient_id,
                pu.name AS patient_name,
                p.status,
                du.name AS doctor_name,
                d.specialization
            FROM patients p
            JOIN users pu ON p.user_id = pu.id
            LEFT JOIN patient_doctor_assignments pda ON p.id = pda.patient_id AND pda.is_active = 1
            LEFT JOIN doctors d ON pda.doctor_id = d.id
            LEFT JOIN users du ON d.user_id = du.id
        ");

        // View 2: Doctor patient count
        DB::statement("
            CREATE VIEW vw_doctor_patient_count AS
            SELECT 
                d.id AS doctor_id,
                u.name AS doctor_name,
                d.specialization,
                COUNT(pda.patient_id) AS patient_count
            FROM doctors d
            JOIN users u ON d.user_id = u.id
            LEFT JOIN patient_doctor_assignments pda ON d.id = pda.doctor_id AND pda.is_active = 1
            GROUP BY d.id, u.name, d.specialization
        ");

        // ============================================
        // TRIGGERS (Auto-actions on data changes)
        // ============================================

        // Trigger 1: Log when patient status changes
        DB::unprepared("
            CREATE TRIGGER trg_log_status_change
            AFTER UPDATE ON patients
            FOR EACH ROW
            BEGIN
                IF OLD.status != NEW.status THEN
                    INSERT INTO patient_status_logs (patient_id, old_status, new_status, changed_at)
                    VALUES (NEW.id, OLD.status, NEW.status, NOW());
                END IF;
            END
        ");

        // Trigger 2: Update last_visited_date when medical record is added
        DB::unprepared("
            CREATE TRIGGER trg_update_last_visit
            AFTER INSERT ON medical_records
            FOR EACH ROW
            BEGIN
                UPDATE patients 
                SET last_visited_date = NEW.visit_date
                WHERE id = NEW.patient_id;
            END
        ");

        // ============================================
        // STORED PROCEDURES (Reusable operations)
        // ============================================

        // Procedure 1: Count patients by status
        DB::unprepared("
            CREATE PROCEDURE sp_count_by_status()
            BEGIN
                SELECT status, COUNT(*) AS total
                FROM patients
                GROUP BY status;
            END
        ");

        // Procedure 2: Discharge a patient (updates status + ends assignment)
        DB::unprepared("
            CREATE PROCEDURE sp_discharge_patient(IN p_id INT)
            BEGIN
                UPDATE patients 
                SET status = 'Discharged', last_visited_date = CURDATE()
                WHERE id = p_id;
                
                UPDATE patient_doctor_assignments
                SET is_active = 0, unassigned_date = CURDATE()
                WHERE patient_id = p_id AND is_active = 1;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_count_by_status');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_discharge_patient');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_log_status_change');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_update_last_visit');
        DB::statement('DROP VIEW IF EXISTS vw_patient_with_doctor');
        DB::statement('DROP VIEW IF EXISTS vw_doctor_patient_count');
    }
};
