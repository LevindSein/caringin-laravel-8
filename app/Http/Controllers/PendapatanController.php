<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index(){
        return view('pendapatan.index');
    }

    public function filter(Request $request, $filter){
        if($filter == "harian"){

        }

        if($filter == "bulanan"){

        }

        if($filter == "tahunan"){
            
        }
    }
}
