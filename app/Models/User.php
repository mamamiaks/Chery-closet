<?php

namespace App\Models;

use App\Models\Pesanan;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
  protected $fillable = [
    'name',
    'email',
    'password',
    'alamat',
    'nohp',
    'role'
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi ke tabel pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id', 'id');
    }

    public function hasRole(string $role):bool
    {
        return $this->role === $role ;
    }

    public function IsAdmin(string $role): bool
    {
        return $this->role === 'admin';
    }
}