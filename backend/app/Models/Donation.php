<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_result_id',
        'donor_id',
        'recipient_id',
        'hospital_id',
        'units_donated',
        'donation_date',
        'status',
        'is_successful',
        'notes',
    ];

    public function matchResult()
    {
        return $this->belongsTo(MatchResult::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }
}
