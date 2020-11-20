<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tagihan;
use App\Models\TempatUsaha;
use App\Models\User;

class MasterController extends Controller
{
    public function index(){
        date_default_timezone_set('Asia/Jakarta');
        $thn = date("Y", time());

        $pendapatan = Tagihan::pendapatan($thn);
        $akumulasi = Tagihan::akumulasi($thn);

        $data = User::where('role','nasabah')->get();

        $dataset = Tagihan::all();
        foreach($dataset as $data){
            $data->via_tambah = Session::get('username');
            $data->stt_publish = 1;
            $data->save();
        }

        // Tagihan::hitungListrik();
        // Tagihan::hitungAir();

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
