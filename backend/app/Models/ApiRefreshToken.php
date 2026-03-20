<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ApiRefreshToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'revoked_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }

    public function isActive(): bool
    {
        return !$this->isExpired() && !$this->isRevoked();
    }

    public static function hashToken(string $plain): string
    {
        return hash('sha256', $plain);
    }

    public static function generateToken(): string
    {
        return bin2hex(random_bytes(40));
    }
}
