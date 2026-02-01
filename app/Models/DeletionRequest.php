<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletionRequest extends Model
{
    protected $fillable = [
        'patient_id',
        'reason',
        'status',
        'reviewed_by',
        'reviewed_at',
        'deleted_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
