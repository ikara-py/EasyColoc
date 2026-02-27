<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'join_code'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(ColocationUser::class)
            ->withPivot('group_role', 'left_at')
            ->withTimestamps();
    }

    public function activeMembers()
    {
        return $this->belongsToMany(User::class)
            ->using(ColocationUser::class)
            ->withPivot('group_role', 'left_at')
            ->wherePivotNull('left_at')
            ->withTimestamps();
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function getOwner()
    {
        return $this->users()
            ->wherePivot('group_role', 'owner')
            ->wherePivotNull('left_at')
            ->first();
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}