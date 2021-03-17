<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use App\Categorias;
use App\Habilidades;
use App\Aspirantes;
use App\Aplicaciones;
use App\CategoriasOfertas;
use App\HabilidadesOfertas;
use App\EstadoOferta;
use App\OfertaAcademica;
use App\Respuestas;
use App\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PHPUnit\Util\Json;
use function MongoDB\BSON\toJSON;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OfertasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexAPI(Request $request) {
        if($request->search){
            $search=$request->search;
        }else{
            $search="";
        }

        $ofertas = Ofertas::with('user')
            ->with('categoriasOfertas.categoria')
            ->with('habilidadesOfertas.habilidad')
            ->where('ofertas.estado','A')
            ->where(function ($query) use ($search) {
                $query->where('titulo', 'LIKE', '%'.$search.'%');
                    //->orWhere('content', 'LIKE', '%'.$search.'%');
            })
            ->orderBy('ofertas.created_at', 'DESC')
            ->orderBy('ofertas.validez', 'DESC')
            ->orderBy('ofertas.id', 'DESC')
            ->paginate(10);
        return $ofertas;
    }

    public function showAPI(Request $request) {
        $ofertas = Ofertas::with('user')
            ->with('categoriasOfertas.categoria')
            ->with('habilidadesOfertas.habilidad')
            ->where('ofertas.estado','A')
            ->where('ofertas.id',$request->id)
            ->orderBy('ofertas.validez', 'DESC')
            ->orderBy('ofertas.id', 'DESC')
            ->get();
        return $ofertas;
    }

    public function index()
    {

        if (Auth::user()->role == 'aspirante') {
            return redirect()->route('home');
        }
        $categorias = Categorias::where('estado','A')->get();
        $habilidades = Habilidades::where('estado','A')->get();
        $empresas = User::where('role','empresa')->get();
        return view('ofertas.index',compact('categorias','habilidades','empresas'));
    }

    public function data()
    {
        ##$results = [];
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'aspirante'){
            return datatables()
            ->eloquent(Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','<>','E')->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC'))
            ->addColumn('detalle','ofertas.detalle') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('categorias','ofertas.categorias') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('habilidades','ofertas.habilidades') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','ofertas.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->rawColumns(['detalle','categorias','habilidades','opciones']) #opcion para que presente el HTML
            ->toJson();
        }
        if (Auth::user()->role == 'empresa'){
            return datatables()
            ->eloquent(Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','<>','E')->where('ofertas.empresa_id',Auth::user()->id)->orderBy('ofertas.id', 'DESC'))
            ->addColumn('detalle','ofertas.detalle') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('categorias','ofertas.categorias') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('habilidades','ofertas.habilidades') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','ofertas.opciones_consultores') #detalle o llave a recibir en el JS y segundo campo la vista
            ->rawColumns(['detalle','categorias','habilidades','opciones']) #opcion para que presente el HTML
            ->toJson();
        }


    }




    public function store(Request $request)
    {
      try {
            DB::beginTransaction();
            if (empty($request->id)) { # Id oferta es vacio se crea

                $ofertas = new Ofertas;
                $ofertas->titulo = $request->titulo;
                $ofertas->descripcion = $request->descripcion;
                $ofertas->validez =  $request->validez;
                $ofertas->salario = $request->salario;
                $ofertas->ciudad = $request->ciudad;
                $ofertas->provincia = $request->provincia;
                $ofertas->empresa_id = Auth::user()->role=='admin' ? $request->empresa : Auth::user()->id;
                $ofertas->save();

                if (!empty($ofertas)) {
                    foreach ($request->categorias as $key => $value) {
                        $categoria_oferta = new CategoriasOfertas;
                        $categoria_oferta->categoria_id = $value;
                        $categoria_oferta->oferta_id = $ofertas->id;
                        $categoria_oferta->save();
                    }
                    foreach ($request->habilidades as $key => $value) {
                        $habilidad = Habilidades::find($value);
                        if (empty($habilidad)) { ##no existe lo creo
                           $habilidad = new Habilidades;
                           $habilidad->nombre = $value;
                           $habilidad->save();
                        }
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $habilidad->id;
                        $habilidad_oferta->oferta_id = $ofertas->id;
                        $habilidad_oferta->save();
                    }
                }

                $activar = Configuracion::find(1);
                if ($activar->social_media == 'A') { #debe estar activa para publicar
                    $this->publicPostFB($request,$ofertas->id);
                    $this->publicPostTW($request,$ofertas->id);
                }
                DB::commit();

                $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha creado correctamente la Oferta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la Oferta ' . $request->titulo];

                return response()->json($result);

            }else{ # id oferta contine valor se edita
                $ofertas = Ofertas::find($request->id);
                $ofertas->titulo = $request->titulo;
                $ofertas->descripcion = $request->descripcion;
                $ofertas->validez =  $request->validez;
                $ofertas->salario = $request->salario;
                $ofertas->ciudad = $request->ciudad;
                $ofertas->provincia = $request->provincia;
                $ofertas->empresa_id = Auth::user()->role=='admin' ? $request->empresa : Auth::user()->id;
                $ofertas->save();

                if (!empty($ofertas)) {
                    CategoriasOfertas::where('oferta_id',$request->id)->delete();
                    foreach ($request->categorias as $key => $value) {
                        $categoria_oferta = new CategoriasOfertas;
                        $categoria_oferta->categoria_id = $value;
                        $categoria_oferta->oferta_id = $ofertas->id;
                        $categoria_oferta->save();
                    }
                    HabilidadesOfertas::where('oferta_id',$request->id)->delete();
                    foreach ($request->habilidades as $key => $value) {
                        $habilidad = Habilidades::find($value);
                        if (empty($habilidad)) { ##no existe lo creo
                           $habilidad = new Habilidades;
                           $habilidad->nombre = $value;
                           $habilidad->save();
                        }
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $habilidad->id;
                        $habilidad_oferta->oferta_id = $ofertas->id;
                        $habilidad_oferta->save();
                    }
                }

                DB::commit();

                $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha editado la Oferta ' . $request->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al editar la Oferta ' . $request->titulo];

                return response()->json($result);
            }

      } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
      }
    }


    public function show(Request $request)
    {
        return Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->with('preguntas')->where('ofertas.id',$request->id)->first();
    }

    public function detalle(Request $request)
    {
        $datos = Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.id',$request->id)->first();
        //dd($datos);
        return view('aspirante.oferta', compact('datos'));
    }

    public function delete(Request $request)
    {
        $ofertas = Ofertas::find($request->id);
        $ofertas->estado = $request->estado; //Eliminado
        $ofertas->save();

        $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha cambiado el estado la Oferta ' . $ofertas->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al cambiar el estado la Oferta ' . $ofertas->titulo];

        return response()->json($result);
    }

    public function ofertaCategoria($id)
    {
        //DB::enableQueryLog(); // Enable query log
         $allCategories = Categorias::where('estado','A')->get();
        $ofertas=Ofertas::with('user')->whereHas('categoriasOfertas.categoria', function ($query)use(&$id) {
                            $query->where('categoria_id',$id);
                        })->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->where('ofertas.validez','>',Carbon::now())->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC')->paginate(9);

        //return DB::getQueryLog(); // Show results of log
        return view('home_aspirante.index',compact('ofertas','allCategories'));
    }

    public function postulacion(Request $request)
    {
        try {
            DB::beginTransaction();
            $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
            if (empty($aspirante)) {
                return response()->json(['msg' => 'error', 'data' => 'Debe actualizar su Currículum, para realizar la postulación']);
            }

            $verificarOferta = Ofertas::with('preguntas')->find($request->oferta_id);
            //'2020-10-24' < '2020-10-24'
            if ($verificarOferta->validez < date('Y-m-d') || $verificarOferta->estado != 'A') {
                return response()->json(['msg' => 'error', 'data' => 'La oferta se encuentra expirada']);
            }

            $oferta = Aplicaciones::where('aspirante_id',$aspirante->id)->where('oferta_id',$request->oferta_id)->first();
            if (empty($oferta)) {
                if (!empty($verificarOferta->preguntas)) { #verificar si existen preguntas en la oferta
                    foreach ($verificarOferta->preguntas as $key => $pregunta) {
                        $campo = 'campo_'.$pregunta->id;
                        if (empty($request[$campo])) {
                            return response()->json(['msg' => 'error', 'data' => 'La pregunta '.$pregunta->texto. ' es obligatoria']); 
                        }
                    }
                }
                $postulacion = new Aplicaciones;
                $postulacion->oferta_id = $request->oferta_id;
                $postulacion->aspirante_id = $aspirante->id;
                $postulacion->estado_oferta_id = 1;
                $postulacion->salario_aspirado = $request->salario;
                $postulacion->save();

                if (!empty($verificarOferta->preguntas)) { #verificar si existen preguntas en la oferta
                    foreach ($verificarOferta->preguntas as $key => $pregunta) {
                        $campo = 'campo_'.$pregunta->id;
                        $respuesta = new Respuestas;
                        $respuesta->aplicaciones_id = $postulacion->id;
                        $respuesta->pregunta_id = $pregunta->id;
                        $respuesta->respuesta = $request[$campo];
                        $respuesta->save();
                    }
                }

                
                DB::commit();

                $result = $postulacion ? ['msg' => 'success', 'data' => 'Se ha postulado correctamente a la oferta ' ] : ['msg' => 'error', 'data' => 'Ocurrio un error al postular la Oferta '];

                return response()->json($result);
            }else{
                return response()->json(['msg' => 'error', 'data' => 'Ya se encuentra una postulación registrada con sus datos']);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }
        
    }

    public function ofertaDetalle($id)
    {
        if (Auth::user()->role == 'aspirante') {
            return redirect()->route('home');
        }
        $oferta = Ofertas::with('user')->with('preguntas')->where('id',$id)->first();
        $grado_academico = OfertaAcademica::all();
        $paises = Aspirantes::select('pais')->distinct()->get();
        $provincias = Aspirantes::select('provincia')->distinct()->get();
        $ciudades = Aspirantes::select('ciudad')->distinct()->get();
        return view('aplicaciones.index',compact('oferta','grado_academico','paises','provincias','ciudades'));
    }

    public function aplicaciones(Request $request)
    {
        if ($request->oferta_id > 0) { #filtro
            
            $preguntas = Ofertas::with('preguntas')->find($request->oferta_id);

            $aplicaciones = '';
            if (count($preguntas->preguntas) > 0) { #si la oferta tiene preguntas
               //DB::enableQueryLog();
                $aplicaciones = Aplicaciones::with('aspirante')
                            ->with(['aspirante' => function($query) use ($request){
                                 if ($request->edad || $request->edad_max) {
                                        if (empty($request->edad_max)) {
                                           $query->where('fecha_nacimiento','>=',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-01-01'); 
                                        }else{
                                            if (empty($request->edad) || $request->edad == 0) {
                                                $query->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y") .'-12-31']);         
                                            }else{
                                                $query->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-12-31']);   
                                            }
                                        }
                                    }else{
                                        $query;
                                    }
                            }])
                            ->with(['aspirante'=> function ($query) use ($request) {
                                                                if ($request->pais) {
                                                                    $query->where('pais',$request->pais);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with(['aspirante'=> function ($query) use ($request) {
                                                                if ($request->provincia) {
                                                                    $query->where('provincia',$request->provincia);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with(['aspirante'=> function ($query) use ($request) {
                                                                if ($request->ciudad) {
                                                                    $query->where('ciudad',$request->ciudad);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('aspirante.user')
                            ->with('aspirante.aspirante_formacion')
                            ->with(['aspirante.aspirante_formacion'=> function ($query) use ($request) {
                                                                if ($request->grado != -1) {
                                                                    $query->where('oferta_academica_id',$request->grado);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('aspirante.aspirante_experiencia')
                            ->with(['aspirante.aspirante_experiencia'=> function ($query) use ($request) {
                                                                if ($request->cargo) {
                                                                    $query->where('cargo','like','%'.$request->cargo.'%');   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('respuesta')
                            ->with('respuesta.pregunta')
                            ->with(['respuesta'=> function ($query) use ($request,$preguntas) {
                                                                if ($preguntas->preguntas) {
                                                                    foreach ($preguntas->preguntas as $key => $value) {
                                                                        $campo = 'campo_'.$value->id;
                                                                        if ($request[$campo]) {
                                                                            if ($value->campo=='select') {
                                                                                $query->where('respuesta',$request[$campo]); 
                                                                            }else{
                                                                                $query->where('respuesta','like','%'.$request[$campo].'%'); 
                                                                            }
                                                                        }else{
                                                                            $query;
                                                                        }
                                                                    }
                                                                      
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('oferta')
                            ->with('estado_oferta')
                            ->where('oferta_id',$request->oferta_id);
                            if ($request->salario || $request->salario_max) {
                                if (empty($request->salario_max)) {
                                    $aplicaciones = $aplicaciones->where('salario_aspirado','>=',$request->salario); 
                                }else{
                                    $aplicaciones = $aplicaciones->whereBetween('salario_aspirado',[$request->salario ?? 0,$request->salario_max]); 
                                }
                            }

                    $aplicaciones = $aplicaciones->get();
                  //return DB::getQueryLog();
            }else{
                 // DB::enableQueryLog();
                $aplicaciones = Aplicaciones::with('aspirante')
                            ->with('aspirante')
                            ->with(['aspirante' => function($query) use ($request){
                                 if ($request->edad || $request->edad_max) {
                                        if (empty($request->edad_max)) {
                                           $query->where('fecha_nacimiento','>=',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-01-01'); 
                                        }else{
                                            if (empty($request->edad) || $request->edad == 0) {
                                                $query->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y") .'-12-31']);         
                                            }else{
                                                $query->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-12-31']);   
                                            }
                                        }
                                    }else{
                                        $query;
                                    }
                            }])
                            /*->whereHas('aspirante', function ($query) use ($request) {
                                    
                                })*/
                            ->with(['aspirante' => function($query) use ($request){
                                 if ($request->pais) {
                                        $query->where('pais',$request->pais);   
                                    }else{
                                        $query;
                                    }
                            }])
                            /*->whereHas('aspirante', function ($query) use ($request) {
                                    if ($request->pais) {
                                        $query->where('pais',$request->pais);   
                                    }else{
                                        $query;
                                    }
                                })*/
                            ->with(['aspirante' => function($query) use ($request){
                                  if ($request->provincia) {
                                        $query->where('provincia',$request->provincia);   
                                    }else{
                                        $query;
                                    }
                            }])
                            /*->whereHas('aspirante', function ($query) use ($request) {
                                    if ($request->provincia) {
                                        $query->where('provincia',$request->provincia);   
                                    }else{
                                        $query;
                                    }
                                })*/
                            ->with(['aspirante'=> function ($query) use ($request) {
                                                                if ($request->ciudad) {
                                                                    $query->where('ciudad',$request->ciudad);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('aspirante.user')
                            //->with('aspirante.aspirante_formacion')
                            ->with(['aspirante.aspirante_formacion'=> function ($query) use ($request) {
                                                                if ($request->grado != -1) {
                                                                    $query->where('oferta_academica_id',$request->grado);   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            //->with('aspirante.aspirante_experiencia')
                            ->with(['aspirante.aspirante_experiencia'=> function ($query) use ($request) {
                                                                if ($request->cargo) {
                                                                    $query->where('cargo','like','%'.$request->cargo.'%');   
                                                                }else{
                                                                    $query;
                                                                }
                                                            }])
                            ->with('oferta')
                            ->with('estado_oferta')
                            ->where('oferta_id',$request->oferta_id);

                            if ($request->salario || $request->salario_max) {
                                if (!empty($request->salario_max)) {
                                    $aplicaciones = $aplicaciones->whereBetween('salario_aspirado',[$request->salario ?? 0,$request->salario_max]); 
                                }else{
                                    $aplicaciones = $aplicaciones->where('salario_aspirado','>=',$request->salario); 
                                }
                            }

                            $aplicaciones = $aplicaciones->get();
                            // return DB::getQueryLog();

            }

            $estados = EstadoOferta::where('estado','A')->get();
            return view('aplicaciones.table',compact('aplicaciones','estados'));
        } else {
            //DB::enableQueryLog();
            $aspirantes = Aspirantes::with('user')
                            ->with(['aspirante_formacion' => function($query) use ($request){
                                if ($request->grado != -1) {
                                        $query->where('oferta_academica_id',$request->grado);   
                                    }else{
                                        $query;
                                    }

                            }])
                            /*->orWhereHas('aspirante_formacion', function ($query) use ($request) {
                                    if ($request->grado != -1) {
                                        $query->where('oferta_academica_id',$request->grado);   
                                    }else{
                                        $query;
                                    }
                                })*/
                            ->with(['aspirante_experiencia' => function($query) use ($request){
                                if ($request->cargo) {
                                        $query->where('cargo','like','%'.$request->cargo.'%');   
                                    }else{
                                        $query;
                                    }

                            }])
                            /*->orWhereHas('aspirante_experiencia', function ($query) use ($request) {
                                    if ($request->cargo) {
                                        $query->where('cargo','like','%'.$request->cargo.'%');   
                                    }else{
                                        $query;
                                    }
                                })*/
                            ->with('aspirante_idioma')
                            ->with('aspirante_referencia');
            if ($request->edad || $request->edad_max) {
                if (empty($request->edad_max)) {
                    $aspirantes = $aspirantes->where('fecha_nacimiento','>=',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-01-01');
                }else{
                    if (empty($request->edad) || $request->edad == 0) {        
                        $aspirantes = $aspirantes->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y") .'-12-31']); 
                    }else{ 
                        $aspirantes = $aspirantes->whereBetween('fecha_nacimiento',[date("Y",strtotime(date("Y-m-d")."- $request->edad_max year")) .'-01-01',date("Y",strtotime(date("Y-m-d")."- $request->edad year")) .'-12-31']); 
                    }
                }
                
            }

            if ($request->salario || $request->salario_max) {
                if (!empty($request->salario_max)) {
                    $aspirantes = $aspirantes->whereBetween('espectativa_salarial',[$request->salario ?? 0,$request->salario_max]);
                }else{
                    $aspirantes = $aspirantes->where('espectativa_salarial','>=',$request->salario);
                }
                
            }

            if ($request->pais) {
                $aspirantes = $aspirantes->where('pais',$request->pais);   
            }

            if ($request->provincia) {
                $aspirantes = $aspirantes->where('provincia',$request->provincia);   
            }

            if ($request->ciudad) {
                $aspirantes = $aspirantes->where('ciudad',$request->ciudad);   
            }

            $aspirantes = $aspirantes->get();
           //return DB::getQueryLog();
            return view('user-aspirante.table',compact('aspirantes'));
        }
        
    }

    public function profile(Request $request)
    {
        $aspirante = Aspirantes::with('user')->with('aspirante_experiencia')->with('aspirante_formacion')->with('aspirante_formacion.oferta_academica')->with('aspirante_idioma')->with('aspirante_referencia')->where('id',$request->aspirante_id)->first();
        //return $aspirante;
        return view('aplicaciones.profile',compact('aspirante'));
    }

    public function changeStatus(Request $request)
    {
        $aplicacion = Aplicaciones::find($request->id_postulacion);
        $aplicacion->estado_oferta_id = $request->id_estado;
        $aplicacion->save();

        $result = $aplicacion ? ['msg' => 'success', 'data' => 'Estado de la postulación actualizado correctamente'] : ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar el estado de la postulación'];
         return response()->json($result);
    }

    public function habilidad(Request $request)
    {
        return Habilidades::where('estado','A')->get();
    }

    public function publicPostFB(Request $request,$id)
    {
        $baseUrl = env('API_ENDPOINT_FB');
        $descripcion = strip_tags(str_replace('&nbsp;',' ',$request->descripcion));
        $texto = $request->titulo."\n".$descripcion."\nAplica en ".env('APP_URL').'/ofertas/'.$id .'/aplicar/';
        $body = [
            'access_token'=>env('ACCESS_TOKEN_FB'),
            'message'=>$texto,
            'attachments'=>env('APP_URL'),
            'url'=>env('IMG_URL')
        ];

        return $response = Http::post($baseUrl, $body);

    }

    public function publicPostTW(Request $request,$id)
    {
        $descripcion = strip_tags(str_replace('&nbsp;',' ',$request->descripcion));
        $texto = $request->titulo."\n".$descripcion."\nAplica en \n".env('APP_URL').'/ofertas/'.$id .'/aplicar';
        $texto = Str::substr($texto, 0,140);
        $uploaded_media = \Twitter::uploadMedia(['media' => \File::get(public_path('images/upload.jpg'))]);
        $datos =  \Twitter::postTweet(['status' => $texto, 'media_ids' => $uploaded_media->media_id_string]);
        return json_encode($datos);
    }
}
