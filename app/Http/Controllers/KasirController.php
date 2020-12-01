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

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;

use Jenssegers\Agent\Agent;

use Exception;

class KasirController extends Controller
{
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

        $tunggakan = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','<',$blnPakai]])
        ->select(
            DB::raw('SUM(sel_tagihan) as tunggakan'),
            DB::raw('SUM(den_tagihan) as denda'))
        ->get();

        $total = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])
        ->select(DB::raw('SUM(sel_lain) as lain'),DB::raw('SUM(sel_tagihan) as total'))
        ->get();

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
                // $items = array(
                //     new StrukMobile("Listrik", $awalListrik, $akhirListrik, $pakaiListrik, $listrik, 'listrik'),
                //     new StrukMobile("Air Bersih", $awalAir, $akhirAir, $pakaiAir, $airbersih, 'airbersih'),
                //     new StrukMobile("K.aman IPK", '', '', '', $keamananipk, 'keamananipk'),
                //     new StrukMobile("Kebersihan", '', '', '', $kebersihan, 'kebersihan'),
                //     new StrukMobile("Air Kotor", '', '', '', $airkotor, 'airkotor'),
                //     new StrukMobile("Tunggakan", '', '', '', $tunggakan, 'tunggakan'),
                //     new StrukMobile("Denda", '', '', '', $denda, 'denda'),
                //     new StrukMobile("Lain Lain", '', '', '', $lain, 'lain'),
                // );
                // $printer -> setJustification(Printer::JUSTIFY_CENTER);
                // $printer -> text("================================================\n");
                // $printer -> text("Badan Pengelola Pusat Perdagangan Caringin.\n");
                // $printer -> selectPrintMode();
                // $printer -> text("Jl. Soetta No.220 Blok A1 No.21-24\n");
                // $printer -> text("================================================\n");
                // $printer -> setJustification(Printer::JUSTIFY_LEFT);
                // $printer -> text("Pedagang : ".$pengguna."\n");
                // $printer -> text("Kontrol  : ".$kontrol."\n");
                // $printer -> text("Tagihan  : ".$blnTagihan."\n");
                // $printer -> text("Kasir    : ".$kasir."\n");
                // $printer -> setJustification(Printer::JUSTIFY_CENTER);
                // $printer -> text("------------------------------------------------\n");
                // $printer -> setJustification(Printer::JUSTIFY_LEFT);
                // $printer -> setEmphasis(true);
                // $printer -> text(new StrukMobile('Fasilitas', 'Awal', 'Akhir', 'Pakai', 'Rp.', 'header'));
                // $printer -> setEmphasis(false);
                // $printer -> text("------------------------------------------------\n");

                // foreach ($items as $item) {
                //     $printer -> text($item);
                // }
                
                // $printer -> setJustification(Printer::JUSTIFY_CENTER);
                // $printer -> text("------------------------------------------------\n");
                // $printer -> setJustification(Printer::JUSTIFY_LEFT);
                // $printer -> text(new Item('Total', $total));
                // $printer -> setJustification(Printer::JUSTIFY_CENTER);
                // $printer -> text("------------------------------------------------\n");
                // $printer -> text("Total pembayaran telah termasuk PPN\n");
                // $printer -> text("Dibayar pada ".$time. "\n");
                // $printer->cut();

                //LAPANGAN
                $items = array(
                    new StrukLapangan("Listrik", $listrik),
                    new StrukLapangan("Air Bersih", $airbersih),
                    new StrukLapangan("K.aman IPK", $keamananipk),
                    new StrukLapangan("Kebersihan", $kebersihan),
                    new StrukLapangan("Air Kotor", $airkotor),
                    new StrukLapangan("Tunggakan", $tunggakan),
                    new StrukLapangan("Denda", $denda),
                    new StrukLapangan("Lain Lain", $lain),
                );
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Badan\n");
                $printer->text("Pengelola Pusat Perdagangan\n");
                $printer->text("Caringin\n");
                $printer->selectPrintMode();
                $printer->text("Jl.Soetta 220 Blok A1 No.21-24\n");
                $printer->text("--------------------------------\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("Pdg: ".$pengguna."\n");
                $printer->text("Alm: ".$kontrol."\n");
                $printer->text("Tgh: ".$blnTagihan."\n");
                $printer->text("Ksr: ".$kasir."\n");
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("--------------------------------\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setEmphasis(true);
                $printer->text(new StrukLapangan('Fasilitas', 'Rp.'));
                $printer->setEmphasis(false);
                $printer->text("--------------------------------\n");

                foreach ($items as $item) {
                    $printer->text($item);
                }
                
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("--------------------------------\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text(new StrukLapangan('Total', $total));
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("--------------------------------\n");
                $printer->text("Total pembayaran termasuk PPN\n");
                $printer->text("Dibayar pada ".$time. "\n\n\n\n");
            } catch (Exception $e) {
                return redirect()->route('kasirindex')->with('error','Kesalahan Sistem');
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
                return redirect()->route('kasirindex')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
        }
    }

    public function rincian($id){
        date_default_timezone_set('Asia/Jakarta');
        $bulan = date("Y-m", time());
        $time = strtotime($bulan);
        $bulan = date("Y-m", strtotime("-2 month", $time)); //-1 month seharusnya

        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','<',$bulan]])
        ->select(
            DB::raw('SUM(sel_tagihan) as tunggakan'),
            DB::raw('SUM(den_tagihan) as denda'))
        ->get();

        $tunggakan = number_format($dataset[0]->tunggakan);
        $denda = number_format($dataset[0]->denda);
        
        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai',$bulan]])
        ->select(
            'sel_listrik',
            'sel_airbersih',
            'sel_keamananipk',
            'sel_kebersihan',
            'sel_airkotor',
            'sel_lain',
        )
        ->first();

        $listrik = number_format($dataset->sel_listrik);
        $airbersih = number_format($dataset->sel_airbersih);
        $keamananipk = number_format($dataset->sel_keamananipk);
        $kebersihan = number_format($dataset->sel_kebersihan);
        $airkotor = number_format($dataset->sel_airkotor);
        $lain = number_format($dataset->sel_lain);

        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])
        ->select(DB::raw('SUM(sel_tagihan) as total'))
        ->get();

        $total = number_format($dataset[0]->total);

        return json_encode(array(
            "id"=>$id,
            "tagihanListrik"=>$listrik,
            "tagihanAirBersih"=>$airbersih,
            "tagihanKeamananIpk"=>$keamananipk,
            "tagihanKebersihan"=>$kebersihan,
            "tagihanAirKotor"=>$airkotor,
            "tagihanLain"=>$lain,
            "tagihanTunggakan"=>$tunggakan,
            "tagihanDenda"=>$denda,
            "tagihanTotal"=>$total,
        ));
    }

    public function bayarStore(Request $request){
        $id = $request->get('tempatId');
        // $dataset = Tagihan::where('id_tempat')->get();
        
        return redirect()->route('kasirindex')->with('success','Tagihan Dibayar');
    }

    public function cari(Request $request){
        echo $request->get('kode');
    }

    public function penerimaan(){
        
    }

    public function scan($id){
        echo $id;
    }
}
