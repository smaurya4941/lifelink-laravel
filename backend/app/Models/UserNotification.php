<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_type',
        'title',
        'message',
        'is_read',
        'related_request_id',
        'related_match_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relatedRequest()
    {
        return $this->belongsTo(BloodRequest::class, 'related_request_id');
    }

    public function relatedMatch()
    {
        return $this->belongsTo(MatchResult::class, 'related_match_id');
    }
}
