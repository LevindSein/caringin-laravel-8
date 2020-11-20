<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                $printer->text("Fahni Amsyari.\n");
                $printer->selectPrintMode();
                $printer->text("Levind Sein.\n");
            
                //Print
                $printer->cut();
                $printer->pulse();
            
            } catch (Exception $e) {
                return redirect()->route('kasirindex')->with('error','Kesalahan Sistem');
            } finally {
                $printer->close();
            }
            return view('kasir.print');
        }
        else{
            echo $id;
        }
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
