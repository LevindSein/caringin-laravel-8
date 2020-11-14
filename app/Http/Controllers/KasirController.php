<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Kasir;
use App\Models\Tagihan;

class KasirController extends Controller
{
    public function index(){
        return view('kasir.index',[
            'dataset'=>Kasir::tagihan(),
        ]);
    }

    public function bayar($id){

    }

    public function details($id){

    }

    public function cari(Request $request){
        echo $request->get('kode');
    }

    public function penerimaan(){
        
    }
}
