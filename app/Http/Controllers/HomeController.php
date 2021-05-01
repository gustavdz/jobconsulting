<?php

namespace App\Http\Controllers;

use App\User;
use App\Ofertas;
use App\Categorias;
use App\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        //dd(Auth::user()->role);
        $activar = Configuracion::find(1);
        if (Auth::user()->role == 'admin'){
            $ofertas = DB::select("SELECT count(*) as total,u.name from ofertas o join users u on o.empresa_id = u.id group by o.empresa_id  having total > 0 order by total desc limit 5");
            $labels = [];
            $data = [];
            //return $ofertas;
            foreach ($ofertas as $value) {
                $labels[] = $value->name;
                $data[] = $value->total;
            }
            $labels = json_encode($labels);
            $data = json_encode($data);

            $aplicaciones = DB::select("SELECT count(1) as total, o.titulo from aplicaciones a join ofertas o on a.oferta_id = o.id group by a.oferta_id having total > 0 order by total desc limit 5");
            $labels_aplicaciones = [];
            $data_aplicaciones = [];
            //return $ofertas;
            foreach ($aplicaciones as $value) {
                $labels_aplicaciones[] = $value->titulo;
                $data_aplicaciones[] = $value->total;
            }
            $labels_aplicaciones = json_encode($labels_aplicaciones);
            $data_aplicaciones = json_encode($data_aplicaciones);

        
            //postulantes/registros x mes
            $actualYear = date("Y");
            $postulacionesxMes = DB::select("SELECT  COUNT(*) as count, YEAR(created_at) year, MONTHNAME(created_at) month from aspirantes where YEAR(created_at) = 2020 group by year, month");
            $registrosxMes = DB::select("SELECT COUNT(*) as total, YEAR(created_at) year, MONTHNAME(created_at) month from aplicaciones where YEAR(created_at) = 2020 group by year, month");
            $labels_postulaciones = [];
            $data_postulaciones = [];
            $labels_registrosxMes = [];
            $data_registrosxMes = [];

            foreach ($postulacionesxMes as $value) {
                $labels_postulaciones[] = $value->month;
                $data_postulaciones[] = $value->count;
            }
            $labels_postulaciones = json_encode($labels_postulaciones);
            $data_postulaciones = json_encode($data_postulaciones);

            foreach ($registrosxMes as $value) {
                $labels_registrosxMes[] = $value->month;
                $data_registrosxMes[] = $value->total;
            }
            $labels_registrosxMes = json_encode($labels_registrosxMes);
            $data_registrosxMes = json_encode($data_registrosxMes);


            //POSTULANTES X OFERTA
            $actualDay = now();
            $postulacionesxOferta = DB::select("SELECT COUNT(*) as total, o.titulo as ofertaNombre from aplicaciones a join ofertas o on a.oferta_id = o.id where estado = 'A' and validez >= '$actualDay' group by ofertaNombre having total > 0");
            $labels_pOfertas = [];
            $data_pOfertas = [];

            foreach ($postulacionesxOferta as $value) {
                $labels_pOfertas[] = $value->ofertaNombre;
                $data_pOfertas[] = $value->total;
            }
            $labels_pOfertas = json_encode($labels_pOfertas);
            $data_pOfertas = json_encode($data_pOfertas);



            return view('home.index',compact('labels','data','labels_aplicaciones','data_aplicaciones', 'labels_postulaciones','data_postulaciones', 'data_registrosxMes', 'labels_registrosxMes', 'labels_pOfertas','data_pOfertas','activar'));
        }

        if (Auth::user()->role == 'aspirante'){
            $allCategories = Categorias::where('estado','A')->get();
            $ofertas=Ofertas::with('user')->with('categoriasOfertas.categoria')->with('habilidadesOfertas.habilidad')->where('ofertas.estado','A')->where('ofertas.validez','>',Carbon::now())->orderBy('ofertas.id', 'DESC')->paginate(9);
            //return $ofertas;
            return view('home_aspirante.index',compact('ofertas','allCategories'));
        }

        if (Auth::user()->role == 'empresa'){

            $ofertas = DB::select("SELECT count(1) as total, e.nombre from aplicaciones a join estado_ofertas e on a.estado_oferta_id = e.id join ofertas o on a.oferta_id = o.id  where o.empresa_id = '".Auth::user()->id."' group by a.estado_oferta_id having total > 0 order by total desc limit 5");
            $labels = [];
            $data = [];
            //return $ofertas;
            foreach ($ofertas as $value) {
                $labels[] = $value->nombre;
                $data[] = $value->total;
            }
            $labels = json_encode($labels);
            $data = json_encode($data);


            $aplicaciones = DB::select("SELECT count(1) as total, o.titulo from aplicaciones a join ofertas o on a.oferta_id = o.id where 
                o.empresa_id = '".Auth::user()->id."' group by a.oferta_id having total > 0 order by total desc limit 5");

            $labels_aplicaciones = [];
            $data_aplicaciones = [];
            //return $ofertas;
            foreach ($aplicaciones as $value) {
                $labels_aplicaciones[] = $value->titulo;
                $data_aplicaciones[] = $value->total;
            }
            $labels_aplicaciones = json_encode($labels_aplicaciones);
            $data_aplicaciones = json_encode($data_aplicaciones);



            return view('home_empresa.index',compact('labels','data','labels_aplicaciones','data_aplicaciones'));
        }
    }

    public function activar(Request $request){
        $activar = Configuracion::find(1);
        $activar->social_media = $request->activar;
        $activar->save();

        return $activar->social_media == 'A' ? ['msg' => 'success', 'data' => 'Se ha Activado la publicación en redes sociales'] : ['msg' => 'success', 'data' => 'Se ha Desactivado la publicación en redes sociales']; 
    }
}
