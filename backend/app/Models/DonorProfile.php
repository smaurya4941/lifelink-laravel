<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_group',
        'age',
        'weight',
        'height',
        'medical_conditions',
        'emergency_contact',
        'address',
        'city',
        'state',
        'pincode',
        'last_donation_date',
        'availability_status',
        'matching_score',
        'is_verified',
        'is_live_location_enabled',
        'current_latitude',
        'current_longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
