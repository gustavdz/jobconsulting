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
            $empresas = User::where('role','empresa')->get();
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



            return view('home.index',compact('labels','data','labels_aplicaciones','data_aplicaciones', 'labels_pOfertas','data_pOfertas','activar','empresas'));
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

    public function postualanteMes(Request $request)
    {
        //postulantes/registros x mes
        $actualYear = date("Y");
        $postulacionesxMes = DB::select("SELECT  COUNT(*) as count, YEAR(created_at) year, MONTHNAME(created_at) month from aspirantes where YEAR(created_at) = $request->filterYear group by year, month");
        $registrosxMes = DB::select("SELECT COUNT(*) as total, YEAR(created_at) year, MONTHNAME(created_at) month from aplicaciones where YEAR(created_at) = $request->filterYear group by year, month");
        $labels_postulaciones = [];
        $data_postulaciones = [];
        $labels_registrosxMes = [];
        $data_registrosxMes = [];

        foreach ($postulacionesxMes as $value) {
            $labels_postulaciones[] = $value->month;
            $data_postulaciones[] = $value->count;
        }
        $labels_postulaciones = ($labels_postulaciones);
        $data_postulaciones = ($data_postulaciones);

        foreach ($registrosxMes as $value) {
            $labels_registrosxMes[] = $value->month;
            $data_registrosxMes[] = $value->total;
        }
        $labels_registrosxMes = ($labels_registrosxMes);
        $data_registrosxMes = ($data_registrosxMes);

        $data['labels_registrosxMes'] =$labels_registrosxMes;
        $data['data_registrosxMes'] =$data_registrosxMes;
        $data['data_postulaciones'] =$data_postulaciones;
        $data['data_registrosxMes'] =$data_registrosxMes;

        return $data;
    }

    public function ofertasPorEmpresas(Request $request)
    {
        $empresas = isset($request->empresas) ? implode(',',$request->empresas) : 0;
        $sql = "SELECT u.id, u.name as nombre,
                sum(ifnull(offers.ene, 0)) as ene,
                sum(ifnull(offers.feb, 0)) as feb,
                sum(ifnull(offers.mar, 0)) as mar,
                sum(ifnull(offers.abr, 0)) as abr,
                sum(ifnull(offers.may, 0)) as may,
                sum(ifnull(offers.jun, 0)) as jun,
                sum(ifnull(offers.jul, 0)) as jul,
                sum(ifnull(offers.ago, 0)) as ago,
                sum(ifnull(offers.sep, 0)) as sep,
                sum(ifnull(offers.oct, 0)) as oct,
                sum(ifnull(offers.nov, 0)) as nov,
                sum(ifnull(offers.dic, 0)) as dic
                from ofertas
                join ( SELECT  ofs.id,ofs.empresa_id,
                (case when MONTH(ofs.created_at) = 1 then 1 else 0 end)  as ene,
                (case when MONTH(ofs.created_at) = 2 then 1 else 0 end)  as feb,
                (case when MONTH(ofs.created_at) = 3 then 1 else 0 end)  as mar,
                (case when MONTH(ofs.created_at) = 4 then 1 else 0 end)  as abr,
                (case when MONTH(ofs.created_at) = 5 then 1 else 0 end)  as may,
                (case when MONTH(ofs.created_at) = 6 then 1 else 0 end)  as jun,
                (case when MONTH(ofs.created_at) = 7 then 1 else 0 end)  as jul,
                (case when MONTH(ofs.created_at) = 8 then 1 else 0 end)  as ago,
                (case when MONTH(ofs.created_at) = 9 then 1 else 0 end)  as sep,
                (case when MONTH(ofs.created_at) = 10 then 1 else 0 end) as oct,
                (case when MONTH(ofs.created_at) = 11 then 1 else 0 end) as nov,
                (case when MONTH(ofs.created_at) = 12 then 1 else 0 end) as dic
                from ofertas as ofs where estado <> 'E' and YEAR(created_at) = $request->anio and empresa_id in ($empresas)
                    )  offers on ofertas.id = offers.id 
                join users u on offers.empresa_id = u.id
                group by u.id, u.name";

        return DB::select($sql);
    }
}
