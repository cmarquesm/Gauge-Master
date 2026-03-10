<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuning extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'name',
        'material',
        'notes',
        'gauges',
        'tensions',
        'total_tension',
        'description',
    ];


    // Relationship: tuning belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
