<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ColocationUser extends Pivot
{
    protected $table = 'colocation_user';
    
    protected $fillable = [
        'user_id', 
        'colocation_id', 
        'group_role', 
        'left_at'
    ];

    protected function casts(): array
    {
        return [
            'left_at' => 'datetime',
        ];
    }
}