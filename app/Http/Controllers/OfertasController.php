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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PHPUnit\Util\Json;
use function MongoDB\BSON\toJSON;

class OfertasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexAPI() {
        $ofertas = Ofertas::with('user')
            ->with('categoriasOfertas.categoria')
            ->with('habilidadesOfertas.habilidad')
            ->where('ofertas.estado','A')
            ->orderBy('ofertas.validez', 'DESC')
            ->orderBy('ofertas.id', 'DESC')
            ->paginate();
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
            ->eloquent(Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC'))
            ->addColumn('detalle','ofertas.detalle') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('categorias','ofertas.categorias') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('habilidades','ofertas.habilidades') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','ofertas.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
            ->rawColumns(['detalle','categorias','habilidades','opciones']) #opcion para que presente el HTML
            ->toJson();
        }
        if (Auth::user()->role == 'empresa'){
            return datatables()
            ->eloquent(Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->where('ofertas.empresa_id',Auth::user()->id)->orderBy('ofertas.validez', 'DESC')->orderBy('ofertas.id', 'DESC'))
            ->addColumn('detalle','ofertas.detalle') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('categorias','ofertas.categorias') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('habilidades','ofertas.habilidades') #detalle o llave a recibir en el JS y segundo campo la vista
            ->addColumn('opciones','ofertas.opciones') #detalle o llave a recibir en el JS y segundo campo la vista
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
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $value;
                        $habilidad_oferta->oferta_id = $ofertas->id;
                        $habilidad_oferta->save();
                    }
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
                        $habilidad_oferta = new HabilidadesOfertas;
                        $habilidad_oferta->habilidad_id = $value;
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
        return Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.id',$request->id)->first();
    }

    public function delete(Request $request)
    {
        $ofertas = Ofertas::find($request->id);
        $ofertas->estado = 'E'; //Eliminado
        $ofertas->save();

        $result = $ofertas ? ['msg' => 'success', 'data' => 'Se ha eliminado la Oferta ' . $ofertas->titulo] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la Oferta ' . $ofertas->titulo];

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
        $aspirante = Aspirantes::where('user_id',Auth::user()->id)->first();
        if (empty($aspirante)) {
            return response()->json(['msg' => 'error', 'data' => 'Debe actualizar su Currículum, para realizar la postulación']);
        }

        $oferta = Aplicaciones::where('aspirante_id',$aspirante->id)->where('oferta_id',$request->oferta_id)->first();
        if (empty($oferta)) {
            $postulacion = new Aplicaciones;
            $postulacion->oferta_id = $request->oferta_id;
            $postulacion->aspirante_id = $aspirante->id;
            $postulacion->estado_oferta_id = 1;
            $postulacion->salario_aspirado = $request->salario;
            $postulacion->save();

            $result = $postulacion ? ['msg' => 'success', 'data' => 'Se ha postulado correctamente a la oferta'] : ['msg' => 'error', 'data' => 'Ocurrio un error al postular la Oferta '];

            return response()->json($result);
        }else{
            return response()->json(['msg' => 'error', 'data' => 'Ya se encuentra una postulación registrada con sus datos']);
        }
    }


}
