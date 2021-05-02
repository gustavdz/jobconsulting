<?php

namespace App\Exports;

use App\Aspirantes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class AspirantesExport implements FromCollection, WithHeadings
{
    protected $desde;
    protected $hasta;

    function __construct($params) {
        $this->desde = $params['desde'];
        $this->hasta = $params['hasta'];
    }

    public function collection()
    {

        if($this->desde == '' || $this->hasta == ''){
            $results = DB::table('aspirantes')
                ->select('users.name','users.email','aspirantes.cedula','aspirantes.celular','aspirantes.telefono','aspirantes.fecha_nacimiento','aspirantes.pais','aspirantes.provincia','aspirantes.ciudad','aspirantes.remuneracion_actual','aspirantes.espectativa_salarial','aspirantes.created_at')
                ->leftJoin('users', 'users.id', '=', 'aspirantes.user_id')
                ->get();
        } else{

            $results = DB::table('aspirantes')
                ->select('users.name','users.email','aspirantes.cedula','aspirantes.celular','aspirantes.telefono','aspirantes.fecha_nacimiento','aspirantes.pais','aspirantes.provincia','aspirantes.ciudad','aspirantes.remuneracion_actual','aspirantes.espectativa_salarial','aspirantes.created_at')
                ->leftJoin('users', 'users.id', '=', 'aspirantes.user_id')
                ->where('aspirantes.created_at','>=',$this->desde.' 00:00:00')
                ->where('aspirantes.created_at','<=',$this->hasta.' 23:59:59')
                ->get();
        }

        return $results;
    }

    public function headings():array
    {
        return ["Nombre", "Email", "Cedula","Celular", "Telefono", "Fecha de Nacimiento","Pais", "Provincia", "Ciudad","Ingreso actual", "Salario Esperado", "Fecha de Registro",];
    }
}
