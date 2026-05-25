<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesion extends Model
{
    protected $table = 'lesiones';
    
    protected $fillable = [
        'mascota_id',
        'tipo',
        'descripcion',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
