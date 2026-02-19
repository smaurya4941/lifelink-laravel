<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonorProfile extends Model
{
    //

    use HasFactory;
    protected $fillable = [
        'user_id',
        'blood_group',
        'age',
        'weight',
        'last_donation_date',
        'availability_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
