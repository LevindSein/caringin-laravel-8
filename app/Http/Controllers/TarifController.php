<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index(){
        return view('tarif.index');
    }
}
