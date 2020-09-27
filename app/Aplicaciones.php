<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aplicaciones extends Model
{
    protected $table = "aplicaciones";

    public function aspirante()
    {
    	return $this->belongsTo(Aspirantes::class);
    }

    public function oferta()
    {
    	return $this->belongsTo(Ofertas::class);
    }

    public function estado_oferta()
    {
    	return $this->belongsTo(EstadoOferta::class);
    }
}
