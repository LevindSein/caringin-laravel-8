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

        if($fasilitas == 'keamananipk'){
            $rekap = Pemakaian::rekapKeamananIpk($bulan);

            return view('pemakaian.keamananipk',[
                'bln'=>Pemakaian::bulan($bulan),
                'rekap'=>$rekap,
                'ttlRekap'=>Pemakaian::ttlRekapKeamananIpk($rekap),
                'rincian'=>Pemakaian::rincianKeamananIpk($bulan),
            ]);
        }

        if($fasilitas == 'kebersihan'){
            $rekap = Pemakaian::rekapKebersihan($bulan);

            return view('pemakaian.kebersihan',[
                'bln'=>Pemakaian::bulan($bulan),
                'rekap'=>$rekap,
                'ttlRekap'=>Pemakaian::ttlRekapKebersihan($rekap),
                'rincian'=>Pemakaian::rincianKebersihan($bulan),
            ]);
        }
    }
}
