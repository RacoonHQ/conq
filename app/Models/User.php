<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
        $this->resetCreditsIfNeeded();
        return $this->credits;
    }

    public function resetCreditsIfNeeded()
    {
        $now = now();
        
        // Check if credits_last_reset_at column exists before using it
        if (!isset($this->attributes['credits_last_reset_at'])) {
            // Column doesn't exist, skip reset logic for now
            return;
        }
        
        // Check if credits need to be reset (24 hours have passed since last reset)
        if (!$this->credits_last_reset_at || $now->diffInHours($this->credits_last_reset_at) >= 24) {
            $this->credits = 100;
            $this->credits_last_reset_at = $now;
            $this->save();
        }
    }

    public function useCredits($amount)
    {
        $this->resetCreditsIfNeeded();
        
        if ($this->credits >= $amount) {
            $this->credits -= $amount;
            $this->save();
            return true;
        }
        
        return false;
    }

    public function hasCredits($amount = 1)
    {
        $this->resetCreditsIfNeeded();
        return $this->credits >= $amount;
    }

    /**
     * Check if the current user is a guest (not authenticated)
     */
    public static function isGuest()
    {
        return !Auth::check();
    }

    /**
     * Check if the current authenticated user can upload files
     */
    public static function canUploadFiles()
    {
        return Auth::check(); // Only authenticated users can upload files
    }
}