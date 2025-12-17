<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Conversation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'agent_id', 'user_id', 'messages'];

    protected $casts = [
        'messages' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}