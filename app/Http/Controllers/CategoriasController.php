<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function index()
    {
    	if (Auth::user()->role != 'admin') { #solo administrador
            return redirect()->route('home');
        }
    	return view('categorias.index');
    }

    public function data(Request $request)
    {
    	$results = Categorias::where('estado','A')->get();
    	return view('categorias.table',compact('results'));
    }

    public function post(Request $request)
    {
    	$categoria = Categorias::find($request->id);

    	if (empty($categoria)) {
    		$categoria = new Categorias;
    		$categoria->nombre = $request->nombre;
    		$categoria->save();

    		$result = $categoria ? ['msg' => 'success', 'data' => 'Se ha creado correctamente la categoria ' . $request->nombre] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la categoría ' . $request->nombre];

            return response()->json($result);

    	}else{
    		$categoria->nombre = $request->nombre;
    		$categoria->save();
    		$result = $categoria ? ['msg' => 'success', 'data' => 'Se ha modificado correctamente la categoria ' . $request->nombre] : ['msg' => 'error', 'data' => 'Ocurrio un error al modificar la categoría ' . $request->nombre];

            return response()->json($result);
    	}
    }

    public function delete(Request $request)
    {
    	$categoria = Categorias::find($request->id);
		$categoria->estado = 'E';
		$categoria->save();

		$result = $categoria ? ['msg' => 'success', 'data' => 'Se ha creado eliminado la categoria ' ] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la categoría '];

        return response()->json($result);

    	
    }
}
