<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemakaian;
use Illuminate\Support\Facades\DB;

class PemakaianController extends Controller
{
    public function index(){
        return view('pemakaian.index',[
            'dataset'=>Pemakaian::data()
        ]);
    }

    public function fasilitas(Request $request, $fasilitas, $bulan){
        if($fasilitas == 'listrik'){
            $rekap = Pemakaian::rekapListrik($bulan);

            return view('pemakaian.listrik',[
                'bln'=>Pemakaian::bulan($bulan),
                'rekap'=>$rekap,
                'ttlRekap'=>Pemakaian::ttlRekapListrik($rekap),
                'rincian'=>Pemakaian::rincianListrik($bulan),
            ]);
        }

        if($fasilitas == 'airbersih'){
            $rekap = Pemakaian::rekapAirBersih($bulan);

            return view('pemakaian.airbersih',[
                'bln'=>Pemakaian::bulan($bulan),
                'rekap'=>$rekap,
                'ttlRekap'=>Pemakaian::ttlRekapAirBersih($rekap),
                'rincian'=>Pemakaian::rincianAirBersih($bulan),
            ]);
        }
    }
}
