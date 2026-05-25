<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patologia extends Model
{
    protected $table = 'patologias';
    
    protected $fillable = [
        'mascota_id',
        'nombre',
        'descripcion',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
