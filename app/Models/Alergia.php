<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergia extends Model
{
    protected $table = 'alergias';
    
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
