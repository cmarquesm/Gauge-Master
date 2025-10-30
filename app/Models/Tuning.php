<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuning extends Model
{
    use HasFactory;

    // Los atributos que se pueden asignar en masa
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


    // Relación: una afinación pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
