<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'patient_name',
        'blood_group',
        'units_required',
        'hospital_name',
        'hospital_address',
        'city',
        'state',
        'pincode',
        'contact_person',
        'contact_phone',
        'urgency_level',
        'status',
        'required_date',
        'notes',
        'description',
        'latitude',
        'longitude',
        'radius_km',
        'confirmed_donor_id',
        'confirmation_date',
        'confirmation_notes',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function matchResults()
    {
        return $this->hasMany(MatchResult::class);
    }

    public function confirmedDonor()
    {
        return $this->belongsTo(User::class, 'confirmed_donor_id');
    }
}
