<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Tagihan;
use App\Models\TempatUsaha;

class Nasabah extends Model
{
    public static function tagihan($id){
        $tagihan = Tagihan::where([['id_pengguna',$id],['stt_lunas',0]])
        ->select(DB::raw('SUM(sel_tagihan) as tagihan'))
        ->get();
        return $tagihan[0]->tagihan;
    }

    public static function pemilik($id){
        $tempat = TempatUsaha::where('id_pemilik',$id)
        ->get();
        return $tempat->count();
    }
    
    public static function pengguna($id){
        $tempat = TempatUsaha::where('id_pengguna',$id)
        ->get();
        return $tempat->count();
    }

    public static function data($id){
        return Tagihan::groupBy('bln_tagihan')->where('id_pengguna',$id)->orderBy('bln_tagihan','desc')
        ->select('bln_tagihan',
            DB::raw('SUM(ttl_tagihan) as tagihan'),
            DB::raw('SUM(rea_tagihan) as realisasi'),
            DB::raw('SUM(sel_tagihan) as selisih'),)
        ->get();
    }
}
