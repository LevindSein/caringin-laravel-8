<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\MeteranListrik;
use App\Models\MeteranAir;

use Exception;

class MeteranController extends Controller
{
    public function add(Request $request){
        try{
            if($request->get('radioMeter') == 'listrik'){
                Session::put('meteran','listrik');
                $meter = new MeteranListrik;
                $meter->kode = 'ML'.substr(str_shuffle('0123456789'), 0, 4);
                $meter->nomor = strtoupper($request->get('nomor'));
                $akhir = explode(',',$request->get('standListrik'));
                $akhir = implode('',$akhir);
                $daya = explode(',',$request->get('dayaListrik'));
                $daya = implode('',$daya);
                $meter->akhir = $akhir;
                $meter->daya = $daya;
                $meter->stt_sedia = 0;
                $meter->stt_bayar = 0;
                $meter->save();
            }

            if($request->get('radioMeter') == 'air'){
                Session::put('meteran','airbersih');
                $meter = new MeteranAir;
                $meter->kode = 'MA'.substr(str_shuffle('0123456789'), 0, 4);
                $meter->nomor = strtoupper($request->get('nomor'));
                $akhir = explode(',',$request->get('standAir'));
                $akhir = implode('',$akhir);
                $meter->akhir = $akhir;
                $meter->stt_sedia = 0;
                $meter->stt_bayar = 0;
                $meter->save();
            }

            return redirect()->route('meteranindex')->with('success','Alat Meter Telah Ditambah');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error','Kesalahan Sistem');
        }
    }

    public function delete($fasilitas, $id){
        try{
            if($fasilitas == 'listrik'){
                $data = MeteranListrik::find($id);
                $data->delete();
                Session::put('meteran',$fasilitas);
                return redirect()->back()->with('success','Alat Meter Dihapus');
            }

            if($fasilitas == 'airbersih'){
                $data = MeteranAir::find($id);
                $data->delete();
                Session::put('meteran',$fasilitas);
                return redirect()->back()->with('success','Alat Meter Dihapus');
            }
        }
        catch(\Exception $e){
            Session::put('meteran',$fasilitas);
            return redirect()->back()->with('error','Alat Meter Terpasang');
        }
    }

    public function print(){
        
    }
}
