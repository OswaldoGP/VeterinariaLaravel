<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimentacion extends Model
{
    protected $table = 'alimentaciones';
    
    protected $fillable = [
        'mascota_id',
        'alimento',
        'cantidad',
        'frecuencia',
        'observaciones',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
