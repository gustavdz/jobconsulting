<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriasOfertas extends Model
{
    protected $table = 'categorias_ofertas';

    protected $fillable = [
        'categoria_id', 'oferta_id'
    ];

	//uno a muchos
    public function categoria() {
		return $this->belongsTo(Categorias::class, 'categoria_id');
	}

	//pertnece
    public function ofertas() {
		return $this->belongsTo(Ofertas::class,'oferta_id');
	}
}
