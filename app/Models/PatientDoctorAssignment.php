<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDoctorAssignment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'assigned_date',
        'unassigned_date',
        'is_active',
        'assigned_by',
        'notes',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'unassigned_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
