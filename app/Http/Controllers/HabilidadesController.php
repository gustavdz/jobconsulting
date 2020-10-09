<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Habilidades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HabilidadesController extends Controller
{
    public function index()
    {
    	if (Auth::user()->role != 'admin') { #solo administrador
            return redirect()->route('home');
        }
    	return view('habilidades.index');
    }

    public function data(Request $request)
    {
    	$results = Habilidades::where('estado','A')->get();
    	return view('habilidades.table',compact('results'));
    }

    public function post(Request $request)
    {
    	$habilidad = Habilidades::find($request->id);

    	if (empty($habilidad)) {
    		$habilidad = new Habilidades;
    		$habilidad->nombre = $request->nombre;
    		$habilidad->save();

    		$result = $habilidad ? ['msg' => 'success', 'data' => 'Se ha creado correctamente la habilidad ' . $request->nombre] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la Habilida ' . $request->nombre];

            return response()->json($result);

    	}else{
    		$habilidad->nombre = $request->nombre;
    		$habilidad->save();
    		$result = $habilidad ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente la habilidad ' . $request->nombre] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificar la Habilidad ' . $request->nombre];

            return response()->json($result);
    	}
    }

    public function delete(Request $request)
    {
    	$habilidad = Habilidades::find($request->id);
		$habilidad->estado = 'E';
		$habilidad->save();

		$result = $habilidad ? ['msg' => 'success', 'data' => 'Se ha creado eliminado la habilidad ' ] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la Habilidad '];

        return response()->json($result);

    	
    }
}
