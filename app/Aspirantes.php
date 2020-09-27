<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aspirantes extends Model
{
    protected $table = "aspirantes";

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function aspirante_experiencia()
    {
    	return $this->hasMany(AspiranteExperiencia::class,'aspirante_id');
    }

    public function aspirante_formacion()
    {
    	return $this->hasMany(AspiranteFormacion::class,'aspirante_id');
    }

    public function aspirante_idioma()
    {
    	return $this->hasMany(AspiranteIdioma::class,'aspirante_id');
    }

    public function aspirante_referencia()
    {
    	return $this->hasMany(AspiranteReferencia::class,'aspirante_id');
    }


}
