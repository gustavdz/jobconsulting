<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AspirantesController extends Controller
{
    public function index()
    {
    	return view('aspirante.index');
    }
}
