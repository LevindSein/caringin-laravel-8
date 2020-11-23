<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Tagihan;
use App\Models\Pedagang;
use App\Models\MeteranAir;
use App\Models\MeteranListrik;
use App\Models\TempatUsaha;
use App\Models\Blok;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use Exception;

class TagihanController extends Controller
{
    public function data(Request $request, $data){
        //inisialisasi
        date_default_timezone_set('Asia/Jakarta');

        //Penting
        $month = date("m", time());
        $tahun = date("Y", time());
        //End Penting

        $now = date("Y-m-d",time());
        $time = strtotime($now);
        $check = date("Y-m-20",time());

        if($now < $check){
            $months = date("Y-m", time());
            $time = strtotime($months);
            $bulanPakai = date("Y-m", strtotime("-1 month", $time));
        }
        else if($now >= $check){
            $sekarang = date("Y-m", time());
            $time = strtotime($sekarang);
            $months = date("Y-m", strtotime("+1 month", $time));
            $bulanPakai = date("Y-m", time());
        }

        if($data == "now"){
            $bulan = Tagihan::indoBln($months);
            $bln = $months;
            
            $now = date("Y-m-d",time());
            $check = date("Y-m-15",time());

            if(Session::get('tagihan') != 'done'){
                if($now < $check){
                    //Check Tagihan Pemakaian Bulan Lalu
                    Tagihan::checking1();
                }
                else if($now >= $check){
                    //Check Tagihan Pemakaian Bulan Lalu
                    Tagihan::checking2();
                }
            }
        }
        else if($data == "periode"){
            $bulan = Tagihan::indoBln($request->get('tahun').'-'.$request->get('bulan'));
            $bln = $request->get('tahun').'-'.$request->get('bulan');
        }
        else{
            return redirect()->back();
        }

        return view('tagihan.data',[
            'dataset'=>Tagihan::data($bln),
            'month'=>$month,
            'bulan'=>$bulan,
            'tahun'=>$tahun,
            'bulanPakai'=>$bulanPakai,
            'dataTahun'=>Tagihan::dataTahun(),
            'blok'=>Blok::all(),
            'listrikBadge'=>Tagihan::listrikBadge(),
            'airBersihBadge'=>Tagihan::airBersihBadge(),
        ]);
    }

    public function update($id){
        $fasilitas = 'update';
        $dataset = Tagihan::updateTagihan($id);
        return view('tagihan.update',[
            'dataset'=>$dataset,
            'fasilitas'=>$fasilitas
        ]);
    }
    
    public function store(Request $request, $id){

    }

    public function fasilitas($fasilitas){
        $dataset = Tagihan::tagihan($fasilitas);
        if($dataset == "Air Bersih"){
            return redirect()->route('tagihandata','now')->with('success','Update Tagihan Air Bersih Selesai');
        }
        if($dataset == "Listrik"){
            return redirect()->route('tagihandata','now')->with('success','Update Tagihan Listrik Selesai');
        }

        if($fasilitas == 'listrik'){
            return view('tagihan.listrik',[
                'dataset'=>$dataset,
                'fasilitas'=>$fasilitas
            ]);
        }
        
        if($fasilitas == 'airbersih'){
            return view('tagihan.airbersih',[
                'dataset'=>$dataset,
                'fasilitas'=>$fasilitas
            ]);
        }
    }

    public function storeFasilitas(Request $request,$fasilitas, $id){
        $tempatId = $request->get('tempatId');
        $tempat = TempatUsaha::find($tempatId);
        $penggunaId = $request->get('namaPengguna');
        $awal = $request->get('awal');
        $awal = explode(',',$awal);
        $awal = implode("",$awal);
        
        $akhir = $request->get('akhir');
        $akhir = explode(',',$akhir);
        $akhir = implode("",$akhir);

        //Update Pengguna
        $tempat->id_pengguna = $penggunaId;
        $tempat->id_pemilik = $penggunaId;
        $tagihan = Tagihan::find($id);
        $tagihan->id_pengguna = $penggunaId;
        $tagihan->id_pemilik = $penggunaId;

        if($akhir < $awal){
            return redirect()->back()->with('error','Data Akhir Lebih Kecil dari Data Awal');
        }
        
        if($fasilitas == 'listrik'){
            $daya = $request->get('daya');
            $daya = explode(',',$daya);
            $daya = implode("",$daya);

            //Update Meteran
            $tempat->daya = $daya;
            $tempat->save();
            $meter = MeteranListrik::find($tempat->id_meteran_listrik);
            $meter->akhir = $akhir;
            $meter->daya = $daya;
            $tagihan->daya_listrik = $daya;
            $meter->save();

            //Update Tagihan
            Tagihan::listrik($awal,$akhir,$daya,$id);
        }

        if($fasilitas == 'airbersih'){
            //Update Meteran
            $meter = MeteranAir::find($tempat->id_meteran_air);
            $meter->akhir = $akhir;
            $meter->save();

            //Update Tagihan
            Tagihan::airBersih($awal,$akhir,$id);
        }
        
        $tagihan->save();
        return redirect()->route('pedagangTagihan',$fasilitas)->with('success','^_^');
    }

    public function edaran(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $month = date("Y-m", time());

        $connector = new WindowsPrintConnector("EPSONLQ");
                
        $printer = new Printer($connector);

        /* Name of shop */
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text("================================================\n");
        $printer -> text("PT. Pengelola Pusat Perdagangan Caringin.\n");
        $printer -> selectPrintMode();
        $printer -> text("Jl. Soetta No.220 Blok A1 No.21-24\n");
        $printer -> text("================================================\n");
        $printer -> feed();

        $printer -> text("Terimakasih telah melakukan Pembayaran\n");
        $printer -> cut();
        $printer -> pulse();

        $printer -> close();
        // return view('tagihan.edaran',['dataset'=>Tagihan::where([['blok',$request->get('blok')],['bln_tagihan',$month]])->get()]);
    }

    public function publish(){
        return redirect()->back()->with('success','Tagihan di Publish');
    }

    //opsional
    public function pedagang(Request $request, $fasilitas){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $anggota = $request->get('anggota');
        try{
            $pedagang = new Pedagang;
            $pedagang->username = substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4).str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
            $pedagang->nama = $nama;
            $pedagang->anggota = $anggota;
            $pedagang->password = md5(substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10));
            $pedagang->role = 'nasabah';
            $pedagang->save();

            return redirect()->route('pedagangTagihan', $fasilitas)->with('success', 'Data Pedagang Ditambah');
        }catch(\Exception $e){
            return redirect()->route('pedagangTagihan', $fasilitas)->with('error','Pedagang Gagal Ditambah');
        }
    }
}
