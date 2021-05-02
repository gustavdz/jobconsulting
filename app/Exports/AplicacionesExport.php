<?php

namespace App\Exports;

use App\Aplicaciones;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AplicacionesExport implements FromCollection, WithHeadings
{
    protected $desde;
    protected $hasta;

    function __construct($params) {
        $this->desde = $params['desde'];
        $this->hasta = $params['hasta'];
    }

    public function collection(){

        if($this->desde == '' || $this->hasta == ''){
            $results=   Aplicaciones::select('empresas.name as empresa','ofertas.titulo as oferta','ofertas.salario','ofertas.provincia',
                'ofertas.ciudad','ofertas.validez','estado_ofertas.nombre as estadodeoferta','users.name as aspirante','aspirantes.remuneracion_actual',
                'users.email as correoaspirante', 'aspirantes.celular', 'aspirantes.telefono','aplicaciones.created_at')
                ->join('aspirantes','aspirantes.id', '=', 'aplicaciones.aspirante_id')
                ->join('ofertas', 'ofertas.id', '=', 'aplicaciones.oferta_id')
                ->join('estado_ofertas', 'estado_ofertas.id', '=', 'aplicaciones.estado_oferta_id')
                ->join('users AS empresas', 'ofertas.empresa_id', '=', 'empresas.id')
                ->join('users', 'aspirantes.user_id', '=', 'users.id')
                ->orderBy('aplicaciones.id', 'ASC')
                ->get();
        } else{
            $results=   Aplicaciones::select('empresas.name as empresa','ofertas.titulo as oferta','ofertas.salario','ofertas.provincia',
                'ofertas.ciudad','ofertas.validez','estado_ofertas.nombre as estadodeoferta','users.name as aspirante','aspirantes.remuneracion_actual',
                'users.email as correoaspirante', 'aspirantes.celular', 'aspirantes.telefono','aplicaciones.created_at')
                ->join('aspirantes','aspirantes.id', '=', 'aplicaciones.aspirante_id')
                ->join('ofertas', 'ofertas.id', '=', 'aplicaciones.oferta_id')
                ->join('estado_ofertas', 'estado_ofertas.id', '=', 'aplicaciones.estado_oferta_id')
                ->join('users AS empresas', 'ofertas.empresa_id', '=', 'empresas.id')
                ->join('users', 'aspirantes.user_id', '=', 'users.id')
                ->where('aplicaciones.created_at','>=',$this->desde)
                ->where('aplicaciones.created_at','<=',$this->hasta)
                ->orderBy('aplicaciones.id', 'ASC')
                ->get();
        }

        return $results;
    }

    public function headings():array{
        return ["Consultor", "Oferta", "Salario de Oferta","Provincia de Oferta", "Ciudad de Oferta", "Validez de Oferta","Estado de Oferta", "Aspirante", "Remuneración Actual de Aspirante","Correo de Aspirante", "Celular de Aspirante", "Teléfono de Aspirante", "Fecha de Aplicación",];
    }
}
