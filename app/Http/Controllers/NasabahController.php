<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TarifKeamananIpk;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    public function index(){
        $id = Session::get('userId');
        return view('nasabah.index',[
            'tagihan'=>Nasabah::tagihan($id),
            'pemilik'=>Nasabah::pemilik($id),
            'pengguna'=>Nasabah::pengguna($id),
            'dataset'=>Nasabah::data($id),
        ]);
    }
}
