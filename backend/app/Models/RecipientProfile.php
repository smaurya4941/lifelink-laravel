<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_condition',
        'emergency_contact',
        'blood_group',
        'age',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

