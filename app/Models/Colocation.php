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

    public function getUserBalance($userId)
    {
        $totalMembers = $this->users()->count();

        if ($totalMembers === 0) {
            return 0;
        }

        $totalHouseExpenses = $this->expenses()->whereNull('date')->sum('amount');
        $fairShare = $totalHouseExpenses / $totalMembers;

        $userPaidForExpenses = $this->expenses()->whereNull('date')->where('paid_by', $userId)->sum('amount');

        $userSentSettlements = $this->settlements()->where('payer_id', $userId)->sum('amount');

        $userReceivedSettlements = $this->settlements()->where('payee_id', $userId)->sum('amount');

        $totalGiven = $userPaidForExpenses + $userSentSettlements;
        $totalConsumed = $fairShare + $userReceivedSettlements;

        return $totalGiven - $totalConsumed;
    }
}