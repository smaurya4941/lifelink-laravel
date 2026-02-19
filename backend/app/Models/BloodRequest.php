<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'blood_group',
        'units_required',
        'hospital_name',
        'city',
        'urgency_level',
        'status',
        'required_date',
        'notes',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function matchResults()
    {
        return $this->hasMany(MatchResult::class);
    }
}
