<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        if (Auth::user()->role == 'admin'){
            return view('home');
        }

        if (Auth::user()->role == 'aspirante'){
            return view('home_aspirante');
        }

        if (Auth::user()->role == 'empresa'){
            return view('home_empresa');
        }
    }
}
