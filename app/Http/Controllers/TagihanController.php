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
use App\Models\User;

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
            $bulan = Tagihan::indoBln(date("Y-m"));
            $months = date("Y-m", time());
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
            $datas = Tagihan::where('blok',$blok)
                ->select('kd_kontrol')
                ->groupBy('kd_kontrol')
                ->orderBy('kd_kontrol','asc')
                ->get();
            
            for($i = 1; $i<4; $i++){
                $j = 0;
                $space = 0;

                //Tagihan Sekarang
                $dataset = Tagihan::where([
                    ['kd_kontrol',$datas[$i]->kd_kontrol],
                    ['bln_tagihan','2020-11'],
                    ['stt_lunas',0]])
                ->first();
                if($dataset != NULL){
                    $pedagang = new Edaran('Pedagang',$dataset->nama,'title');
                    $kontrol = new Edaran('Alamat',$dataset->kd_kontrol,'title');
                    
                    if($dataset->sel_listrik != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Listrik',
                            number_format($dataset->sel_listrik),
                            'listrik',
                            number_format($dataset->awal_listrik),
                            number_format($dataset->akhir_listrik),
                            number_format($dataset->pakai_listrik),
                            number_format($dataset->daya_listrik)
                        );
                        $j++;
                    }
                    else{
                        $space += 5;
                    }

                    if($dataset->sel_airbersih != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Air Bersih',
                            number_format($dataset->sel_airbersih),
                            'airbersih',
                            number_format($dataset->awal_airbersih),
                            number_format($dataset->akhir_airbersih),
                            number_format($dataset->pakai_airbersih)
                        );
                        $j++;
                    }
                    else{
                        $space += 4;
                    }

                    if($dataset->sel_keamananipk != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Keamanan IPK',
                            number_format($dataset->sel_keamananipk),
                            'fasilitas'
                        );
                        $j++;
                    }
                    else{
                        $space += 1;
                    }
                    
                    if($dataset->sel_kebersihan != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Kebersihan',
                            number_format($dataset->sel_kebersihan),
                            'fasilitas'
                        );
                        $j++;
                    }
                    else{
                        $space += 1;
                    }
                    
                    if($dataset->sel_airkotor != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Air Kotor',
                            number_format($dataset->sel_airkotor),
                            'fasilitas'
                        );
                        $j++;
                    }
                    else{
                        $space += 1;
                    }
                }
                else{
                    $dataset = TempatUsaha::where('kd_kontrol',$datas[$i]->kd_kontrol)->first();
                    $pedagang = User::find($dataset->id_pengguna);
                    $pedagang = new Edaran('Pedagang',$pedagang->nama,'title');
                    $kontrol = new Edaran('Alamat',$dataset->kd_kontrol,'title');
                    $space += 12;
                }

                //Tunggakan, Denda, Lain - Lain
                $tunggakan = Tagihan::where([
                    ['kd_kontrol',$datas[$i]->kd_kontrol],
                    ['bln_tagihan','<','2020-11'],
                    ['stt_lunas',0]])
                ->select(
                    DB::raw('SUM(sel_tagihan) as tunggakan'))
                ->get();
                
                if($tunggakan != NULL){
                    $tunggakan = $tunggakan[0]->tunggakan;
                    $no = $j+1;
                    $no = $no.'. ';
                    $items[$j] = new Edaran(
                        $no.'Tunggakan',
                        number_format($tunggakan),
                        'fasilitas'
                    );
                    $j++;
                }
                else{
                    $space += 1;
                }

                $denda = Tagihan::where([
                    ['kd_kontrol',$datas[$i]->kd_kontrol],
                    ['stt_lunas',0]])
                ->select(
                    DB::raw('SUM(den_tagihan) as denda'))
                ->get();
                
                if($denda != NULL){
                    $denda = $denda[0]->denda;
                    if($denda != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Denda',
                            number_format($denda),
                            'fasilitas'
                        );
                        $j++;
                    }
                    else{
                        $space += 1;
                    }
                }
                else{
                    $space += 1;
                }

                $lain = Tagihan::where([
                    ['kd_kontrol',$datas[$i]->kd_kontrol],
                    ['stt_lunas',0]])
                ->select(
                    DB::raw('SUM(sel_lain) as lain'))
                ->get();
                
                if($lain != NULL){
                    $lain = $lain[0]->lain;
                    if($lain != 0){
                        $no = $j+1;
                        $no = $no.'. ';
                        $items[$j] = new Edaran(
                            $no.'Lain - Lain',
                            number_format($lain),
                            'fasilitas'
                        );
                        $j++;
                    }
                    else{
                        $space += 1;
                    }
                }
                else{
                    $space += 1;
                }

                //Total
                $total = Tagihan::where([
                    ['kd_kontrol',$datas[$i]->kd_kontrol],
                    ['stt_lunas',0]])
                ->select(
                    DB::raw('SUM(sel_tagihan) as total'))
                ->get();

                $total =  new Edaran('TOTAL','Rp. '.number_format($total[0]->total),'fasilitas');

                // Content
                $printer->text(" ------------------------------------------ \n");
                $printer->text("|             BADAN  PENGELOLA             |\n");
                $printer->text("|        PUSAT PERDAGANGAN CARINGIN        |\n");
                $printer->text("|            SEGI PEMBERITAHUAN            |\n");
                $printer->text("|---------------- $bln ----------------|\n");
                $printer->text($pedagang);
                $printer->text($kontrol);
                $printer->text("|-- FASILITAS -------------------- HARGA --|\n");
                for ($k = 0; $k < $j; $k++) {
                    $printer -> text($items[$k]);
                }
                if($space != 0){
                    for ($m = 0; $m < $space; $m++) {
                        $printer -> text("|                                          |\n");
                    }  
                }
                $printer->text("|------------------------------------------|\n");
                $printer->text($total);
                $printer->text("|------------------------------------------|\n");
                $printer->text("| - Harap melakukan pembayaran sebelum     |\n");
                $printer->text("|   tanggal 15, untuk menghindari Denda.   |\n");
                $printer->text("| - Pemberitahuan ini merupakan edaran     |\n");
                $printer->text("|   yang sah. Sudah termasuk PPN.          |\n");
                $printer->text(" ------------------------------------------ \n\n\n");
            }
        } catch (Exception $e) {
            return redirect()->route('tagihandata','now')->with('error','Data Tagihan gagal dicetak');
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
