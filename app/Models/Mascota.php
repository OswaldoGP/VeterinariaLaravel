<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Mascota extends Model
{
    use Searchable;
    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
    ];

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function alergias()
    {
        return $this->hasMany(Alergia::class);
    }

    public function lesiones()
    {
        return $this->hasMany(Lesion::class);
    }

    public function patologias()
    {
        return $this->hasMany(Patologia::class);
    }

    public function alimentaciones()
    {
        return $this->hasMany(Alimentacion::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => (string) $this->id,
            'nombre' => $this->nombre,
            'dueno_nombre' => $this->dueno ? $this->dueno->nombre_completo : '',
        ];
    }
}
