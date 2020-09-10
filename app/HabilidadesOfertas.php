<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HabilidadesOfertas extends Model
{
     protected $table = 'habilidades_ofertas';

     protected $fillable = [
        'habilidad_id', 'oferta_id'
    ];

     //uno a muchos
    public function habilidad() {
		return $this->belongsTo(Habilidades::class, 'habilidad_id');
	}
}
