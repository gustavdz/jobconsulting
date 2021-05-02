<?php

namespace App\Http\Controllers;

use App\Reportes;
use App\Aspirantes;
use App\Aplicaciones;
use App\User;
use App\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Exports\AspirantesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reportes.index');
    }

    //reporte de postulantes
    public function postulantes_registros_mes()
    {


        return view('reportes.postulantesxFecha.postulantes_registros_mes');
    }


    public function dataPostulanteRegistro(Request $request)
    {
        $desdeFiltro = $request->desdeFiltro;
        $hastaFiltro = $request->hastaFiltro;

        if($desdeFiltro == null || $desdeFiltro == '00:00:00'|| $hastaFiltro == null || $hastaFiltro == '23:59:59'){
            //si no usa filtros poner aqui del dia actual (en local no pruebo asi porq la db no tiene)
            $desdeFiltro = '';
            $hastaFiltro = '';
        }
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'aspirante'){
            if($desdeFiltro=='' || $hastaFiltro==''){
                $results= Aspirantes::with('user')
                    ->get();
            } else {
                $results= Aspirantes::with('user')
                    ->where('aspirantes.created_at','>=',$desdeFiltro)
                    ->where('aspirantes.created_at','<=',$hastaFiltro)->orderBy('aspirantes.id', 'DESC')
                    ->get();
            }
            return view('reportes.postulantesxFecha.table',compact('results'));
        }
    }

    public function exportDataPostulanteRegistro(Request $request)
    {
        $desdeFiltro = $request->desdeFiltro;
        $hastaFiltro = $request->hastaFiltro;

        if($desdeFiltro == null || $desdeFiltro == '00:00:00'|| $hastaFiltro == null || $hastaFiltro == '23:59:59'){
            $desdeFiltro = '';
            $hastaFiltro = '';
        }
        return Excel::download(new AspirantesExport(['desde'=>$desdeFiltro,'hasta'=>$hastaFiltro]), 'aspirantes.xlsx',null,['name','name','name','name','name','name','name','name','name','name','name','registrado']);
    }

    //reporte de aplicaciones/registros

    public function aplicaciones_mes()
    {


        return view('reportes.aplicacionesxFecha.aplicaciones_mes');
    }


    public function dataAplicacionesRegistro(Request $request)
    {
        $desdeFiltro = $request->desdeFiltro;
        $hastaFiltro = $request->hastaFiltro;

        if($desdeFiltro == null || $desdeFiltro == '00:00:00'|| $hastaFiltro == null || $hastaFiltro == '23:59:59'){
            //si no usa filtros poner aqui del dia actual (en local no pruebo asi porq la db no tiene)
            $desdeFiltro = '2020-09-04 00:00';
            $hastaFiltro = '2020-09-04 23:59';


        }

        //dd($desdeFiltro, $hastaFiltro);

        ##$results = [];
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'aspirante'){
            $results=   Aplicaciones::select('aplicaciones.id','aplicaciones.salario_aspirado','aplicaciones.created_at' ,'ofertas.titulo as oferta','ofertas.salario','ofertas.ciudad','ofertas.provincia','ofertas.validez','ofertas.estado as ofertaestado','estado_ofertas.nombre as estadodeoferta','empresas.name as empresa', 'users.name as aspirante', 'users.email as correoaspirante', 'aspirantes.remuneracion_actual')
            ->join('aspirantes','aspirantes.id', '=', 'aplicaciones.aspirante_id')
            ->join('ofertas', 'ofertas.id', '=', 'aplicaciones.oferta_id')
            ->join('estado_ofertas', 'estado_ofertas.id', '=', 'aplicaciones.estado_oferta_id')
            ->join('users AS empresas', 'ofertas.empresa_id', '=', 'empresas.id')
            ->join('users', 'aspirantes.user_id', '=', 'users.id')
            ->where('aplicaciones.created_at','>=',$desdeFiltro)
            ->where('aplicaciones.created_at','<=',$hastaFiltro)->orderBy('aplicaciones.id', 'DESC')
            ->get();


            return view('reportes.aplicacionesxFecha.table',compact('results'));

            //return $result;
        }

    }
        //Reporte Postulantes Ofertas
        public function postulantes_ofertas()
    {


        return view('reportes.postulantesOfertasxFecha.postulantes_ofertas_mes');
    }



        public function dataPostulantesOfertasRegistro(Request $request)
    {
        $desdeFiltro = $request->desdeFiltro;
        $hastaFiltro = $request->hastaFiltro;

        if($desdeFiltro == null || $desdeFiltro == '00:00:00'|| $hastaFiltro == null || $hastaFiltro == '23:59:59'){
            //si no usa filtros poner aqui del dia actual (en local no pruebo asi porq la db no tiene)
            $desdeFiltro = '2020-09-04 00:00';
            $hastaFiltro = '2020-09-04 23:59';


        }

        //dd($desdeFiltro, $hastaFiltro);

        ##$results = [];
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'aspirante'){
            $results=   Aplicaciones::select('aplicaciones.id','aplicaciones.salario_aspirado','aplicaciones.created_at' ,'ofertas.titulo as oferta','ofertas.salario','ofertas.ciudad','ofertas.provincia','ofertas.validez','ofertas.estado as ofertaestado','estado_ofertas.nombre as estadodeoferta', 'users.name as aspirante', 'users.email as correoaspirante')
            ->join('aspirantes','aspirantes.id', '=', 'aplicaciones.aspirante_id')
            ->join('ofertas', 'ofertas.id', '=', 'aplicaciones.oferta_id')
            ->join('estado_ofertas', 'estado_ofertas.id', '=', 'aplicaciones.estado_oferta_id')
            ->join('users', 'aspirantes.user_id', '=', 'users.id')
            ->where('ofertas.estado', '=', 'A')
            ->where('aplicaciones.created_at','>=',$desdeFiltro)
            ->where('aplicaciones.created_at','<=',$hastaFiltro)->orderBy('aplicaciones.id', 'DESC')
            ->get();


            return view('reportes.postulantesOfertasxFecha.table',compact('results'));

            //return $result;
        }
    }
}
