<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tagihan extends Model
{
    protected $table ='tagihan';
    protected $fillable = [
        'id',
        'id_tempat',
        'id_pemilik',
        'id_pengguna',
        'prs_diskon',
        'user',
        'blok',
        'tgl_tagihan',
        'tgl_expired',
        'bln_tagihan',
        'thn_tagihan',
        'tgl_bayar',
        'bln_bayar',
        'thn_bayar',
        'stt_lunas',
        'stt_bayar',
        'awal_air',
        'akhir_air',
        'pakai_air',
        'byr_air',
        'pemeliharaan_air',
        'beban_air',
        'arkot_air',
        'ttl_air',
        'rea_air',
        'sel_air',
        'den_air',
        'daya_listrik',
        'awal_listrik',
        'akhir_listrik',
        'pakai_listrik',
        'byr_listrik',
        'rekmin_listrik',
        'blok1_listrik',
        'blok2_listrik',
        'beban_listrik',
        'bpju_listrik',
        'ttl_listrik',
        'rea_listrik',
        'sel_listrik',
        'den_listrik',
        'ttl_keamananipk',
        'rea_keamananipk',
        'sel_keamananipk',
        'ttl_kebersihan',
        'rea_kebersihan',
        'sel_kebersihan',
        'ttl_airkotor',
        'rea_airkotor',
        'sel_airkotor',
        'ttl_lain',
        'rea_lain',
        'sel_lain',
        'ttl_tagihan_seb',
        'diskon_tagihan',
        'ttl_tagihan',
        'rea_tagihan',
        'sel_tagihan',
        'den_tagihan',
        'stt_denda',
        'stt_bongkar',
        'stt_kebersihan',
        'stt_keamananipk',
        'stt_listrik',
        'stt_airbersih',
        'bln_linkaja',
        'ket',
        'updated_at',
        'created_at'
    ];

    public static function reaAirBersih($thn){
        $realisasi = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->where('tempat_usaha.trf_airbersih',1)
        ->select(DB::raw('SUM(tagihan.rea_air) as realisasi'))
        ->get();

        return $realisasi[0]->realisasi;
    }

    public static function reaListrik($thn){
        $realisasi = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->where('tempat_usaha.trf_listrik',1)
        ->select(DB::raw('SUM(tagihan.rea_listrik) as realisasi'))
        ->get();

        return $realisasi[0]->realisasi;
    }

    public static function reaKeamananIpk($thn){
        $realisasi = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->whereNotNull('tempat_usaha.trf_keamananipk')
        ->select(DB::raw('SUM(tagihan.rea_keamananipk) as realisasi'))
        ->get();

        return $realisasi[0]->realisasi;
    }
    
    public static function reaKebersihan($thn){
        $realisasi = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->whereNotNull('tempat_usaha.trf_kebersihan')
        ->select(DB::raw('SUM(tagihan.rea_kebersihan) as realisasi'))
        ->get();

        return $realisasi[0]->realisasi;
    }
    
    public static function selAirBersih($thn){
        $selisih = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->where('tempat_usaha.trf_airbersih',1)
        ->select(DB::raw('SUM(tagihan.sel_air) as selisih'))
        ->get();

        return $selisih[0]->selisih;
    }

    public static function selListrik($thn){
        $selisih = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->where('tempat_usaha.trf_listrik',1)
        ->select(DB::raw('SUM(tagihan.sel_listrik) as selisih'))
        ->get();

        return $selisih[0]->selisih;
    }
    
    public static function selKeamananIpk($thn){
        $selisih = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->whereNotNull('tempat_usaha.trf_keamananipk')
        ->select(DB::raw('SUM(tagihan.sel_keamananipk) as selisih'))
        ->get();

        return $selisih[0]->selisih;
    }
    
    public static function selKebersihan($thn){
        $selisih = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->whereNotNull('tempat_usaha.trf_kebersihan')
        ->select(DB::raw('SUM(tagihan.sel_kebersihan) as selisih'))
        ->get();

        return $selisih[0]->selisih;
    }

    public static function pendapatan($thn){
        $tagihan = array();
        $realisasi = array();
        $selisih = array();
        $j=0;
        for($i=1; $i<=12; $i++){
            if($i < 10){
                $data = DB::table('tagihan')
                ->where('bln_tagihan',($thn."-0".$i))
                ->select(
                    DB::raw('SUM(ttl_tagihan) as tagihan'),
                    DB::raw('SUM(rea_tagihan) as realisasi'),
                    DB::raw('SUM(sel_tagihan) as selisih'))
                ->get();
            }
            else{
                $data = DB::table('tagihan')
                ->where('bln_tagihan',($thn."-".$i))
                ->select(
                    DB::raw('SUM(ttl_tagihan) as tagihan'),
                    DB::raw('SUM(rea_tagihan) as realisasi'),
                    DB::raw('SUM(sel_tagihan) as selisih'))
                ->get();
            }

            if($data[0]->tagihan == NULL){
                $ttl_tagihan = 0;
            }
            else{
                $ttl_tagihan = $data[0]->tagihan;
            }

            if($data[0]->realisasi == NULL){
                $ttl_realisasi = 0;
            }
            else{
                $ttl_realisasi = $data[0]->realisasi;
            }

            if($data[0]->selisih == NULL){
                $ttl_selisih = 0;
            }
            else{
                $ttl_selisih = $data[0]->selisih;
            }
            
            $tagihan[$j] = $ttl_tagihan;
            $realisasi[$j] = $ttl_realisasi;
            $selisih[$j] = $ttl_selisih;
            $j++;
        }

        return array($tagihan,$realisasi,$selisih);
    }

    public static function akumulasi($thn){
        $tagihanAku = array();
        $realisasiAku = array();
        $selisihAku = array();
        $ttl_tagihan = 0;
        $ttl_realisasi = 0;
        $ttl_selisih = 0;
        $j=0;
        for($i=1; $i<=12; $i++){
            if($i < 10){
                $data = DB::table('tagihan')
                ->where('bln_tagihan',($thn."-0".$i))
                ->select(
                    DB::raw('SUM(ttl_tagihan) as tagihan'),
                    DB::raw('SUM(rea_tagihan) as realisasi'),
                    DB::raw('SUM(sel_tagihan) as selisih'))
                ->get();
            }
            else{
                $data = DB::table('tagihan')
                ->where('bln_tagihan',($thn."-".$i))
                ->select(
                    DB::raw('SUM(ttl_tagihan) as tagihan'),
                    DB::raw('SUM(rea_tagihan) as realisasi'),
                    DB::raw('SUM(sel_tagihan) as selisih'))
                ->get();
            }

            if($data[0]->tagihan == NULL){
                $ttl_tagihan = $ttl_tagihan + 0;
            }
            else{
                $ttl_tagihan = $ttl_tagihan + $data[0]->tagihan;
            }

            if($data[0]->realisasi == NULL){
                $ttl_realisasi = $ttl_realisasi + 0;
            }
            else{
                $ttl_realisasi = $ttl_realisasi + $data[0]->realisasi;
            }

            if($data[0]->selisih == NULL){
                $ttl_selisih = $ttl_selisih + 0;
            }
            else{
                $ttl_selisih = $ttl_selisih + $data[0]->selisih;
            }
            
            $tagihanAku[$j] = $ttl_tagihan;
            $realisasiAku[$j] = $ttl_realisasi;
            $selisihAku[$j] = $ttl_selisih;
            $j++;
        }
        
        return array($tagihanAku,$realisasiAku,$selisihAku);
    }
}
