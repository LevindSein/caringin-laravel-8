<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Data;
use App\Models\TempatUsaha;

class DataController extends Controller
{
    public function index(){
        return view('data.index',[
            'tagihan'=>Data::tagihan(),
            'tunggakan'=>Data::tunggakan(),
            'bongkaran'=>Data::bongkaran(),
            'penghapusan'=>Data::penghapusan()
        ]);
    }

    public function details($data, $bulan){
        if($data == 'tagihan'){

        }

        if($data == 'tunggakan'){
            
        }

        if($data == 'bongkaran'){
            
        }

        if($data == 'penghapusan'){
            
        }
    }
}
