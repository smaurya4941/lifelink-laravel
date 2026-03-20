<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserNotification;
use App\Models\BloodRequest;
use App\Models\MatchResult;

class NotificationService
{
    public function create(User $user, string $type, string $title, string $message, ?BloodRequest $request = null, ?MatchResult $match = null): UserNotification
    {
        return UserNotification::create([
            'user_id' => $user->id,
            'notification_type' => $type,
            'title' => $title,
            'message' => $message,
            'related_request_id' => $request?->id,
            'related_match_id' => $match?->id,
        ]);
    }
}
