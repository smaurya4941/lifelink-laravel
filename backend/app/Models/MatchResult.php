<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MatchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'donor_id',
        'match_score',
        'distance_km',
        'success_probability',
        'health_risk',
        'scores_breakdown',
        'status',
        'responded_at',
        'notes',
    ];

    protected $casts = [
        'scores_breakdown' => 'array',
        'responded_at' => 'datetime',
    ];

    public function bloodRequest()
    {
        return $this->belongsTo(BloodRequest::class, 'request_id');
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
}
