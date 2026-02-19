<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HospitalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_name',
        'address',
        'license_number',
        'verification_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

