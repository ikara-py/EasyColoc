<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'colocation_id', 
        'email', 
        'token', 
        'status'
    ];


    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function accept()
    {
        $this->update(['status' => 'accepted']);
    }

    public function decline()
    {
        $this->update(['status' => 'declined']);
    }
}