<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'mobile_number',
        'blood_group',
        'dob',
        'gender',
        'address',
        'admission_date',
        'status',
        'last_visited_date',
        'emergency_contact_name',
        'emergency_contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'patient_doctor_assignments');
    }

    public function doctorAssignments()
    {
        return $this->hasMany(\App\Models\PatientDoctorAssignment::class, 'patient_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(PatientStatusLog::class);
    }
}
