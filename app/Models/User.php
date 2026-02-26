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
        'global_role', 
        'is_banned', 
        'reputation_score'
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
            'is_banned' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function (User $user) {
            if (self::count() === 0) {
                $user->global_role = 'admin';
            }
        });
    }

    public function colocations()
    {
        return $this->belongsToMany(Colocation::class)
            ->using(ColocationUser::class)
            ->withPivot('group_role', 'left_at')
            ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'paid_by');
    }

    public function settlementsAsPayer()
    {
        return $this->hasMany(Settlement::class, 'payer_id');
    }

    public function settlementsAsPayee()
    {
        return $this->hasMany(Settlement::class, 'payee_id');
    }

    public function getActiveColocation()
    {
        return $this->colocations()
            ->wherePivotNull('left_at')
            ->first();
    }

    public function isAdmin(): bool
    {
        return $this->global_role === 'admin';
    }
}