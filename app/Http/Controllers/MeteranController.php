<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\MeteranListrik;
use App\Models\MeteranAir;
use App\Models\TempatUsaha;
use App\Models\Blok;

use App\Models\Item;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $blok = Blok::select('nama')->get();
        $dataListrik = array();
        $dataAir = array();
        $i = 0;
        $j = 0;
        foreach($blok as $b){
            $tempatListrik = TempatUsaha::where([['blok',$b->nama],['trf_listrik',1]])->count();
            if($tempatListrik != 0){
                $dataListrik[$i][0] = $b->nama;
                $dataListrik[$i][1] = TempatUsaha::where([['tempat_usaha.blok', $b->nama],['trf_listrik',1]])
                ->leftJoin('user as pengguna','tempat_usaha.id_pengguna','=','pengguna.id')
                ->leftJoin('meteran_listrik','tempat_usaha.id_meteran_listrik','=','meteran_listrik.id')
                ->select(
                    'pengguna.nama as nama',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'meteran_listrik.nomor as nomor',
                    'meteran_listrik.akhir as lalu')
                ->get();
                $i++;
            }

            $tempatAir = TempatUsaha::where([['blok',$b->nama],['trf_airbersih',1]])->count();
            if($tempatAir != 0){
                $dataAir[$j][0] = $b->nama;
                $dataAir[$j][1] = TempatUsaha::where([['tempat_usaha.blok', $b->nama],['trf_airbersih',1]])
                ->leftJoin('user as pengguna','tempat_usaha.id_pengguna','=','pengguna.id')
                ->leftJoin('meteran_air','tempat_usaha.id_meteran_air','=','meteran_air.id')
                ->select(
                    'pengguna.nama as nama',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'meteran_air.nomor as nomor',
                    'meteran_air.akhir as lalu')
                ->get();
                $j++;
            }
        }
        $dataset = [$dataListrik,$dataAir];
        return view('meteran.print',[
            'dataset'=>$dataset
        ]);
    }

    public function qr($fasilitas,$id){
        if($fasilitas == 'listrik'){
            $fasilitas = 'Listrik';
            $kontrol = TempatUsaha::where('id_meteran_listrik',$id)->select('kd_kontrol')->first();
            $kode = MeteranListrik::find($id);
            $kode = 'IDENTITIY-BP3C-'.$kode->kode;
            if($kontrol != NULL){
                $kontrol = $kontrol->kd_kontrol;
            }
            else{
                $kontrol = ' ';
            }
        }

        if($fasilitas == 'airbersih'){
            $fasilitas = 'Air Bersih';
            $kontrol = TempatUsaha::where('id_meteran_air',$id)->select('kd_kontrol')->first();
            $kode = MeteranAir::find($id);
            $kode = 'IDENTITY-BP3C-'.$kode->kode;
            if($kontrol != NULL){
                $kontrol = $kontrol->kd_kontrol;
            }
            else{
                $kontrol = ' ';
            }
        }

        return view('meteran.qr',[
            'id'=>$id,
            'kode'=>$kode,
            'kontrol'=>$kontrol,
            'fasilitas'=>$fasilitas
        ]);
    }
}
