<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuth extends Model
{
    use HasFactory;

    protected $table = 'two_factor_auth';

    protected $fillable = [
        'user_id',
        'secret_key',
        'is_enabled',
        'backup_codes',
        'last_used',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'backup_codes' => 'array',
        'last_used' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
