<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'plan',
        'credits',
        'credits_used',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class)->orderBy('created_at', 'desc');
    }

    public function getRemainingCreditsAttribute()
    {
        // Check if credits_used column exists, if not use 0 as default
        $creditsUsed = 0;
        if (isset($this->attributes['credits_used'])) {
            $creditsUsed = $this->credits_used;
        }
        return $this->credits - $creditsUsed;
    }

    public function useCredits($amount)
    {
        // Only update if credits_used column exists
        if (isset($this->attributes['credits_used'])) {
            $this->credits_used += $amount;
            $this->save();
        }
    }

    public function hasCredits($amount = 1)
    {
        return $this->getRemainingCreditsAttribute() >= $amount;
    }
}