<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create descriptive DB views, triggers, and stored procedures for MediPlus
     */
    public function up(): void
    {
        // Clean up first
        $this->down();

        // ============================================
        // VIEWS (Simple read-only queries)
        // ============================================

        // View: patient details with assigned doctor
        DB::statement("
            CREATE VIEW GetPatientDoctor AS
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

        // View: doctor patient counts
        DB::statement("
            CREATE VIEW GetDoctorPatientCount AS
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

        // Trigger: log patient status changes
        DB::unprepared("
            CREATE TRIGGER LogPatientStatusChange
            AFTER UPDATE ON patients
            FOR EACH ROW
            BEGIN
                IF OLD.status != NEW.status THEN
                    INSERT INTO patient_status_logs (patient_id, old_status, new_status, changed_by, changed_at)
                    VALUES (NEW.id, OLD.status, NEW.status, NEW.changed_by, NOW());
                END IF;
            END
        ");

        // Trigger: update patient's last_visited_date after new medical record
        DB::unprepared("
            CREATE TRIGGER UpdatePatientLastVisit
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

        // Procedure: count patients by status
        DB::unprepared("
            CREATE PROCEDURE CountPatientsByStatus()
            BEGIN
                SELECT status, COUNT(*) AS total
                FROM patients
                GROUP BY status;
            END
        ");

        // Procedure: discharge patient and close assignments
        DB::unprepared("
            CREATE PROCEDURE DischargePatient(IN p_id INT)
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
        DB::unprepared('DROP PROCEDURE IF EXISTS CountPatientsByStatus');
        DB::unprepared('DROP PROCEDURE IF EXISTS DischargePatient');
        DB::unprepared('DROP TRIGGER IF EXISTS LogPatientStatusChange');
        DB::unprepared('DROP TRIGGER IF EXISTS UpdatePatientLastVisit');
        DB::statement('DROP VIEW IF EXISTS GetPatientDoctor');
        DB::statement('DROP VIEW IF EXISTS GetDoctorPatientCount');
    }
};
