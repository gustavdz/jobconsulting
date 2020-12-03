<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AspiranteFormacion extends Model
{
     protected $table = "aspirante_formacion";

     public function oferta_academica()
     {
     	return $this->belongsTo(OfertaAcademica::class);
     }
}
