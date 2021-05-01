<?php

namespace App\Http\Controllers;

use App\Reportes;
use App\Aspirantes;
use App\User;
use App\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            $desdeFiltro = '2020-11-01 00:00';
            $hastaFiltro = '2020-11-05 23:59';

            
        } 

        //dd($desdeFiltro, $hastaFiltro);

        ##$results = [];
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'aspirante'){
            $results= Aspirantes::with('user')
            ->where('aspirantes.created_at','>=',$desdeFiltro)
            ->where('aspirantes.created_at','<=',$hastaFiltro)->orderBy('aspirantes.id', 'DESC')
            ->get();
            return view('reportes.postulantesxFecha.table',compact('results'));

            //return $result;
        }



    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reportes  $reportes
     * @return \Illuminate\Http\Response
     */
    public function show(Reportes $reportes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reportes  $reportes
     * @return \Illuminate\Http\Response
     */
    public function edit(Reportes $reportes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reportes  $reportes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reportes $reportes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reportes  $reportes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reportes $reportes)
    {
        //
    }
}
