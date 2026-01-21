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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // 1:1 with Users
            $table->string('mobile_number', 15);
            $table->string('blood_group', 5); // A+, A-, B+, B-, AB+, AB-, O+, O-
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('address');
            $table->datetime('admission_date')->nullable();
            $table->string('status', 50)->default('Admitted'); // Admitted, Surgery, Discharged
            $table->date('last_visited_date')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
