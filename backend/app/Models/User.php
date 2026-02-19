<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'city',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //adding relationship one to one mapping
    public function donorProfile()
    {
        return $this->hasOne(DonorProfile::class);
    }


    public function recipientProfile()
    {
        return $this->hasOne(RecipientProfile::class);
    }


    public function hospitalProfile()
    {
        return $this->hasOne(HospitalProfile::class);
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class, 'requester_id');
    }


    public function donorMatches()
    {
        return $this->hasMany(MatchResult::class, 'donor_id');
    }

    public function donationsAsDonor()
{
    return $this->hasMany(Donation::class, 'donor_id');
}

public function donationsAsRecipient()
{
    return $this->hasMany(Donation::class, 'recipient_id');
}

}
