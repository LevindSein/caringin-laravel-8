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
use App\Models\Edaran;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;

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
                    // Tagihan::checking1();
                }
                else if($now >= $check){
                    //Check Tagihan Pemakaian Bulan Lalu
                    // Tagihan::checking2();
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

    public function edaran(Request $request, $blok){
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d",time());
        $time = strtotime($now);
        $check = date("Y-m-20",time());

        if($now < $check){
            $bln = $this->indoBln(date("Y-m"));
            $bulan = Tagihan::indoBln(data("Y-m"));
        }
        else if($now >= $check){
            $sekarang = date("Y-m", time());
            $time = strtotime($sekarang);
            $months = date("Y-m", strtotime("+1 month", $time));
            $bln = $this->indoBln($months);
            $bulan = Tagihan::indoBln($months);
        }

        $profile = CapabilityProfile::load("POS-5890");
        $connector = new RawbtPrintConnector();
        $printer = new Printer($connector,$profile);

        try{
            $printer->text("\n");
            for($i = 0; $i < 3; $i++){
                $items = array(
                    new Edaran("Listrik", 100000, 100000, 100000, 260000, 'listrik'),
                    new Edaran("Air Bersih", 100000, 100000, 100000, 260000, 'listrik'),
                    new Edaran("K.aman IPK", '', '', '', 260000, 'kebersihan'),
                    new Edaran("Kebersihan", '', '', '', 260000, 'kebersihan'),
                    new Edaran("Air Kotor", '', '', '', 260000, 'kebersihan'),
                    new Edaran("Tunggakan", '', '', '', 260000, 'kebersihan'),
                    new Edaran("Denda", '', '', '', 260000, 'kebersihan'),
                    new Edaran("Lain Lain", '', '', '', 260000, 'kebersihan'),
                );
                $total = new Edaran("TOTAL", '', '', '', 10000000, 'total');

                $alamat = new Edaran("Alm", '', '', '', 'A-1-001', 'alamat');
                $pedagang = new Edaran("Pdg", '', '', $bulan, 'Fahni Amsyari', 'pedagang');

                // Content
                $printer->text(" -----------------------------   -----------------------------   ------------------------------------------------------------------------------------------------- \n");
                $printer->text("|    BADAN PENGELOLA PUSAT    | |    BADAN PENGELOLA PUSAT    | |                             BADAN PENGELOLA PUSAT PERDAGANGAN CARINGIN                          |\n");
                $printer->text("|    PERDAGANGAN  CARINGIN    | |    PERDAGANGAN  CARINGIN    | |                                   KEMITRAAN KOPPAS INDUK BANDUNG                                |\n");
                $printer->text("|     SEGI  PEMBERITAHUAN     | |        SEGI PELUNASAN       | |                                          SEGI  PEMBAYARAN                                       |\n");
                $printer->text(" -----------------------------   -----------------------------   ------------------------------------------------------------------------------------------------- \n");
                $printer->text($pedagang);
                $printer->text($alamat);
                $printer->text(" ---------- $bln ---------   ---------- $bln ---------   ------------------------ AWAL ------------ AKHIR ------------ PAKAI ------------------ JUMLAH --- \n");
                foreach ($items as $item) {
                    $printer -> text($item);
                }
                $printer->text(" -----------------------------   -----------------------------   ------------------------------------------------------------------------------------------------- \n");
                $printer->text($total);
                $printer->text(" -----------------------------   -----------------------------   ------------------------------------------------------------------------------------------------- \n");
                $printer->text("        Hindari Denda,                  Untuk keperluan                                       Hindari Denda, harap bayar sebelum tgl 15.                           \n");
                $printer->text("  harap bayar sebelum tgl 15.      Bukti Kas & Administrasi.                                     Total Pembayaran telah termasuk PPN                             \n\n");
            }
            $printer->text("\n\n");
        } catch (Exception $e) {
            return redirect()->route('tagihandata','now')->with('error','Kesalahan Sistem');
        } finally {
            $printer->close();
        }
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

    public function indoBln($date){
        $bulan = array (
            1 =>   'JAN',
            'FEB',
            'MAR',
            'APR',
            'MEI',
            'JUN',
            'JUL',
            'AGU',
            'SEP',
            'OKT',
            'NOV',
            'DES'
        );
        $pecahkan = explode('-', $date);
        return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}
