<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\TarifListrik;
use App\Models\TarifAirBersih;
use App\Models\TarifKeamananIpk;
use App\Models\TarifKebersihan;
use App\Models\TarifAirKotor;
use App\Models\TarifLain;

class TarifController extends Controller
{
    public function index(){
        return view('tarif.index',[
            'listrik'=>TarifListrik::first(),
            'airbersih'=>TarifAirBersih::first(),
            'keamananipk'=>TarifKeamananIpk::orderBy('tarif', 'asc')->get(),
            'kebersihan'=>TarifKebersihan::orderBy('tarif', 'asc')->get(),
            'airkotor'=>TarifAirKotor::orderBy('tarif', 'asc')->get(),
            'lain'=>TarifLain::orderBy('tarif', 'asc')->get(),
        ]);
    }

    public function add(Request $request){

    }

    public function update(Request $request, $fasilitas, $id){
        if($fasilitas == 'listrik'){
            $bebanListrik = explode(',',$request->get('bebanListrik'));
            $bebanListrik = implode('',$bebanListrik);
            
            $blok1 = explode(',',$request->get('blok1'));
            $blok1 = implode('',$blok1);
            
            $blok2 = explode(',',$request->get('blok2'));
            $blok2 = implode('',$blok2);

            $denda1 = explode(',',$request->get('denda1'));
            $denda1 = implode('',$denda1);
            
            $pasang = explode(',',$request->get('pasangListrik'));
            $pasang = implode('',$pasang);
            
            $tarif = TarifListrik::find($id);
            $tarif->trf_beban = $bebanListrik;
            $tarif->trf_blok1 = $blok1;
            $tarif->trf_blok2 = $blok2;
            $tarif->trf_standar = $request->get('waktu');
            $tarif->trf_bpju = $request->get('bpju');
            $tarif->trf_denda = $denda1;
            $tarif->trf_denda_lebih = $request->get('denda2');
            $tarif->trf_ppn = $request->get('ppnListrik');
            $tarif->trf_pasang = $pasang;
            $tarif->save();
            Session::put('tarif','listrik');
            return redirect()->back()->with('success','Tarif Listrik Diupdate');
        }

        if($fasilitas == 'airbersih'){
            $bebanAir = explode(',',$request->get('bebanAir'));
            $bebanAir = implode('',$bebanAir);
            
            $tarif1 = explode(',',$request->get('tarif1'));
            $tarif1 = implode('',$tarif1);
            
            $tarif2 = explode(',',$request->get('tarif2'));
            $tarif2 = implode('',$tarif2);

            $pemeliharaan = explode(',',$request->get('pemeliharaan'));
            $pemeliharaan = implode('',$pemeliharaan);

            $dendaAir = explode(',',$request->get('dendaAir'));
            $dendaAir = implode('',$dendaAir);
            
            $pasang = explode(',',$request->get('pasangAir'));
            $pasang = implode('',$pasang);
            
            $tarif = TarifAirBersih::find($id);
            $tarif->trf_1 = $tarif1;
            $tarif->trf_2 = $tarif2;
            $tarif->trf_pemeliharaan = $pemeliharaan;
            $tarif->trf_beban = $bebanAir;
            $tarif->trf_arkot = $request->get('arkot');
            $tarif->trf_denda = $dendaAir;
            $tarif->trf_ppn = $request->get('ppnAir');
            $tarif->trf_pasang = $pasang;
            $tarif->save();
            Session::put('tarif','airbersih');
            return redirect()->back()->with('success','Tarif Air Diupdate');
        }

        if($fasilitas == 'keamananipk'){
            Session::put('tarif','keamananipk');
            echo 'keamananipk';
        }

        if($fasilitas == 'kebersihan'){
            Session::put('tarif','kebersihan');
            echo 'kebersihan';
        }

        if($fasilitas == 'airkotor'){
            Session::put('tarif','airkotor');
            echo 'airkotor';
        }

        if($fasilitas == 'diskon'){
            Session::put('tarif','diskon');
            echo 'diskon';
        }

        if($fasilitas == 'lain'){
            Session::put('tarif','lain');
            echo 'lain';
        }
    }
}
