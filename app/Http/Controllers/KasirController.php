<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Kasir;
use App\Models\Tagihan;
use App\Models\Item;
use App\Models\StrukMobile;

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
        $agent = new Agent();
        if($agent->isDesktop()){
            $platform = 'desktop';
        }
        else{
            $platform = 'mobile';
        }

        if($platform == 'mobile'){
            try {
                $pedagang = "";
                $anggota = "";
                $air = 0;
                $listrik = 0;
                $keamanan = 0;
                $kebersihan = 0;
                $denda = 0;
                $ttl = 0;
                foreach($dataset as $d){
                    $pedagang = $d->NM_PEDAGANG;
                    $anggota = $d->NO_ANGGOTA;
                    $air = $air + $d->TTL_AIR;
                    $listrik = $listrik + $d->TTL_LISTRIK;
                    $keamanan = $keamanan + $d->TTL_IPKKEAMANAN;
                    $kebersihan = $kebersihan + $d->TTL_KEBERSIHAN;
                    $denda = $denda + $d->DENDA;
                    $ttl = $ttl + $d->TTL_TAGIHAN;
                }
                $air = number_format(1000000);
                $listrik = number_format(2541200);
                $keamanan = number_format(145000);
                $kebersihan = number_format(260000);
                $denda = number_format(100000);
                $airkotor = number_format(0);
                $lain = number_format(0);
                $ttl = number_format(3674000);

                $kontrol = 'A-1-001';
                $bulanTagihan = 'Oktober 2020';

                //Connector
                $profile = CapabilityProfile::load("POS-5890");
                $connector = new RawbtPrintConnector();
                $printer = new Printer($connector, $profile);

                /* Information for the receipt */
                $items = array(
                    new Item("Listrik", $listrik),
                    new Item("Air Bersih", $airbersih),
                    new Item("Keamanan IPK", $keamanan),
                    new Item("Kebersihan", $kebersihan),
                    new Item("Air Kotor", $airkotor),
                    new Item("Denda", $denda),
                    new Item("Tunggakan", $tunggakan),
                    new Item("Lain Lain", $lain),
                );
                $total = new Item('Total', $ttl);

                /* Name of shop */
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("================================================\n");
                $printer -> text("BADAN PENGELOLA PUSAT PERDAGANGAN CARINGIN\n");
                $printer -> selectPrintMode();
                $printer -> text("KEMITRAAN KOPPAS INDUK BANDUNG\n");
                $printer -> text("================================================\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text("Pedagang : ".$pedagang."\n");
                $printer -> text("Tagihan  : ".$bulanTagihan."\n");
                $printer -> text("Kasir    : ".$kasir."\n");
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("================================================\n");
                $printer -> feed();

                /* Title of receipt */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                $printer -> text($kontrol."\n");
                $printer -> selectPrintMode();

                /* Items */
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> setEmphasis(true);
                $printer -> text(new Item('', 'Rp'));
                $printer -> setEmphasis(false);
                foreach ($items as $item) {
                    $printer -> text($item);
                }
                
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("------------------------------------------------\n");
                $printer -> setJustification(Printer::JUSTIFY_LEFT);
                $printer -> text($total);
                $printer -> setJustification(Printer::JUSTIFY_CENTER);
                $printer -> text("------------------------------------------------\n");
                $printer -> text("Terimakasih telah melakukan Pembayaran\n");
                $printer -> text($date . "\n");

                //Print
                $printer->cut();
                $printer->pulse();
            
            } catch (Exception $e) {
                return redirect()->route('kasirindex')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
        }
        else{
            try{
                // $profile = CapabilityProfile::load("POS-5890");
                // $connector = new RawbtPrintConnector();
                        
                // $printer = new Printer($connector,$profile);

                // // Content
                // $printer->text("=================================================================================================\n");
                // $printer->text("                           BADAN PENGELOLA PUSAT PERDAGANGAN CARINGIN                            \n");
                // $printer->text("                                 KEMITRAAN KOPPAS INDUK BANDUNG                                  \n");
                // $printer->text("                                        SEGI PEMBAYARAN                                          \n");
                // $printer->text("   Fahni Amsyari                                                        Kasir : Fahni Amsyari    \n");
                // $printer->text("   A-1-001                                                            Tagihan : Oktober 2020     \n");
                // $printer->text("----- FASILITAS -----------  AWAL -------- AKHIR --------- PAKAI ---------------- JUMLAH --------\n");
                // $printer->text("      Listrik                                200 kWH                                             \n");
                // $printer->text("      Air Bersih                             50 M3                                               \n");
                // $printer->text("      Keamanan & IPK                         2 unit                                              \n");
                // $printer->text("      Kebersihan                             2 unit                                              \n");
                // $printer->text("      Air Kotor                                                                                  \n");
                // $printer->text("      Tunggakan                                                                                  \n");
                // $printer->text("      Denda                                                                                      \n");
                // $printer->text("      Lain - Lain                                                                                \n");
                // $printer->text("-------------------------------------------------------------------------------------------------\n");
                // $printer->text("   Total Pembayaran                                                                              \n");
                // $printer->text("-------------------------------------------------------------------------------------------------\n");
                // $printer->text("            Tanggal : 28 November 2020 - Total Pembayaran telah termasuk PPN                     \n");
                // $printer->feed();
                
                $profile = CapabilityProfile::load("POS-5890");
                $connector = new RawbtPrintConnector();
                        
                $printer = new Printer($connector,$profile);

                $items = array(
                    new StrukMobile("Listrik", 1000000, 1000000, 1000000, 1000000, 'listrik'),
                    new StrukMobile("Air Bersih", 5500000, 5500000, 5500000, 5500000, 'airbersih'),
                    new StrukMobile("K.aman IPK", '', '', '', 120000, 'keamananipk'),
                    new StrukMobile("Kebersihan", '', '', '', 120000, 'kebersihan'),
                    new StrukMobile("Air Kotor", '', '', '', 120000, 'airkotor'),
                    new StrukMobile("Tunggakan", '', '', '', 120000, 'tunggakan'),
                    new StrukMobile("Denda", '', '', '', 120000, 'denda'),
                    new StrukMobile("Lain Lain", '', '', '', 120000, 'lain'),
                );
                foreach ($items as $item) {
                    $printer -> text($item);
                }
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
        $bulan = date("Y-m", strtotime("-1 month", $time));

        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','!=',$bulan]])
        ->select(
            DB::raw('SUM(sel_tagihan) as tunggakan'),
            DB::raw('SUM(den_tagihan) as denda'))
        ->get();

        $tunggakan = number_format($dataset[0]->tunggakan);
        $denda = number_format($dataset[0]->denda);
        
        
        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','!=',$bulan]])
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
