<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Tagihan;
use App\Models\TempatUsaha;
use App\Models\User;

class MasterController extends Controller
{
    public function index(){
        date_default_timezone_set('Asia/Jakarta');
        $thn = date("Y", time());

        $rincian = Tagihan::rincian($thn);
        $pendapatan = Tagihan::pendapatan($thn);
        $akumulasi = Tagihan::akumulasi($thn);

        // $dataset = Tagihan::all();
        // foreach($dataset as $data){
        //     $data->via_tambah = Session::get('username');
        //     $data->stt_publish = 1;
        //     $data->save();
        // }

        // Tagihan::hitungListrik();
        // Tagihan::hitungAir();
        // Tagihan::cekMeter();
        // Tagihan::keamananIpk();
        // Tagihan::kebersihan();
        // Tagihan::alamat();

        return view('master.index',[
            'pengguna'=>TempatUsaha::pengguna(),
            'penggunaAktif'=>TempatUsaha::penggunaAktif(),
            'penggunaNonAktif'=>TempatUsaha::penggunaNonAktif(),
            'penggunaAirBersih'=>TempatUsaha::penggunaAirBersih(),
            'penggunaListrik'=>TempatUsaha::penggunaListrik(),
            'penggunaKeamananIpk'=>TempatUsaha::penggunaKeamananIpk(),
            'penggunaKebersihan'=>TempatUsaha::penggunaKebersihan(),
            'reaAirBersih'=>Tagihan::reaAirBersih($thn),
            'reaListrik'=>Tagihan::reaListrik($thn),
            'reaKeamananIpk'=>Tagihan::reaKeamananIpk($thn),
            'reaKebersihan'=>Tagihan::reaKebersihan($thn),
            'selAirBersih'=>Tagihan::selAirBersih($thn),
            'selListrik'=>Tagihan::selListrik($thn),
            'selKeamananIpk'=>Tagihan::selKeamananIpk($thn),
            'selKebersihan'=>Tagihan::selKebersihan($thn),
            'listrikJan'=>$rincian[0][0],
            'listrikFeb'=>$rincian[0][1],
            'listrikMar'=>$rincian[0][2],
            'listrikApr'=>$rincian[0][3],
            'listrikMei'=>$rincian[0][4],
            'listrikJun'=>$rincian[0][5],
            'listrikJul'=>$rincian[0][6],
            'listrikAgu'=>$rincian[0][7],
            'listrikSep'=>$rincian[0][8],
            'listrikOkt'=>$rincian[0][9],
            'listrikNov'=>$rincian[0][10],
            'listrikDes'=>$rincian[0][11],
            'airJan'=>$rincian[1][0],
            'airFeb'=>$rincian[1][1],
            'airMar'=>$rincian[1][2],
            'airApr'=>$rincian[1][3],
            'airMei'=>$rincian[1][4],
            'airJun'=>$rincian[1][5],
            'airJul'=>$rincian[1][6],
            'airAgu'=>$rincian[1][7],
            'airSep'=>$rincian[1][8],
            'airOkt'=>$rincian[1][9],
            'airNov'=>$rincian[1][10],
            'airDes'=>$rincian[1][11],
            'keamananipkJan'=>$rincian[2][0],
            'keamananipkFeb'=>$rincian[2][1],
            'keamananipkMar'=>$rincian[2][2],
            'keamananipkApr'=>$rincian[2][3],
            'keamananipkMei'=>$rincian[2][4],
            'keamananipkJun'=>$rincian[2][5],
            'keamananipkJul'=>$rincian[2][6],
            'keamananipkAgu'=>$rincian[2][7],
            'keamananipkSep'=>$rincian[2][8],
            'keamananipkOkt'=>$rincian[2][9],
            'keamananipkNov'=>$rincian[2][10],
            'keamananipkDes'=>$rincian[2][11],
            'kebersihanJan'=>$rincian[3][0],
            'kebersihanFeb'=>$rincian[3][1],
            'kebersihanMar'=>$rincian[3][2],
            'kebersihanApr'=>$rincian[3][3],
            'kebersihanMei'=>$rincian[3][4],
            'kebersihanJun'=>$rincian[3][5],
            'kebersihanJul'=>$rincian[3][6],
            'kebersihanAgu'=>$rincian[3][7],
            'kebersihanSep'=>$rincian[3][8],
            'kebersihanOkt'=>$rincian[3][9],
            'kebersihanNov'=>$rincian[3][10],
            'kebersihanDes'=>$rincian[3][11],
            'tagihanJan'=>$pendapatan[0][0],
            'tagihanFeb'=>$pendapatan[0][1],
            'tagihanMar'=>$pendapatan[0][2],
            'tagihanApr'=>$pendapatan[0][3],
            'tagihanMei'=>$pendapatan[0][4],
            'tagihanJun'=>$pendapatan[0][5],
            'tagihanJul'=>$pendapatan[0][6],
            'tagihanAgu'=>$pendapatan[0][7],
            'tagihanSep'=>$pendapatan[0][8],
            'tagihanOkt'=>$pendapatan[0][9],
            'tagihanNov'=>$pendapatan[0][10],
            'tagihanDes'=>$pendapatan[0][11],
            'realisasiJan'=>$pendapatan[1][0],
            'realisasiFeb'=>$pendapatan[1][1],
            'realisasiMar'=>$pendapatan[1][2],
            'realisasiApr'=>$pendapatan[1][3],
            'realisasiMei'=>$pendapatan[1][4],
            'realisasiJun'=>$pendapatan[1][5],
            'realisasiJul'=>$pendapatan[1][6],
            'realisasiAgu'=>$pendapatan[1][7],
            'realisasiSep'=>$pendapatan[1][8],
            'realisasiOkt'=>$pendapatan[1][9],
            'realisasiNov'=>$pendapatan[1][10],
            'realisasiDes'=>$pendapatan[1][11],
            'selisihJan'=>$pendapatan[2][0],
            'selisihFeb'=>$pendapatan[2][1],
            'selisihMar'=>$pendapatan[2][2],
            'selisihApr'=>$pendapatan[2][3],
            'selisihMei'=>$pendapatan[2][4],
            'selisihJun'=>$pendapatan[2][5],
            'selisihJul'=>$pendapatan[2][6],
            'selisihAgu'=>$pendapatan[2][7],
            'selisihSep'=>$pendapatan[2][8],
            'selisihOkt'=>$pendapatan[2][9],
            'selisihNov'=>$pendapatan[2][10],
            'selisihDes'=>$pendapatan[2][11],
            'tagihanJanAku'=>$akumulasi[0][0],
            'tagihanFebAku'=>$akumulasi[0][1],
            'tagihanMarAku'=>$akumulasi[0][2],
            'tagihanAprAku'=>$akumulasi[0][3],
            'tagihanMeiAku'=>$akumulasi[0][4],
            'tagihanJunAku'=>$akumulasi[0][5],
            'tagihanJulAku'=>$akumulasi[0][6],
            'tagihanAguAku'=>$akumulasi[0][7],
            'tagihanSepAku'=>$akumulasi[0][8],
            'tagihanOktAku'=>$akumulasi[0][9],
            'tagihanNovAku'=>$akumulasi[0][10],
            'tagihanDesAku'=>$akumulasi[0][11],
            'realisasiJanAku'=>$akumulasi[1][0],
            'realisasiFebAku'=>$akumulasi[1][1],
            'realisasiMarAku'=>$akumulasi[1][2],
            'realisasiAprAku'=>$akumulasi[1][3],
            'realisasiMeiAku'=>$akumulasi[1][4],
            'realisasiJunAku'=>$akumulasi[1][5],
            'realisasiJulAku'=>$akumulasi[1][6],
            'realisasiAguAku'=>$akumulasi[1][7],
            'realisasiSepAku'=>$akumulasi[1][8],
            'realisasiOktAku'=>$akumulasi[1][9],
            'realisasiNovAku'=>$akumulasi[1][10],
            'realisasiDesAku'=>$akumulasi[1][11],
            'selisihJanAku'=>$akumulasi[2][0],
            'selisihFebAku'=>$akumulasi[2][1],
            'selisihMarAku'=>$akumulasi[2][2],
            'selisihAprAku'=>$akumulasi[2][3],
            'selisihMeiAku'=>$akumulasi[2][4],
            'selisihJunAku'=>$akumulasi[2][5],
            'selisihJulAku'=>$akumulasi[2][6],
            'selisihAguAku'=>$akumulasi[2][7],
            'selisihSepAku'=>$akumulasi[2][8],
            'selisihOktAku'=>$akumulasi[2][9],
            'selisihNovAku'=>$akumulasi[2][10],
            'selisihDesAku'=>$akumulasi[2][11],
            'thn'=>$thn,
        ]);
    }
}
