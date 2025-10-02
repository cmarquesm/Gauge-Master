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
        'instrument_type',
        'tuning_1',
        'tuning_2',
        'tuning_3',
        'tuning_4',
        'tuning_5',
        'tuning_6',
    ];

    // Relación: una afinación pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
