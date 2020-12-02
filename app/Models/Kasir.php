<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\TempatUsaha;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\PasangAlat;

class Kasir extends Model
{
    public static function tagihan(){
        $tempat = TempatUsaha::select('id','kd_kontrol','id_pengguna')->orderBy('kd_kontrol','asc')->get();
        $dataset = array();
        $i = 0;
        foreach($tempat as $t){
            $dataset[$i][0] = $t->kd_kontrol;
            $pengguna = User::find($t->id_pengguna);
            $dataset[$i][1] = $pengguna->nama;
            $tagihan = Tagihan::where([['id_tempat',$t->id],['stt_lunas',0]])
            ->select(DB::raw('SUM(sel_tagihan) as tagihan'))
            ->get();
            $pasang = PasangAlat::where([['id_tempat',$t->id],['stt_lunas',0]])
            ->select(DB::raw('SUM(sel_pasang) as tagihan'))
            ->get();
            if($pasang != NULL){
                $dataset[$i][2] = $tagihan[0]->tagihan + $pasang[0]->tagihan;
            }
            else{
                $dataset[$i][2] = $tagihan[0]->tagihan;
            }
            $dataset[$i][3] = $t->id;
            $i++;
        }
        return $dataset;
    }

    public static function rincian($id){
        date_default_timezone_set('Asia/Jakarta');
        $bulan = date("Y-m", time());
        $time = strtotime($bulan);
        $bulan = date("Y-m", strtotime("-2 month", $time)); //-1 month seharusnya

        $data1 = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai','<',$bulan]])
        ->select(
            DB::raw('SUM(sel_tagihan) as tunggakan'),
            DB::raw('SUM(den_tagihan) as denda'))
        ->get();
        
        $data2 = Tagihan::where([['id_tempat',$id],['stt_lunas',0],['bln_pakai',$bulan]])
        ->select(
            'sel_listrik',
            'sel_airbersih',
            'sel_keamananipk',
            'sel_kebersihan',
            'sel_airkotor',
            'sel_lain',
        )
        ->first();
    
        $data3 = Tagihan::where([['id_tempat',$id],['stt_lunas',0]])
        ->select(DB::raw('SUM(sel_tagihan) as total'))
        ->get();
        
        return array($data1[0],$data2,$data3[0]);
    }

    public static function indoBln($date){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $date);
        return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
}
