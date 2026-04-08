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
        'id_member',
        'role',
        'address',
        'phone',
        'avatar',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if ($user->role === 'scholar') {
                $lastUser = User::whereNotNull('id_member')->orderBy('id', 'desc')->first();
                $number = $lastUser ? intval(substr($lastUser->id_member, 4)) + 1 : 1;
                $user->id_member = 'MBR-' . str_pad($number, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function personalFolders()
    {
        return $this->hasMany(PersonalFolder::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
