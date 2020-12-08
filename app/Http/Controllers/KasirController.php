<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Kasir;
use App\Models\Tagihan;
use App\Models\Item;
use App\Models\StrukMobile;
use App\Models\StrukLarge;
use App\Models\StrukLapangan;
use App\Models\Pembayaran;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;

use Jenssegers\Agent\Agent;

use Exception;

class KasirController extends Controller
{
    public function index(Request $request, $data){
        date_default_timezone_set('Asia/Jakarta');

        if($data == 'now'){
            $bulan = Kasir::indoBln(date("Y-m", time()));
            $dataset = Kasir::tagihan('now');    
        }
        else if ($data == 'periode'){
            $bulan = Kasir::indoBln($request->get('tahun').'-'.$request->get('bulan'));
            $bln = $request->get('tahun').'-'.$request->get('bulan');
            $dataset = Kasir::tagihan($bln);
        }

        $agent = new Agent();
        if($agent->isDesktop()){
            $platform = 'desktop';
        }
        else{
            $platform = 'mobile';
        }
        //inisialisasi
        date_default_timezone_set('Asia/Jakarta');

        $dataTahun = DB::table('tagihan')
        ->select('thn_tagihan')
        ->groupBy('thn_tagihan')
        ->get();

        return view('kasir.index',[
            'dataset'=>$dataset,
            'platform'=>$platform,
            'month'=>date("m", time()),
            'tahun'=>date("Y", time()),
            'dataTahun'=>$dataTahun,
            'index'=>$data,
            'bulan'=>$bulan,
        ]);
    }

    public function bayar($id){
        date_default_timezone_set('Asia/Jakarta');
        $time = date("d/m/Y H:i:s", time());
        $blnSekarang = date("Y-m", time());
        $blnLalu = strtotime($blnSekarang);
        $blnPakai = date("Y-m", strtotime("-2 month", $blnLalu)); //-1 month seharusnya
        $blnTagihan = Kasir::indoBln($blnSekarang);

        $tagihan = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai',$blnPakai]])
        ->select(
            'nama as pengguna',
            'kd_kontrol as kontrol',
            'awal_airbersih as awalAir',
            'akhir_airbersih as akhirAir',
            'pakai_airbersih as pakaiAir',
            'awal_listrik as awalListrik',
            'akhir_listrik as akhirListrik',
            'pakai_listrik as pakaiListrik',
            'sel_listrik as listrik', 
            'sel_airbersih as airbersih', 
            'sel_keamananipk as keamananipk',
            'sel_kebersihan as kebersihan',
            'sel_airkotor as airkotor',
            'sel_lain as lain')
        ->first();

        $tunggakan = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','<',$blnPakai]])
        ->select(
            DB::raw('SUM(sel_tagihan) as tunggakan'),
            DB::raw('SUM(den_tagihan) as denda'))
        ->get();

        $total = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])
        ->select(DB::raw('SUM(sel_lain) as lain'),DB::raw('SUM(sel_tagihan) as total'))
        ->get();

        $awalListrik = number_format($tagihan->awalListrik);
        $akhirListrik = number_format($tagihan->akhirListrik);
        $pakaiListrik = number_format($tagihan->pakaiListrik);
        $listrik = number_format($tagihan->listrik);
        
        $awalAir = number_format($tagihan->awalAir);
        $akhirAir = number_format($tagihan->akhirAir);
        $pakaiAir = number_format($tagihan->pakaiAir);
        $airbersih = number_format($tagihan->airbersih);

        $keamananipk = number_format($tagihan->keamananipk);

        $kebersihan = number_format($tagihan->kebersihan);

        $airkotor = number_format($tagihan->airkotor);

        $pengguna = $tagihan->pengguna;
        $kontrol = $tagihan->kontrol;

        $denda = number_format($tunggakan[0]->denda);
        $tunggakan = number_format($tunggakan[0]->tunggakan - $tagihan->lain);
        $lain = number_format($total[0]->lain);

        $total = number_format($total[0]->total);

        $kasir = Session::get('username');

        $agent = new Agent();
        if($agent->isDesktop()){
            $platform = 'desktop';
        }
        else{
            $platform = 'mobile';
        }

        $profile = CapabilityProfile::load("POS-5890");
        $connector = new RawbtPrintConnector();
        $printer = new Printer($connector,$profile);

        if($platform == 'mobile'){
            try {
                // //MOBILE
                $items = array(
                    new StrukMobile("Listrik", $awalListrik, $akhirListrik, $pakaiListrik, $listrik, 'listrik'),
                    new StrukMobile("Air Bersih", $awalAir, $akhirAir, $pakaiAir, $airbersih, 'airbersih'),
                    new StrukMobile("K.aman IPK", '', '', '', $keamananipk, 'keamananipk'),
                    new StrukMobile("Kebersihan", '', '', '', $kebersihan, 'kebersihan'),
                    new StrukMobile("Air Kotor", '', '', '', $airkotor, 'airkotor'),
                    new StrukMobile("Tunggakan", '', '', '', $tunggakan, 'tunggakan'),
                    new StrukMobile("Denda", '', '', '', $denda, 'denda'),
                    new StrukMobile("Lain Lain", '', '', '', $lain, 'lain'),
                );
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("================================================\n");
                $printer -> text("Badan Pengelola Pusat Perdagangan Caringin.\n");
                $printer -> selectPrintMode();
                $printer -> text("Jl. Soetta No.220 Blok A1 No.21-24\n");
                $printer -> text("================================================\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Pedagang : ".$pengguna."\n");
                $printer -> text("Kontrol  : ".$kontrol."\n");
                $printer -> text("Tagihan  : ".$blnTagihan."\n");
                $printer -> text("Kasir    : ".$kasir."\n");
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("------------------------------------------------\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> setEmphasis(true);
                $printer -> text(new StrukMobile('Fasilitas', 'Awal', 'Akhir', 'Pakai', 'Rp.', 'header'));
                $printer -> setEmphasis(false);
                $printer -> text("------------------------------------------------\n");

                foreach ($items as $item) {
                    $printer -> text($item);
                }
                
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("------------------------------------------------\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text(new Item('Total', $total));
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("------------------------------------------------\n");
                $printer -> text("Total pembayaran telah termasuk PPN\n");
                $printer -> text("Dibayar pada ".$time. "\n\n");
                $printer -> text("Struk ini merupakan bukti\n");
                $printer -> text("pembayaran yang sah, harap disimpan\n");
                $printer -> cut();

                //LAPANGAN
                // $items = array(
                //     new StrukLapangan("Listrik", $listrik),
                //     new StrukLapangan("Air Bersih", $airbersih),
                //     new StrukLapangan("K.aman IPK", $keamananipk),
                //     new StrukLapangan("Kebersihan", $kebersihan),
                //     new StrukLapangan("Air Kotor", $airkotor),
                //     new StrukLapangan("Tunggakan", $tunggakan),
                //     new StrukLapangan("Denda", $denda),
                //     new StrukLapangan("Lain Lain", $lain),
                // );
                // $printer->setJustification(Printer::JUSTIFY_CENTER);
                // $printer->text("Badan\n");
                // $printer->text("Pengelola Pusat Perdagangan\n");
                // $printer->text("Caringin\n");
                // $printer->selectPrintMode();
                // $printer->text("Jl.Soetta 220 Blok A1 No.21-24\n");
                // $printer->text("--------------------------------\n");
                // $printer->setJustification(Printer::JUSTIFY_LEFT);
                // $printer->text("Pdg: ".$pengguna."\n");
                // $printer->text("Alm: ".$kontrol."\n");
                // $printer->text("Tgh: ".$blnTagihan."\n");
                // $printer->text("Ksr: ".$kasir."\n");
                // $printer->setJustification(Printer::JUSTIFY_CENTER);
                // $printer->text("--------------------------------\n");
                // $printer->setJustification(Printer::JUSTIFY_LEFT);
                // $printer->setEmphasis(true);
                // $printer->text(new StrukLapangan('Fasilitas', 'Rp.'));
                // $printer->setEmphasis(false);
                // $printer->text("--------------------------------\n");

                // foreach ($items as $item) {
                //     $printer->text($item);
                // }
                
                // $printer->setJustification(Printer::JUSTIFY_CENTER);
                // $printer->text("--------------------------------\n");
                // $printer->setJustification(Printer::JUSTIFY_LEFT);
                // $printer->text(new StrukLapangan('Total', $total));
                // $printer->setJustification(Printer::JUSTIFY_CENTER);
                // $printer->text("--------------------------------\n");
                // $printer->text("Total pembayaran termasuk PPN\n");
                // $printer->text("Dibayar pada ".$time. "\n\n");
                // $printer->text("Struk ini merupakan\n");
                // $printer->text("bukti pembayaran yang sah,\n");
                // $printer->text("harap disimpan\n");
                // $printer->cut();
            } catch (Exception $e) {
                return redirect()->route('kasirindex','now')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
        }
        else{
            try{
                $items = array(
                    new StrukLarge("Listrik", $awalListrik, $akhirListrik, $pakaiListrik, $listrik, 'listrik'),
                    new StrukLarge("Air Bersih", $awalAir, $akhirAir, $pakaiAir, $airbersih, 'airbersih'),
                    new StrukLarge("K.aman IPK", '', '', '', $keamananipk, 'keamananipk'),
                    new StrukLarge("Kebersihan", '', '', '', $kebersihan, 'kebersihan'),
                    new StrukLarge("Air Kotor", '', '', '', $airkotor, 'airkotor'),
                    new StrukLarge("Tunggakan", '', '', '', $tunggakan, 'tunggakan'),
                    new StrukLarge("Denda", '', '', '', $denda, 'denda'),
                    new StrukLarge("Lain Lain", '', '', '', $lain, 'lain'),
                );

                // Content
                $printer->text("\n\n");
                $printer->text("                           BADAN PENGELOLA PUSAT PERDAGANGAN CARINGIN                            \n");
                $printer->text("                                 KEMITRAAN KOPPAS INDUK BANDUNG                                  \n");
                $printer->text("                                        SEGI PEMBAYARAN                                          \n");
                $printer->text("=================================================================================================\n");
                $printer->text(new StrukLarge("Pengguna : ".$pengguna, '', '', '', "Kasir   : ".$kasir, 'header'));
                $printer->text(new StrukLarge("Kontrol  : ".$kontrol, '', '', '', "Tagihan : ".$blnTagihan, 'header'));
                $printer->text("--- FASILITAS --------------- AWAL ------------- AKHIR ------------- PAKAI ----------- JUMLAH ---\n");
                foreach ($items as $item) {
                    $printer -> text($item);
                }
                $printer->text("-------------------------------------------------------------------------------------------------\n");
                $printer->text(new StrukLarge("Total Pembayaran", '', '', '', "Rp. ".$total, 'total'));
                $printer->text("-------------------------------------------------------------------------------------------------\n");
                $printer->text(new StrukLarge("Dibayar pada ".$time." - Total pembayaran telah termasuk PPN", '', '', '', '', 'footer')."\n");
            } catch (Exception $e) {
                return redirect()->route('kasirindex','now')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
        }
    }

    public function rincian($data, $id){
        $d = Kasir::rincian($data,$id);

        return json_encode(array(
            "id"=>$id,
            "tagihanListrik"=>number_format($d[1]->sel_listrik),
            "tagihanAirBersih"=>number_format($d[1]->sel_airbersih),
            "tagihanKeamananIpk"=>number_format($d[1]->sel_keamananipk),
            "tagihanKebersihan"=>number_format($d[1]->sel_kebersihan),
            "tagihanAirKotor"=>number_format($d[1]->sel_airkotor),
            "tagihanLain"=>number_format($d[1]->sel_lain),
            "tagihanTunggakan"=>number_format($d[0]->tunggakan),
            "tagihanDenda"=>number_format($d[0]->denda),
            "tagihanTotal"=>number_format($d[2]->total),
        ));
    }

    public function bayarStore(Request $request){
        $bayar = '';
        $tagihan = '';
        try{
            //Pembayaran Kontan
            $id = $request->get('tempatId');
            $tagihan = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])->get();
            foreach($tagihan as $d){
                date_default_timezone_set('Asia/Jakarta');
                $tanggal = date("Y-m-d", time());
                $bulan = date("Y-m", time());
                $tahun = date("Y", time());
                $pembayaran = new Pembayaran;
                $pembayaran->tgl_bayar = $tanggal;
                $pembayaran->bln_bayar = $bulan;
                $pembayaran->thn_bayar = $tahun;
                $pembayaran->via_bayar = 'kasir';
                $pembayaran->id_kasir = Session::get('userId');
                $pembayaran->nama = Session::get('username');
                $pembayaran->id_tempat = $d->id_tempat;
                $pembayaran->blok = $d->blok;
                $pembayaran->kd_kontrol = $d->kd_kontrol;
                $pembayaran->id_pengguna = $d->id_pengguna;
                $pembayaran->pengguna = $d->nama;
                $pembayaran->id_tagihan = $d->id;
                $pembayaran->byr_listrik = $d->sel_listrik;
                $pembayaran->byr_denlistrik = $d->den_listrik;
                $pembayaran->sel_listrik = 0;
                $pembayaran->byr_airbersih = $d->sel_airbersih;
                $pembayaran->byr_denairbersih = $d->den_airbersih;
                $pembayaran->sel_airbersih = 0;
                $pembayaran->byr_keamananipk = $d->sel_keamananipk;
                $pembayaran->sel_keamananipk = 0;
                $pembayaran->byr_kebersihan = $d->sel_kebersihan;
                $pembayaran->sel_kebersihan = 0;
                $pembayaran->byr_airkotor = $d->sel_airkotor;
                $pembayaran->sel_airkotor = 0;
                $pembayaran->byr_lain = $d->sel_lain;
                $pembayaran->sel_lain = 0;
                $pembayaran->diskon = $d->dis_tagihan;
                $pembayaran->total = $d->sel_tagihan;
                $pembayaran->sel_tagihan = 0;
                $pembayaran->save();

                //-------------------------------------------------------------

                $d->rea_airbersih = $d->ttl_airbersih;
                $d->sel_airbersih = 0;
                $d->rea_listrik = $d->ttl_listrik;
                $d->sel_listrik = 0;
                $d->rea_keamananipk = $d->ttl_keamananipk;
                $d->sel_keamananipk = 0;
                $d->rea_kebersihan = $d->ttl_kebersihan;
                $d->sel_kebersihan = 0;
                $d->rea_airkotor = $d->ttl_airkotor;
                $d->sel_airkotor = 0;
                $d->rea_lain = $d->ttl_lain;
                $d->sel_lain = 0;
                $d->rea_tagihan = $d->ttl_tagihan;
                $d->sel_tagihan = 0;
                $d->save();
            }
            $bayar = 'kontan';
            return redirect()->route('kasirindex','now')->with('success','Tagihan Dibayar');
        } catch(\Exception $e){
            // dd($e);
            return redirect()->route('kasirindex','now')->with('error','Pembayaran Gagal');
        } finally{
            //Pembayaran Kontan
            if($bayar == 'kontan'){
                foreach($tagihan as $d){
                    $d->stt_lunas = 1;
                    $d->stt_bayar = 1;
                    $d->save();
                }
            }
        }
    }

    public function cari(Request $request){
        return view('errors.cmp',['id'=>$request->get('kode')]);
    }

    public function penerimaan(Request $request){
        // echo $request->get('tanggal');
        return view('kasir.penerimaan');
    }

    public function scan($id){
        return view('errors.cmp',['id'=>$id]);
    }
}
