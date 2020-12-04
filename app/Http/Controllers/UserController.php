<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\OfertaAcademica;
use App\Ofertas;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        if (Auth::user()->role == 'aspirante' || Auth::user()->role == 'empresa') {
            return redirect()->route('home');
        }
        return view('user.index');
    }

    public function indexAspirante()
    {
        if (Auth::user()->role == 'aspirante') {
            return redirect()->route('home');
        }
        $grado_academico = OfertaAcademica::all();
        return view('user-aspirante.index',compact('grado_academico'));
    }

    public function data()
    {
        $results = User::where('role','empresa')->where('status','A')->get();
        return view('user.table',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if (empty($request->id)) {
                $user = User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'role' => 'empresa',
                    'password' => Hash::make($request['password']),
                    'api_token' => Str::random(60),
                ]);
                DB::commit();
                if (!empty($user)) {
                    event(new Registered($user)); #notificacion de envio de valdiacion de correo
                    return response()->json(['msg' => 'success', 'data' => 'Se ha creado correctamente el usuario' . $request['name']]);
                }else{
                    return response()->json(['msg' => 'error', 'data' => 'No  ha creado el usuario ' . $request['name']]);
                }
            }else{
                $user = User::find($request->id);
                $user->name = $request['name_edit'];
                $user->email =$request['email_edit'];
                $user->save();

                DB::commit();

                $result = $user ? ['msg' => 'success', 'data' => 'Se ha editado correctamente el usuario ' . $user->name] : ['msg' => 'error', 'data' => 'Ocurrio un error al crear la Oferta ' . $request->name];

                return response()->json($result);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
        }



    }


    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->status = 'E'; //Eliminado
        $user->save();

        $result = $user ? ['msg' => 'success', 'data' => 'Se ha eliminado la Oferta ' . $user->name] : ['msg' => 'error', 'data' => 'Ocurrio un error al eliminar la Oferta ' . $user->name];

        return response()->json($result);
    }

    public function edit(Request $request){
        $user = Auth::user();
        if($user->role == 'aspirante'){
            return view('user.edit',compact('user'));
        }
        return response()->json($user);
    }
}
