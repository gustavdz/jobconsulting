<?php

namespace App\Http\Controllers;

use App\Aspirantes;
use App\Ofertas;
use App\Categorias;
use App\User;
use App\AspiranteFormacion;
use App\AspiranteIdioma;
use App\AspiranteReferencia;
use App\AspiranteExperiencia;
use App\Aplicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AspirantesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'empresa') {
            return redirect()->route('home');
        }
    	$aspirante = Aspirantes::with('user')->with('aspirante_experiencia')->with('aspirante_formacion')->with('aspirante_idioma')->with('aspirante_referencia')->where('user_id',Auth::user()->id)->first();
    	//return $aspirante;
    	return view('aspirante.index',compact('aspirante'));
    }

    public function perfil(Request $request)
    {	
		$foto = $request->file('foto');
    	$cv = $request->file('cv');

    	if (!empty($foto)) {
            if ($foto->getSize()>3000000) {
                return response()->json(['msg' => 'error', 'data' => 'La foto de perfil no puede pesar más de 3MB']);
            }

            if ($foto->extension()=='jpg' || $foto->extension()=='png' || $foto->extension()=='jpeg' || $foto->extension()=='JPEG' || $foto->extension()=='JPG' || $foto->extension()=='PNG') {
                $foto->storeAs('public/perfil',Auth::user()->id.'.jpg');
            }else{
                return response()->json(['msg' => 'error', 'data' => 'Las extensiones permitidas para la foto de perfil es jpg, jpeg, png']);
            }
    	}

    	if (!empty($cv)) {
            if ($cv->getSize()>5000000) {
                return response()->json(['msg' => 'error', 'data' => 'La hoja de vida no puede pesar más de 5MB']);
            }
            if ($cv->extension()=='pdf') {
    		    $cv->storeAs('public/cv',Auth::user()->id.'.pdf');
            }else{
                return response()->json(['msg' => 'error', 'data' => 'La hoja de vida debe ser en formato PDF']);
            }
    	}

    	DB::beginTransaction();

    	$aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();

    	if(empty($aspirante)){
    		$aspirante = new Aspirantes;
    		$aspirante->user_id = Auth::user()->id;
    		$aspirante->fecha_nacimiento = $request->fecha_nacimiento;
            $aspirante->cedula = $request->cedula;
    		$aspirante->telefono = $request->telefono;
    		$aspirante->celular = $request->celular;
    		$aspirante->pais = $request->pais;
    		$aspirante->provincia = $request->provincia;
    		$aspirante->ciudad = $request->ciudad;
    		$aspirante->remuneracion_actual = $request->remuneracion_actual;
    		$aspirante->espectativa_salarial = $request->espectativa_salarial;
    		$aspirante->save();

    	}else{
    		$aspirante->fecha_nacimiento = $request->fecha_nacimiento;
            $aspirante->cedula = $request->cedula;
    		$aspirante->telefono = $request->telefono;
    		$aspirante->celular = $request->celular;
    		$aspirante->pais = $request->pais;
    		$aspirante->provincia = $request->provincia;
    		$aspirante->ciudad = $request->ciudad;
    		$aspirante->remuneracion_actual = $request->remuneracion_actual;
    		$aspirante->espectativa_salarial = $request->espectativa_salarial;
    		$aspirante->save();
    	}
    		$user = User::find(Auth::user()->id);
    		$user->name = $request->nombres;
    		$user->email = $request->correo;
    		$user->save();

    		DB::commit();

    	$result = $aspirante ? ['msg' => 'success', 'data' => 'Se ha actualizado la información de datos personales correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información '];

        return response()->json($result);	
    }

    public function viewFormacion(Request $request)
    {
        $formaciones = [];
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (!empty($aspirante)) {
    	   $formaciones = AspiranteFormacion::where('aspirante_id',$aspirante->id)->get();
        }

    	return view('aspirante.academica',compact('formaciones'));
    }

    public function formacion(Request $request)
    {
        
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        //return $aspirante->id;
        if (empty($aspirante)) {
            return response()->json(['msg' => 'error', 'data' => 'Primero debe completar sus datos personales']);
        }

    	$formacion = AspiranteFormacion::find($request->formacion_id);
    	
    	if (empty($formacion)) {
    		$formacion = new AspiranteFormacion;
    		$formacion->aspirante_id = $aspirante->id;
    		$formacion->institucion_educativa = $request->institucion;
    		$formacion->titulo = $request->titulo;
    		$formacion->inicio = $request->inicio_formacion;
    		$formacion->fin = $request->fin_formacion;
    		$formacion->save();
    	}else{
    		$formacion->institucion_educativa = $request->institucion;
    		$formacion->titulo = $request->titulo;
    		$formacion->inicio = $request->inicio_formacion;
    		$formacion->fin = $request->fin_formacion;
    		$formacion->save();
    	}

    	$result = $formacion ? ['msg' => 'success', 'data' => 'Se ha actualizado la información de datos academicos correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información '];

    	return response()->json($result);

    }

    public function viewIdioma(Request $request)
    {
        $idiomas = [];
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (!empty($aspirante)) {
           $idiomas = AspiranteIdioma::where('aspirante_id',$aspirante->id)->get();
        }
    	//return $idiomas;
    	return view('aspirante.idioma',compact('idiomas'));
    }

    public function idioma(Request $request)
    {
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (empty($aspirante)) {
            return response()->json(['msg' => 'error', 'data' => 'Primero debe completar sus datos personales']);
        }

    	$idioma = AspiranteIdioma::find($request->idioma_id);
    	
    	if (empty($idioma)) {
    		$idioma = new AspiranteIdioma;
    		$idioma->aspirante_id = $aspirante->id;
    		$idioma->idioma = $request->idioma;
    		$idioma->nivel = $request->nivel;
    		$idioma->save();
    	}else{
    		$idioma->idioma = $request->idioma;
    		$idioma->nivel = $request->nivel;
    		$idioma->save();
    	}

    	$result = $idioma ? ['msg' => 'success', 'data' => 'Se ha actualizado la información de Idiomas correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información '];

    	return response()->json($result);

    }

    public function viewReferencia(Request $request)
    {
        $referencias = [];
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (!empty($aspirante)) {
           $referencias = AspiranteReferencia::where('aspirante_id',$aspirante->id)->get();
        }
    	
    	//return $idiomas;
    	return view('aspirante.referencia',compact('referencias'));
    }

    public function referencia(Request $request)
    {
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (empty($aspirante)) {
            return response()->json(['msg' => 'error', 'data' => 'Primero debe completar sus datos personales']);
        }

    	$referencia = AspiranteReferencia::find($request->referencia_id);
    	
    	if (empty($referencia)) {
    		$referencia = new AspiranteReferencia;
    		$referencia->aspirante_id = $aspirante->id;
    		$referencia->nombre = $request->nombres_referencia;
    		$referencia->email = $request->correo_referencia;
    		$referencia->telefono = $request->telefono_referencia;
    		$referencia->save();
    	}else{
    		$referencia->nombre = $request->nombres_referencia;
    		$referencia->email = $request->correo_referencia;
    		$referencia->telefono = $request->telefono_referencia;
    		$referencia->save();
    	}

    	$result = $referencia ? ['msg' => 'success', 'data' => 'Se ha actualizado la información de referencias correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información '];

    	return response()->json($result);

    }

    public function viewExperencia(Request $request)
    {
        $experiencias = [];
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (!empty($aspirante)) {
          $experiencias = AspiranteExperiencia::where('aspirante_id',$aspirante->id)->get();
        }
    	//return $idiomas;
    	return view('aspirante.experiencia',compact('experiencias'));
    }

    public function experencia(Request $request)
    {
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (empty($aspirante)) {
            return response()->json(['msg' => 'error', 'data' => 'Primero debe completar sus datos personales']);
        }
    	$experiencia = AspiranteExperiencia::find($request->experiencia_id);
    	
    	if (empty($experiencia)) {
    		$experiencia = new AspiranteExperiencia;
    		$experiencia->aspirante_id = $aspirante->id;
    		$experiencia->empresa = $request->empresa;
    		$experiencia->inicio = $request->inicio_experiencia;
    		$experiencia->fin = $request->fin_experiencia;
    		$experiencia->sector = $request->sector;
    		$experiencia->cargo = $request->cargo;
    		$experiencia->funciones = $request->funciones;
    		$experiencia->personal_cargo = $request->personal;
    		$experiencia->save();
    	}else{
    		$experiencia->empresa = $request->empresa;
    		$experiencia->inicio = $request->inicio_experiencia;
    		$experiencia->fin = $request->fin_experiencia;
    		$experiencia->sector = $request->sector;
    		$experiencia->cargo = $request->cargo;
    		$experiencia->funciones = $request->funciones;
    		$experiencia->personal_cargo = $request->personal;
    		$experiencia->save();
    	}

    	$result = $experiencia ? ['msg' => 'success', 'data' => 'Se ha actualizado la información de experiencias correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información '];

    	return response()->json($result);

    }

     public function postulaciones()
    {
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        $postulaciones =[];
        if (!empty($aspirante)) {
            $postulaciones = Aplicaciones::with('aspirante')->has('oferta')->with('estado_oferta')->with('oferta.user')->where('aspirante_id',$aspirante->id)->orderBy('aplicaciones.created_at', 'DESC')->paginate(5);
        }
        #return $postulaciones;
        return view('aspirante.postulaciones',compact('postulaciones'));

    }

    public function formacion_delete(Request $request)
    {
        $formacion = AspiranteFormacion::find($request->id)->delete();
        $result = $formacion ? ['msg' => 'success', 'data' => 'Se ha elimado correctamente la formación academica'] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la información ']; 
        return response()->json($result);
    }

    public function experiencia_delete(Request $request)
    {
        $experiencia = AspiranteExperiencia::find($request->id)->delete();
        $result = $experiencia ? ['msg' => 'success', 'data' => 'Se ha elimado correctamente la información'] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la información ']; 
        return response()->json($result);
    }

    public function idioma_delete(Request $request)
    {
        $idioma = AspiranteIdioma::find($request->id)->delete();
        $result = $idioma ? ['msg' => 'success', 'data' => 'Se ha elimado correctamente la información'] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la información ']; 
        return response()->json($result);
    }

    public function referencia_delete(Request $request)
    {
        $referencia = AspiranteReferencia::find($request->id)->delete();
        $result = $referencia ? ['msg' => 'success', 'data' => 'Se ha elimado correctamente la información'] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la información ']; 
        return response()->json($result);
    }

    public function search(Request $request){
        $allCategories = Categorias::where('estado','A')->get();
        $cat = Categorias::where('nombre','like',"%$request->search%")->first();
        $id_cate = $cat ? $cat->id : '';
        $empresa = User::where('name','like',"%$request->search%")->where('role','empresa')->first();
        $id_empresa = $empresa ? $empresa->id : '';
        $ofertas=Ofertas::with('user')->whereHas('categoriasOfertas.categoria', function ($query)use(&$id_cate) {
                            $query->where('categoria_id',$id_cate);
                        })->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->where('ofertas.validez','>',Carbon::now())
        ->orWhere('ofertas.empresa_id',$id_empresa)
        ->orWhere('ofertas.salario',$request->search)
        ->orWhere('ofertas.titulo',$request->search)
        ->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC')->paginate(9);

        return view('home_aspirante.index',compact('ofertas','allCategories'));
    }
}
