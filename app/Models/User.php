<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'role', // SRS-08: admin atau user
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * SRS-08: Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * SRS-02: List/project yang dimiliki (dibuat) oleh user ini sebagai owner.
     */
    public function ownedLists()
    {
        return $this->hasMany(TodoList::class, 'user_id');
    }

    /**
     * SRS-06: Kolaborasi List
     * List/project yang diikuti user ini sebagai member (bukan owner).
     */
    public function memberLists()
    {
        return $this->belongsToMany(TodoList::class, 'list_user', 'user_id', 'list_id')
                    ->withTimestamps();
    }
}
