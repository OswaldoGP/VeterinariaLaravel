<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    protected $fillable = [
        'user_id',
        'especialidad',
        'telefono',
        'cedula_profesional',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
