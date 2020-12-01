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
