<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TarifKeamananIpk;

class NasabahController extends Controller
{
    public function index(){
        return view('nasabah.index',[
            'keamananipk'=>TarifKeamananIpk::orderBy('tarif', 'asc')->get(),
        ]);
    }
}
