<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ofertas extends Model
{
    protected $table = "ofertas";

    protected $fillable = [
        'empresa_id', 'titulo','descripcion','salario','validez','estado'
    ];

	//pertnece
    public function user() {
		return $this->belongsTo(User::class,'empresa_id');
	}

	//uno a muchos
    public function categoriasOfertas() {
		return $this->hasMany(CategoriasOfertas::class, 'oferta_id');
	}

	//uno a muchos
    public function habilidadesOfertas() {
		return $this->hasMany(HabilidadesOfertas::class, 'oferta_id');
	}
}
