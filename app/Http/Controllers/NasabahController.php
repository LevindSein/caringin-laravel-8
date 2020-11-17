<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TarifKeamananIpk;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    public function details($bln){
        $id = Session::get('userId');
        return view('nasabah.details',[
            'tagihan'=>Nasabah::tagihan($id),
            'pemilik'=>Nasabah::pemilik($id),
            'pengguna'=>Nasabah::pengguna($id),
            'bln'=>$bln
        ]);
    }

    public function rincian($bln){
        $id = Session::get('userId');
        return view('nasabah.rincian',[
            'tagihan'=>Nasabah::tagihan($id),
            'pemilik'=>Nasabah::pemilik($id),
            'pengguna'=>Nasabah::pengguna($id),
            'bln'=>$bln,
            'dataset'=>Nasabah::rincian($id,$bln),
        ]);
    }
}
