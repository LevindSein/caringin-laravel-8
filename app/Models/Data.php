<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Tagihan;
use App\Models\TempatUsaha;

class Data extends Model
{
    public static function tagihan(){
        return Tagihan::groupBy('bln_tagihan')->orderBy('bln_tagihan','desc')
        ->select(
            'bln_tagihan',
            DB::raw('SUM(ttl_airbersih) as ttl_airbersih'),
            DB::raw('SUM(rea_airbersih) as rea_airbersih'),
            DB::raw('SUM(sel_airbersih) as sel_airbersih'),
            DB::raw('SUM(ttl_listrik) as ttl_listrik'),
            DB::raw('SUM(rea_listrik) as rea_listrik'),
            DB::raw('SUM(sel_listrik) as sel_listrik'),
            DB::raw('SUM(ttl_keamananipk) as ttl_keamananipk'),
            DB::raw('SUM(rea_keamananipk) as rea_keamananipk'),
            DB::raw('SUM(sel_keamananipk) as sel_keamananipk'),
            DB::raw('SUM(ttl_kebersihan) as ttl_kebersihan'),
            DB::raw('SUM(rea_kebersihan) as rea_kebersihan'),
            DB::raw('SUM(sel_kebersihan) as sel_kebersihan'),
            DB::raw('SUM(ttl_airkotor) as ttl_airkotor'),
            DB::raw('SUM(rea_airkotor) as rea_airkotor'),
            DB::raw('SUM(sel_airkotor) as sel_airkotor'),
            DB::raw('SUM(ttl_lain) as ttl_lain'),
            DB::raw('SUM(rea_lain) as rea_lain'),
            DB::raw('SUM(sel_lain) as sel_lain'),
            DB::raw('SUM(ttl_tagihan) as ttl_tagihan'),
            DB::raw('SUM(rea_tagihan) as rea_tagihan'),
            DB::raw('SUM(sel_tagihan) as sel_tagihan'),
            )
        ->get();
    }

    public static function tunggakan(){
        return Tagihan::groupBy('bln_tagihan')
        ->where('stt_lunas',0)
        ->orderBy('bln_tagihan','desc')
        ->select(
            'bln_tagihan',
            DB::raw('COUNT(*) as pengguna'),
            DB::raw('SUM(sel_airbersih) as sel_airbersih'),
            DB::raw('SUM(sel_listrik) as sel_listrik'),
            DB::raw('SUM(sel_keamananipk) as sel_keamananipk'),
            DB::raw('SUM(sel_kebersihan) as sel_kebersihan'),
            DB::raw('SUM(sel_airkotor) as sel_airkotor'),
            DB::raw('SUM(sel_lain) as sel_lain'),
            DB::raw('SUM(sel_tagihan) as sel_tagihan'),
            )
        ->get();
    }
    
    public static function bongkaran(){
        $data = Tagihan::groupBy('id_tempat')
        ->select('id_tempat')
        ->get();
        $i = 0;
        $bongkar = array();
        foreach($data as $d){
            $kontrol = TempatUsaha::find($d->id_tempat);
            $kontrol = $kontrol->kd_kontrol;
            $bongkar[$i][0] = $kontrol;

            $denda1 = Tagihan::where('id_tempat',$d->id_tempat)
            ->where('stt_denda',1)
            ->select('stt_denda')
            ->first();
            $denda2 = Tagihan::where('id_tempat',$d->id_tempat)
            ->where('stt_denda',2)
            ->select('stt_denda')
            ->first();
            $denda3 = Tagihan::where('id_tempat',$d->id_tempat)
            ->where('stt_denda',3)
            ->select('stt_denda')
            ->first();
            $denda4 = Tagihan::where('id_tempat',$d->id_tempat)
            ->where('stt_denda',4)
            ->select('stt_denda')
            ->first();
            $bongkar[$i][1] = $denda1;
            $bongkar[$i][2] = $denda2;
            $bongkar[$i][3] = $denda3;
            $bongkar[$i][4] = $denda4;

            $tunggakan = Tagihan::where('id_tempat',$d->id_tempat)
            ->whereIn('stt_denda',[1,2,3,4])
            ->select(DB::raw('SUM(sel_tagihan) as tunggakan'))
            ->get();
            $bongkar[$i][5] = $tunggakan[0]->tunggakan;

            $i++;
        }
        return $bongkar;
    }
    
    public static function penghapusan(){
        
    }
}
