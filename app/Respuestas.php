<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    //
	public function pregunta()
	{
		return $this->belongsTo(Preguntas::class);
	}
}
