<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendapatanController extends Controller
{
    public function index(){
        return view('pendapatan.index');
    }

    
    public function harian(Request $request){

    }

    public function bulanan(Request $request){

    }

    public function tahunan(Request $request){
        
    }

    public function details($filter, $id){
        if($filter == 'harian'){

        }
        
        if($filter == 'bulanan'){
            
        }

        if($filter == 'tahunan'){
            
        }
    }
}
