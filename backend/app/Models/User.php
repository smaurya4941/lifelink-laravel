<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'is_donor',
        'is_recipient',
        'is_hospital',
        'phone_number',
        'date_of_birth',
        'address',
        'city',
        'traditional_state',
        'pincode',
        'country',
        'latitude',
        'longitude',
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
            'is_donor' => 'boolean',
            'is_recipient' => 'boolean',
            'is_hospital' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasCapability(string $capability): bool
    {
        return match ($capability) {
            'donor' => (bool) $this->is_donor,
            'recipient' => (bool) $this->is_recipient,
            'hospital' => (bool) $this->is_hospital || $this->role === 'hospital',
            'admin' => $this->isAdmin(),
            default => false,
        };
    }

    public function capabilityLabels(): array
    {
        $labels = [];
        if ($this->hasCapability('donor')) {
            $labels[] = 'Donor';
        }
        if ($this->hasCapability('recipient')) {
            $labels[] = 'Recipient';
        }
        if ($this->hasCapability('hospital')) {
            $labels[] = 'Hospital';
        }
        if ($this->isAdmin()) {
            $labels[] = 'Admin';
        }

        return $labels;
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

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function twoFactorAuth()
    {
        return $this->hasOne(TwoFactorAuth::class);
    }

    public function securityEvents()
    {
        return $this->hasMany(SecurityEvent::class);
    }

    public function refreshTokens()
    {
        return $this->hasMany(ApiRefreshToken::class);
    }

    public function hospitalProfile()
    {
        // Backward-compatible alias; hospital is the canonical domain relation.
        return $this->hospital();
    }

    public function hospital()
    {
        return $this->hasOne(Hospital::class);
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
