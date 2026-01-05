<?php // Tag pembuka PHP

namespace App\Models; // Definisikan namespace untuk model ini

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import trait factory untuk membuat instance model
use Illuminate\Database\Eloquent\Model; // Import kelas model Eloquent dasar
use Illuminate\Database\Eloquent\Concerns\HasUuids; // Import trait UUID untuk menghasilkan UUID instead of ID auto-increment

class Conversation extends Model // Definisikan kelas Conversation yang extends Model dasar
{
    use HasFactory, HasUuids; // Gunakan trait HasFactory dan HasUuids

    protected $fillable = ['title', 'agent_id', 'user_id', 'messages']; // Definisikan atribut yang bisa di-assign massal

    protected $casts = [ // Definisikan bagaimana atribut harus di-cast saat diambil
        'messages' => 'array', // Cast atribut messages ke array (disimpan sebagai JSON di database)
    ];

    public function user() // Definisikan metode relasi untuk mendapatkan user yang memiliki conversation ini
    {
        return $this->belongsTo(User::class); // Return relasi belongsTo ke model User
    }
}