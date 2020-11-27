<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Kasir;
use App\Models\Tagihan;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;

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
                //Connector
                $profile = CapabilityProfile::load("POS-5890");
                $connector = new RawbtPrintConnector();
                $printer = new Printer($connector, $profile);
    
                // Content
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Fahni Amsyari.\n");
                $printer->selectPrintMode();
                $printer->text("Levind Sein.\n");
                $printer->feed();
            
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
                $profile = CapabilityProfile::load("POS-5890");
                $connector = new RawbtPrintConnector();
                        
                $printer = new Printer($connector, $profile);

                // Content
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("Fahni Amsyari.\n");
                $printer->selectPrintMode();
                $printer->text("Levind Sein.\n");
                $printer->feed();
                
            } catch (Exception $e) {
                return redirect()->route('kasirindex')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
        }
    }

    public function rincian($id){
        $dataset = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])
        ->select(
            DB::raw('SUM(sel_listrik) as tagihanListrik'),
            DB::raw('SUM(sel_airbersih) as tagihanAirBersih'),
            DB::raw('SUM(sel_keamananipk) as tagihanKeamananIpk'),
            DB::raw('SUM(sel_kebersihan) as tagihanKebersihan'))
        ->get();

        $listrik = number_format($dataset[0]->tagihanListrik);
        $airbersih = number_format($dataset[0]->tagihanAirBersih);
        $keamananipk = number_format($dataset[0]->tagihanKeamananIpk);
        $kebersihan = number_format($dataset[0]->tagihanKebersihan);
        return json_encode(array(
            "id"=>$id,
            "tagihanListrik"=>$listrik,
            "tagihanAirBersih"=>$airbersih,
            "tagihanKeamananIpk"=>$keamananipk,
            "tagihanKebersihan"=>$kebersihan,
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
