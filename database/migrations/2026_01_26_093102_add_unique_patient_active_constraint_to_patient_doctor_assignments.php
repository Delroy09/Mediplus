<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patient_doctor_assignments', function (Blueprint $table) {
            // Drop the old unique constraint first
            $table->dropUnique('unique_active_assignment');

            // Add new constraint: 1 patient can only have 1 active doctor at a time
            $table->unique(['patient_id', 'is_active'], 'unique_patient_active_doctor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_doctor_assignments', function (Blueprint $table) {
            // Restore original constraint
            $table->dropUnique('unique_patient_active_doctor');
            $table->unique(['patient_id', 'doctor_id', 'is_active'], 'unique_active_assignment');
        });
    }
};
