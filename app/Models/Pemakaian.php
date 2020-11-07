<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Tagihan;

class Pemakaian extends Model
{
    public static function data(){
        return Tagihan::select('bln_tagihan')
        ->groupBy('bln_tagihan')
        ->orderBy('bln_tagihan','desc')
        ->get();
    }

    public static function bulan($bulan){
        $bln = array (
            1 =>   'JANUARI',
            'FEBRUARI',
            'MARET',
            'APRIL',
            'MEI',
            'JUNI',
            'JULI',
            'AGUSTUS',
            'SEPTEMBER',
            'OKTOBER',
            'NOVEMBER',
            'DESEMBER'
        );
        $pecahkan = explode('-', $bulan);
        return $bln[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public static function rekapListrik($bulan){
        return Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->where([
                    ['tagihan.bln_tagihan',$bulan],
                    ['tempat_usaha.trf_listrik',1]
                ])
            ->select(
                    'tagihan.blok',
                    DB::raw('SUM(tagihan.daya_listrik) as daya'),
                    DB::raw('SUM(tagihan.pakai_listrik) as pakai'),
                    DB::raw('SUM(tagihan.beban_listrik) as beban'),
                    DB::raw('SUM(tagihan.bpju_listrik) as bpju'),
                    DB::raw('SUM(tagihan.ttl_listrik) as tagihan'),
                    DB::raw('SUM(tagihan.rea_listrik) as realisasi'),
                    DB::raw('SUM(tagihan.sel_listrik) as selisih'),
                    DB::raw('COUNT(*) as pengguna')
                )
            ->groupBy('tagihan.blok')
            ->orderBy('tagihan.blok','asc')
            ->get();
    }

    public static function ttlRekapListrik($data){
        $total = array();
        $pengguna = 0;
        $daya = 0;
        $pakai = 0;
        $beban = 0;
        $bpju = 0;
        $tagihan = 0;
        $realisasi = 0;
        $selisih = 0;
        foreach($data as $d){
            $pengguna = $pengguna + $d->pengguna;
            $daya = $daya + $d->daya;
            $pakai = $pakai + $d->pakai;
            $beban = $beban + $d->beban;
            $bpju = $bpju + $d->bpju;
            $tagihan = $tagihan + $d->tagihan;
            $realisasi = $realisasi + $d->realisasi;
            $selisih = $selisih + $d->selisih;
        }
        $total[0] = $pengguna;
        $total[1] = $daya;
        $total[2] = $pakai;
        $total[3] = $beban;
        $total[4] = $bpju;
        $total[5] = $tagihan;
        $total[6] = $realisasi;
        $total[7] = $selisih;
        return $total;
    }

    public static function rincianListrik($bulan){
        $blok = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_listrik',1]
            ])
            ->select('tagihan.blok')
            ->orderBy('tagihan.blok','asc')
            ->groupBy('tagihan.blok')
            ->get();

        $dataset = array();
        for($i=0; $i<count($blok); $i++){
            $dataset[$i][0] = $blok[$i]->blok;
            $dataset[$i][1] = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->leftJoin('user','tagihan.id_pengguna','=','user.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_listrik',1],
                ['tagihan.blok',$blok[$i]->blok]
            ])
            ->select(
                'tempat_usaha.kd_kontrol as kontrol',
                'user.nama as pengguna',
                'tagihan.daya_listrik as daya',
                'tagihan.awal_listrik as lalu',
                'tagihan.akhir_listrik as baru',
                'tagihan.pakai_listrik as pakai',
                'tagihan.rekmin_listrik as rekmin',
                'tagihan.blok1_listrik as blok1',
                'tagihan.blok2_listrik as blok2',
                'tagihan.beban_listrik as beban',
                'tagihan.bpju_listrik as bpju',
                'tagihan.ttl_listrik as tagihan',
                'tagihan.rea_listrik as realisasi',
                'tagihan.sel_listrik as selisih'
                )
            ->get();
            $dataset[$i][2] = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->leftJoin('user','tagihan.id_pengguna','=','user.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_listrik',1],
                ['tagihan.blok',$blok[$i]->blok]
            ])
            ->select(
                DB::raw('SUM(tagihan.daya_listrik) as daya'),
                DB::raw('SUM(tagihan.awal_listrik) as lalu'),
                DB::raw('SUM(tagihan.akhir_listrik) as baru'),
                DB::raw('SUM(tagihan.pakai_listrik) as pakai'),
                DB::raw('SUM(tagihan.rekmin_listrik) as rekmin'),
                DB::raw('SUM(tagihan.blok1_listrik) as blok1'),
                DB::raw('SUM(tagihan.blok2_listrik) as blok2'),
                DB::raw('SUM(tagihan.beban_listrik) as beban'),
                DB::raw('SUM(tagihan.bpju_listrik) as bpju'),
                DB::raw('SUM(tagihan.ttl_listrik) as tagihan'),
                DB::raw('SUM(tagihan.rea_listrik) as realisasi'),
                DB::raw('SUM(tagihan.sel_listrik) as selisih')
                )
            ->get();
        }
        return $dataset;
    }

    public static function rekapAirBersih($bulan){
        return Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->where([
                    ['tagihan.bln_tagihan',$bulan],
                    ['tempat_usaha.trf_airbersih',1]
                ])
            ->select(
                    'tagihan.blok',
                    DB::raw('SUM(tagihan.pakai_airbersih) as pakai'),
                    DB::raw('SUM(tagihan.beban_airbersih) as beban'),
                    DB::raw('SUM(tagihan.pemeliharaan_airbersih) as pemeliharaan'),
                    DB::raw('SUM(tagihan.arkot_airbersih) as arkot'),
                    DB::raw('SUM(tagihan.ttl_airbersih) as tagihan'),
                    DB::raw('SUM(tagihan.rea_airbersih) as realisasi'),
                    DB::raw('SUM(tagihan.sel_airbersih) as selisih'),
                    DB::raw('COUNT(*) as pengguna')
                )
            ->groupBy('tagihan.blok')
            ->orderBy('tagihan.blok','asc')
            ->get();
    }

    public static function ttlRekapAirBersih($data){
        $total = array();
        $pengguna = 0;
        $pakai = 0;
        $beban = 0;
        $pemeliharaan = 0;
        $arkot = 0;
        $tagihan = 0;
        $realisasi = 0;
        $selisih = 0;
        foreach($data as $d){
            $pengguna = $pengguna + $d->pengguna;
            $pakai = $pakai + $d->pakai;
            $beban = $beban + $d->beban;
            $pemeliharaan = $pemeliharaan + $d->pemeliharaan;
            $arkot = $arkot + $d->arkot;
            $tagihan = $tagihan + $d->tagihan;
            $realisasi = $realisasi + $d->realisasi;
            $selisih = $selisih + $d->selisih;
        }
        $total[0] = $pengguna;
        $total[1] = $pakai;
        $total[2] = $beban;
        $total[3] = $pemeliharaan;
        $total[4] = $arkot;
        $total[5] = $tagihan;
        $total[6] = $realisasi;
        $total[7] = $selisih;
        return $total;
    }

    public static function rincianAirBersih($bulan){
        $blok = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_airbersih',1]
            ])
            ->select('tagihan.blok')
            ->orderBy('tagihan.blok','asc')
            ->groupBy('tagihan.blok')
            ->get();

        $dataset = array();
        for($i=0; $i<count($blok); $i++){
            $dataset[$i][0] = $blok[$i]->blok;
            $dataset[$i][1] = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->leftJoin('user','tagihan.id_pengguna','=','user.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_airbersih',1],
                ['tagihan.blok',$blok[$i]->blok]
            ])
            ->select(
                'tempat_usaha.kd_kontrol as kontrol',
                'user.nama as pengguna',
                'tagihan.awal_airbersih as lalu',
                'tagihan.akhir_airbersih as baru',
                'tagihan.pakai_airbersih as pakai',
                'tagihan.byr_airbersih as bPakai',
                'tagihan.beban_airbersih as beban',
                'tagihan.pemeliharaan_airbersih as pemeliharaan',
                'tagihan.arkot_airbersih as arkot',
                'tagihan.ttl_airbersih as tagihan',
                'tagihan.rea_airbersih as realisasi',
                'tagihan.sel_airbersih as selisih'
                )
            ->get();
            $dataset[$i][2] = Tagihan::
            leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->leftJoin('user','tagihan.id_pengguna','=','user.id')
            ->where([
                ['tagihan.bln_tagihan',$bulan],
                ['tempat_usaha.trf_airbersih',1],
                ['tagihan.blok',$blok[$i]->blok]
            ])
            ->select(
                DB::raw('SUM(tagihan.awal_airbersih) as lalu'),
                DB::raw('SUM(tagihan.akhir_airbersih) as baru'),
                DB::raw('SUM(tagihan.pakai_airbersih) as pakai'),
                DB::raw('SUM(tagihan.byr_airbersih) as bPakai'),
                DB::raw('SUM(tagihan.beban_airbersih) as beban'),
                DB::raw('SUM(tagihan.pemeliharaan_airbersih) as pemeliharaan'),
                DB::raw('SUM(tagihan.arkot_airbersih) as arkot'),
                DB::raw('SUM(tagihan.ttl_airbersih) as tagihan'),
                DB::raw('SUM(tagihan.rea_airbersih) as realisasi'),
                DB::raw('SUM(tagihan.sel_airbersih) as selisih')
                )
            ->get();
        }
        return $dataset;
    }
}
