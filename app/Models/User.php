<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLES = [
        'admin' => 'Admin',
        'farmer' => 'Farmer',
        'buyer' => 'Buyer',
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'role', 'region', 'password',
    ];

    public function produce() { return $this->hasMany(Produce::class); }
    public function orders() { return $this->hasMany(Order::class, 'buyer_id'); }
    public function sentMessages() { return $this->hasMany(Message::class, 'sender_id'); }
    public function receivedMessages() { return $this->hasMany(Message::class, 'receiver_id'); }
    public function ratings() { return $this->hasMany(Rating::class, 'buyer_id'); }
    public function notifications() { return $this->hasMany(Notification::class); }

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
}