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

use Exception;

class TarifController extends Controller
{
    public function add(Request $request){
        if(empty($request->get('checkKeamananIpk')) && empty($request->get('checkKebersihan')) && empty($request->get('checkAirKotor')) && empty($request->get('checkLain'))){
            return redirect()->back()->with('info','Pilih Tarif yang akan ditambah');
        }
        else{
            if(empty($request->get('checkKeamananIpk')) == FALSE){
                Session::put('tarif','keamananipk');
                $tarif = explode(',',$request->get('keamananIpk'));
                $tarif = implode('',$tarif);
                $trf = new TarifKeamananIpk;
                $trf->tarif = $tarif;
                $trf->save();
            }
            if(empty($request->get('checkKebersihan')) == FALSE){
                Session::put('tarif','kebersihan');
                $tarif = explode(',',$request->get('kebersihan'));
                $tarif = implode('',$tarif);
                $trf = new TarifKebersihan;
                $trf->tarif = $tarif;
                $trf->save();
            }
            if(empty($request->get('checkAirKotor')) == FALSE){
                Session::put('tarif','airkotor');
                $tarif = explode(',',$request->get('airkotor'));
                $tarif = implode('',$tarif);
                $trf = new TarifAirKotor;
                $trf->tarif = $tarif;
                $trf->save();
            }
            if(empty($request->get('checkLain')) == FALSE){
                Session::put('tarif','lain');
                $tarif = explode(',',$request->get('lain'));
                $tarif = implode('',$tarif);
                $trf = new TarifLain;
                $trf->tarif = $tarif;
                $trf->save();
            }
            return redirect()->route('tarifindex')->with('success','Tarif Ditambah');
        }
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
            return view('tarif.update',[
                'dataset'=>TarifKeamananIpk::find($id),
                'fasilitas'=>$fasilitas,
                'fas'=>'Keamanan IPK'
            ]);
        }

        if($fasilitas == 'kebersihan'){
            return view('tarif.update',[
                'dataset'=>TarifKebersihan::find($id),
                'fasilitas'=>$fasilitas,
                'fas'=>'Kebersihan'
            ]);
        }

        if($fasilitas == 'airkotor'){
            return view('tarif.update',[
                'dataset'=>TarifAirKotor::find($id),
                'fasilitas'=>$fasilitas,
                'fas'=>'Air Kotor'
            ]);
        }

        if($fasilitas == 'lain'){
            return view('tarif.update',[
                'dataset'=>TarifLain::find($id),
                'fasilitas'=>$fasilitas,
                'fas'=>'Lain - Lain'
            ]);
        }
    }

    public function store(Request $request, $fasilitas, $id){
        try{
            if($fasilitas == 'keamananipk'){
                Session::put('tarif','keamananipk');
                $tarif = TarifKeamananIpk::find($id);
                $trf = explode(',',$request->get('tarif'));
                $trf = implode('',$trf);
                $tarif->tarif = $trf;
                $tarif->save();
            }
    
            if($fasilitas == 'kebersihan'){
                Session::put('tarif','kebersihan');
                $tarif = TarifKebersihan::find($id);
                $trf = explode(',',$request->get('tarif'));
                $trf = implode('',$trf);
                $tarif->tarif = $trf;
                $tarif->save();
            }
    
            if($fasilitas == 'airkotor'){
                Session::put('tarif','airkotor');
                $tarif = TarifAirKotor::find($id);
                $trf = explode(',',$request->get('tarif'));
                $trf = implode('',$trf);
                $tarif->tarif = $trf;
                $tarif->save();
            }
    
            if($fasilitas == 'lain'){
                Session::put('tarif','lain');
                $tarif = TarifLain::find($id);
                $trf = explode(',',$request->get('tarif'));
                $trf = implode('',$trf);
                $tarif->tarif = $trf;
                $tarif->save();
            }
            return redirect()->route('tarifindex')->with('success','Tarif diupdate');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error','Kesalahan Sistem');
        }
    }

    public function delete($fasilitas, $id){
        try{
            if($fasilitas == 'keamananipk'){
                Session::put('tarif','keamananipk');
                $tarif = TarifKeamananIpk::find($id);
                $nama = $tarif->tarif;
                $tarif->delete();
            }

            if($fasilitas == 'kebersihan'){
                Session::put('tarif','kebersihan');
                $tarif = TarifKebersihan::find($id);
                $nama = $tarif->tarif;
                $tarif->delete();
            }

            if($fasilitas == 'airkotor'){
                Session::put('tarif','airkotor');
                $tarif = TarifAirKotor::find($id);
                $nama = $tarif->tarif;
                $tarif->delete();
            }

            if($fasilitas == 'lain'){
                Session::put('tarif','lain');
                $tarif = TarifLain::find($id);
                $nama = $tarif->tarif;
                $tarif->delete();
            }

            return redirect()->route('tarifindex')->with('success','Tarif '.number_format($nama).' Dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Tarif '.number_format($nama).' Tidak Dapat Dihapus - Tarif Digunakan');
        }
    }
}
