<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Exception;
use DateTime;

use App\Models\Tagihan;
use App\Models\TarifAirBersih;
use App\Models\TarifListrik;
use App\Models\TarifKeamananIpk;
use App\Models\TarifKebersihan;
use App\Models\TarifLain;
use App\Models\TarifAirKotor;
use App\Models\TempatUsaha;
use App\Models\HariLibur;
use App\Models\MeteranAir;
use App\Models\MeteranListrik;
use App\Models\User;

class Tagihan extends Model
{
    protected $table ='tagihan';
    protected $fillable = [
        'id',
        'id_tempat',
        'id_pemilik',
        'id_pengguna',
        'nama',
        'blok',
        'kd_kontrol',
        'bln_pakai',
        'tgl_tagihan',
        'bln_tagihan',
        'thn_tagihan',
        'tgl_expired',
        'tgl_bayar',
        'bln_bayar',
        'thn_bayar',
        'stt_lunas',
        'stt_bayar',
        'awal_airbersih',
        'akhir_airbersih',
        'pakai_airbersih',
        'byr_airbersih',
        'pemeliharaan_airbersih',
        'beban_airbersih',
        'arkot_airbersih',
        'sub_airbersih',
        'dis_airbersih',
        'ttl_airbersih',
        'rea_airbersih',
        'sel_airbersih',
        'den_airbersih',
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
        'sub_listrik',
        'dis_listrik',
        'ttl_listrik',
        'rea_listrik',
        'sel_listrik',
        'den_listrik',
        'sub_keamananipk',
        'dis_keamananipk',
        'ttl_keamananipk',
        'rea_keamananipk',
        'sel_keamananipk',
        'sub_kebersihan',
        'dis_kebersihan',
        'ttl_kebersihan',
        'rea_kebersihan',
        'sel_kebersihan',
        'ttl_airkotor',
        'rea_airkotor',
        'sel_airkotor',
        'ttl_lain',
        'rea_lain',
        'sel_lain',
        'sub_tagihan',
        'dis_tagihan',
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
        'stt_airkotor',
        'stt_lain',
        'ket',
        'via_bayar',
        'via_tambah',
        'stt_publish',
        'updated_at',
        'created_at'
    ];

    public static function reaAirBersih($thn){
        $realisasi = DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->where('tempat_usaha.trf_airbersih',1)
        ->select(DB::raw('SUM(tagihan.rea_airbersih) as realisasi'))
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
        ->select(DB::raw('SUM(tagihan.sel_airbersih) as selisih'))
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
                ->where('bln_pakai',($thn."-0".$i))
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

    public static function fasilitas($id,$fas){
        try{
            $data = DB::table('tagihan')
            ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
            ->where([
                ['tagihan.id_tempat',$id],
                ['tagihan.stt_lunas',0],
                ['tempat_usaha.trf_'.$fas,'!=',NULL]
            ])
            ->select(DB::raw("SUM(sel_$fas) as selisih"))
            ->get();
            return $data[0]->selisih;
        }
        catch(\Exception $e){
            return 0;
        }
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

    public static function dataTahun(){
        return DB::table('tagihan')
        ->select('thn_tagihan')
        ->groupBy('thn_tagihan')
        ->get();
    }

    public static function data($bln){
        return DB::table('tagihan')
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->leftJoin('user as pengguna','tagihan.id_pengguna','=','pengguna.id')
        ->where('bln_tagihan',$bln)
        ->select(
            'tagihan.id',
            'tempat_usaha.kd_kontrol',
            'pengguna.nama as pengguna',
            'awal_airbersih',
            'akhir_airbersih',
            'sel_airbersih',
            'daya_listrik',
            'awal_listrik',
            'akhir_listrik',
            'sel_listrik',
            'sel_keamananipk',
            'sel_kebersihan',
            'sel_tagihan',
            'sel_airkotor',
            'sel_lain',
            )
        ->get();
    }

    public static function tagihan($fasilitas){
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d",time());
        $check = date("Y-m-15",time());

        if($now < $check){
            //Input
            date_default_timezone_set('Asia/Jakarta');
            $now = date("Y-m",time());

            if($fasilitas == 'listrik'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tagihan.stt_listrik',0],
                    ['tagihan.bln_tagihan',$now],
                ])
                ->orderBy('tempat_usaha.kd_kontrol','asc')
                ->select(
                    'tagihan.id as tagihanId',
                    'tempat_usaha.id as tempatId',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'user.nama as pengguna',
                    'user.id as penggunaId',
                    'user.ktp as ktp',
                    'tagihan.awal_listrik as awal',
                    'tagihan.daya_listrik as daya'
                    )
                ->first();
                if($dataset != NULL){
                    return $dataset;
                }
                else{
                    return "Listrik";
                }
            }
            if($fasilitas == 'airbersih'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tagihan.stt_airbersih',0],
                    ['tagihan.bln_tagihan',$now],
                ])
                ->orderBy('tempat_usaha.kd_kontrol','asc')
                ->select(
                    'tagihan.id as tagihanId',
                    'tempat_usaha.id as tempatId',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'user.nama as pengguna',
                    'user.id as penggunaId',
                    'user.ktp as ktp',
                    'tagihan.awal_airbersih as awal'
                    )
                ->first();
                if($dataset != NULL){
                    return $dataset;
                }
                else{
                    return "Air Bersih";
                }
            }
        }
        else if($now >= $check){
            //Input
            date_default_timezone_set('Asia/Jakarta');
            $now = date("Y-m",time());

            if($fasilitas == 'listrik'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tagihan.stt_listrik',0],
                    ['tagihan.bln_pakai',$now],
                ])
                ->orderBy('tempat_usaha.kd_kontrol','asc')
                ->select(
                    'tagihan.id as tagihanId',
                    'tempat_usaha.id as tempatId',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'user.nama as pengguna',
                    'user.id as penggunaId',
                    'user.ktp as ktp',
                    'tagihan.awal_listrik as awal',
                    'tagihan.daya_listrik as daya'
                    )
                ->first();
                if($dataset != NULL){
                    return $dataset;
                }
                else{
                    return "Listrik";
                }
            }
            if($fasilitas == 'airbersih'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tagihan.stt_airbersih',0],
                    ['tagihan.bln_pakai',$now],
                ])
                ->orderBy('tempat_usaha.kd_kontrol','asc')
                ->select(
                    'tagihan.id as tagihanId',
                    'tempat_usaha.id as tempatId',
                    'tempat_usaha.kd_kontrol as kontrol',
                    'user.nama as pengguna',
                    'user.id as penggunaId',
                    'user.ktp as ktp',
                    'tagihan.awal_airbersih as awal'
                    )
                ->first();
                if($dataset != NULL){
                    return $dataset;
                }
                else{
                    return "Air Bersih";
                }
            }
        }
    }

    public static function checking1(){
        //Tagihan Bulan ini, Pemakaian sebelum tanggal 15 bulan ini dan setelah tanggal 15 bulan lalu
        date_default_timezone_set('Asia/Jakarta');
        $bln_tagihan = date("Y-m",time());
        $time = strtotime($bln_tagihan);
        $bln_pakai = date("Y-m", strtotime("-1 month", $time));
        $tgl_tagihan = date("Y-m-01",time());
        $tgl_expired = date("Y-m-15",time());
        $thn_tagihan = date("Y", time());

        $tempat = TempatUsaha::select('id')->orderBy('kd_kontrol','asc')->get();
        foreach($tempat as $t){
            $tagihan = Tagihan::where([['id_tempat',$t->id],['bln_tagihan',$bln_tagihan]])->select('id')->first();
            if($tagihan == NULL){
                $tagihan = new Tagihan;
                $record = TempatUsaha::find($t->id);
                $subtotal = 0;

                //--- Data Tagihan Global ---
                $tagihan->id_tempat = $record->id;
                $tagihan->kd_kontrol = $record->kd_kontrol;
                $tagihan->id_pemilik = $record->id_pemilik;
                $tagihan->id_pengguna = $record->id_pengguna;
                $pengguna = User::find($record->id_pengguna);
                $tagihan->nama = $pengguna->nama;
                $tagihan->blok = $record->blok;
                $tagihan->bln_pakai = $bln_pakai;
                $tagihan->tgl_tagihan = $tgl_tagihan;
                $tagihan->bln_tagihan = $bln_tagihan;
                $tagihan->thn_tagihan = $thn_tagihan;
                $expired = $tgl_expired;
                do{
                    $libur = HariLibur::where('tanggal', $expired)->first();
                    if ($libur != NULL){
                        $stop_date = strtotime($expired);
                        $expired = date("Y-m-d", strtotime("+1 day", $stop_date));
                        $done = TRUE;
                    }
                    else{
                        $done = FALSE;
                    }
                }
                while($done == TRUE);
                $tagihan->tgl_expired = $expired;
                $tagihan->stt_lunas = 0;
                $tagihan->stt_bayar = 0;
                $tagihan->stt_denda = 0;

                if($record->trf_keamananipk != NULL){
                    $tarif = TarifKeamananIpk::find($record->trf_keamananipk);
                    $tagihan->stt_keamananipk = 1;
                    $jumlah = $record->jml_alamat * $tarif->tarif;
                    $tagihan->sub_keamananipk = $jumlah;
                    $tagihan->ttl_keamananipk = $jumlah - $tagihan->dis_keamananipk;
                    $tagihan->sel_keamananipk = $tagihan->ttl_keamananipk - $tagihan->rea_keamananipk;
                    $subtotal = $subtotal + $tagihan->sub_keamananipk;
                }

                if($record->trf_kebersihan != NULL){
                    $tarif = TarifKebersihan::find($record->trf_kebersihan);
                    $tagihan->stt_kebersihan = 1;
                    $jumlah = $record->jml_alamat * $tarif->tarif;
                    $tagihan->sub_kebersihan = $jumlah;
                    $tagihan->ttl_kebersihan = $jumlah - $tagihan->dis_kebersihan;
                    $tagihan->sel_kebersihan = $tagihan->ttl_kebersihan - $tagihan->rea_kebersihan;
                    $subtotal = $subtotal + $tagihan->sub_kebersihan;
                }

                if($record->trf_airkotor != NULL){
                    $tarif = TarifAirKotor::find($record->trf_airkotor);
                    $tagihan->stt_airkotor = 1;
                    $tagihan->ttl_airkotor = $tarif->tarif;
                    $tagihan->sel_airkotor = $tarif->tarif;
                    $subtotal = $subtotal + $tagihan->ttl_airkotor;
                }
                
                if($record->trf_lain != NULL){
                    $tarif = TarifLain::find($record->trf_lain);
                    $tagihan->stt_lain = 1;
                    $tagihan->ttl_lain = $tarif->tarif;
                    $tagihan->sel_lain = $tarif->tarif;
                    $subtotal = $subtotal + $tagihan->ttl_lain;
                }
                
                if($record->trf_listrik != NULL){
                    $tarif = MeteranListrik::find($record->id_meteran_listrik);
                    $tagihan->awal_listrik = $tarif->akhir;
                    $tagihan->daya_listrik = $tarif->daya;
                    $tagihan->stt_listrik = 0;
                }
                  
                if($record->trf_airbersih != NULL){
                    $tarif = MeteranAir::find($record->id_meteran_air);
                    $tagihan->awal_airbersih = $tarif->akhir;
                    $tagihan->stt_airbersih = 0;
                }

                $tagihan->sub_tagihan = $subtotal;
                $tagihan->ttl_tagihan = $tagihan->sub_tagihan - $tagihan->dis_tagihan;
                $tagihan->sel_tagihan = $tagihan->ttl_tagihan - $tagihan->rea_tagihan;

                $tagihan->save();
            }
        }
        Session::put('tagihan','done');
    }

    public static function checking2(){
        //tagihan setelah tanggal 15 bulan ini//Tagihan Bulan ini, Pemakaian sebelum tanggal 15 bulan ini dan setelah tanggal 15 bulan lalu
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-01",time());
        $expired = date("Y-m-15",time());
        $bln_pakai = date("Y-m",time());
        $time = strtotime($bln_pakai);
        $bln_tagihan = date("Y-m", strtotime("+1 month", $time));
        $time = strtotime($now);
        $tgl_tagihan = date("Y-m-01", strtotime("+1 month", $time));
        $time = strtotime($expired);
        $tgl_expired = date("Y-m-15", strtotime("+1 month", $time));
        $thn_tagihan = date("Y",  strtotime("+1 month", $time));

        $tempat = TempatUsaha::select('id')->orderBy('kd_kontrol','asc')->get();
        foreach($tempat as $t){
            $tagihan = Tagihan::where([['id_tempat',$t->id],['bln_pakai',$bln_pakai]])->select('id')->first();
            if($tagihan == NULL){
                $tagihan = new Tagihan;
                $record = TempatUsaha::find($t->id);
                $subtotal = 0;

                //--- Data Tagihan Global ---
                $tagihan->id_tempat = $record->id;
                $tagihan->kd_kontrol = $record->kd_kontrol;
                $tagihan->id_pemilik = $record->id_pemilik;
                $tagihan->id_pengguna = $record->id_pengguna;
                $pengguna = User::find($record->id_pengguna);
                $tagihan->nama = $pengguna->nama;
                $tagihan->blok = $record->blok;
                $tagihan->bln_pakai = $bln_pakai;
                $tagihan->tgl_tagihan = $tgl_tagihan;
                $tagihan->bln_tagihan = $bln_tagihan;
                $tagihan->thn_tagihan = $thn_tagihan;
                $expired = $tgl_expired;
                do{
                    $libur = HariLibur::where('tanggal', $expired)->first();
                    if ($libur != NULL){
                        $stop_date = strtotime($expired);
                        $expired = date("Y-m-d", strtotime("+1 day", $stop_date));
                        $done = TRUE;
                    }
                    else{
                        $done = FALSE;
                    }
                }
                while($done == TRUE);
                $tagihan->tgl_expired = $expired;
                $tagihan->stt_lunas = 0;
                $tagihan->stt_bayar = 0;
                $tagihan->stt_denda = 0;

                if($record->trf_keamananipk != NULL){
                    $tarif = TarifKeamananIpk::find($record->trf_keamananipk);
                    $tagihan->stt_keamananipk = 1;
                    $jumlah = $record->jml_alamat * $tarif->tarif;
                    $tagihan->sub_keamananipk = $jumlah;
                    $tagihan->ttl_keamananipk = $jumlah - $tagihan->dis_keamananipk;
                    $tagihan->sel_keamananipk = $tagihan->ttl_keamananipk - $tagihan->rea_keamananipk;
                    $subtotal = $subtotal + $tagihan->sub_keamananipk;
                }

                if($record->trf_kebersihan != NULL){
                    $tarif = TarifKebersihan::find($record->trf_kebersihan);
                    $tagihan->stt_kebersihan = 1;
                    $jumlah = $record->jml_alamat * $tarif->tarif;
                    $tagihan->sub_kebersihan = $jumlah;
                    $tagihan->ttl_kebersihan = $jumlah - $tagihan->dis_kebersihan;
                    $tagihan->sel_kebersihan = $tagihan->ttl_kebersihan - $tagihan->rea_kebersihan;
                    $subtotal = $subtotal + $tagihan->sub_kebersihan;
                }

                if($record->trf_airkotor != NULL){
                    $tarif = TarifAirKotor::find($record->trf_airkotor);
                    $tagihan->stt_airkotor = 1;
                    $tagihan->ttl_airkotor = $tarif->tarif;
                    $tagihan->sel_airkotor = $tarif->tarif;
                    $subtotal = $subtotal + $tagihan->ttl_airkotor;
                }
                
                if($record->trf_lain != NULL){
                    $tarif = TarifLain::find($record->trf_lain);
                    $tagihan->stt_lain = 1;
                    $tagihan->ttl_lain = $tarif->tarif;
                    $tagihan->sel_lain = $tarif->tarif;
                    $subtotal = $subtotal + $tagihan->ttl_lain;
                }
                
                if($record->trf_listrik != NULL){
                    $tarif = MeteranListrik::find($record->id_meteran_listrik);
                    $tagihan->awal_listrik = $tarif->akhir;
                    $tagihan->daya_listrik = $tarif->daya;
                    $tagihan->stt_listrik = 0;
                }
                  
                if($record->trf_airbersih != NULL){
                    $tarif = MeteranAir::find($record->id_meteran_air);
                    $tagihan->awal_airbersih = $tarif->akhir;
                    $tagihan->stt_airbersih = 0;
                }

                $tagihan->sub_tagihan = $subtotal;
                $tagihan->ttl_tagihan = $tagihan->sub_tagihan - $tagihan->dis_tagihan;
                $tagihan->sel_tagihan = $tagihan->ttl_tagihan - $tagihan->rea_tagihan;

                $tagihan->save();
            }
        }
        Session::put('tagihan','done');
    }

    public static function listrik($awal, $akhir, $daya, $tagihanId){
        $tarif = TarifListrik::find(1);
        $tagihan = Tagihan::find($tagihanId);

        $batas_rekmin = round(18 * $daya /1000);
        $pakai_listrik = $akhir - $awal;

        $a = round(($daya * $tarif->trf_standar) / 1000);
        $blok1_listrik = $tarif->trf_blok1 * $a;

        $b = $pakai_listrik - $a;
        $blok2_listrik = $tarif->trf_blok2 * $b;
        $beban_listrik = $daya * $tarif->trf_beban;

        $c = $blok1_listrik + $blok2_listrik + $beban_listrik;
        $rekmin_listrik = 53.44 * $daya;

        if($pakai_listrik <= $batas_rekmin){
            $bpju_listrik = ($tarif->trf_bpju / 100) * $rekmin_listrik;
            $blok1_listrik = 0;
            $blok2_listrik = 0;
            $beban_listrik = 0;
            $byr_listrik = $bpju_listrik + $rekmin_listrik;
            $ppn = ($tarif->trf_ppn / 100) * $byr_listrik;
            $ttl_listrik = $byr_listrik + $ppn;
        }
        else{
            $bpju_listrik = ($tarif->trf_bpju / 100) * $c;
            $rekmin_listrik = 0;
            $byr_listrik = $bpju_listrik + $blok1_listrik + $blok2_listrik + $beban_listrik;
            $ppn = ($tarif->trf_ppn / 100) * $byr_listrik;
            $ttl_listrik = $byr_listrik + $ppn;
        }

        //opsi
        $tagihan->daya_listrik = $daya;
        $tagihan->awal_listrik = $awal;
        //opsi

        $tagihan->akhir_listrik = $akhir;
        $tagihan->pakai_listrik = $pakai_listrik;
        $tagihan->byr_listrik = $byr_listrik;
        $tagihan->rekmin_listrik = $rekmin_listrik;
        $tagihan->blok1_listrik = $blok1_listrik;
        $tagihan->blok2_listrik = $blok2_listrik;
        $tagihan->beban_listrik = $beban_listrik;
        $tagihan->bpju_listrik = $bpju_listrik;
        $tagihan->sub_listrik = round($ttl_listrik);
        $tempat = TempatUsaha::find($tagihan->id_tempat);
        if($tempat->dis_listrik != NULL){
            $diskon = round($ttl_listrik);
        }
        else{
            $diskon = $tagihan->dis_listrik;
        }
        $tagihan->ttl_listrik = $tagihan->sub_listrik - $tagihan->dis_listrik;
        $tagihan->sel_listrik = $tagihan->ttl_listrik - $tagihan->rea_listrik;
        
        //Subtotal
        $subtotal = $tagihan->sub_tagihan + $tagihan->sub_listrik;
        $tagihan->sub_tagihan = $subtotal;
        
        //Diskon
        $tagihan->dis_tagihan = $diskon;

        //TOTAL
        $tagihan->ttl_tagihan = $subtotal - $diskon;
        $tagihan->sel_tagihan = $tagihan->ttl_tagihan - $tagihan->rea_tagihan;

        $tagihan->stt_listrik = 1;
        $tagihan->save();
    }

    public static function airBersih($awal, $akhir, $tagihanId){
        $tarif = TarifAirBersih::find(1);
        $tagihan = Tagihan::find($tagihanId);

        $pakai_airbersih = $akhir - $awal;
        if($pakai_airbersih > 10){
            $a = 10 * $tarif->trf_1;
            $b = ($pakai_airbersih - 10) * $tarif->trf_2;
            $byr_airbersih = $a + $b;
    
            $pemeliharaan_airbersih = $tarif->trf_pemeliharaan;
            $beban_airbersih = $tarif->trf_beban;
            $arkot_airbersih = ($tarif->trf_arkot / 100) * $byr_airbersih;
    
            $ppn = ($byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih) * ($tarif->trf_ppn / 100);

            $ttl_airbersih = $byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih + $ppn;
        }
        else{      
            $byr_airbersih = $pakai_airbersih * $tarif->trf_1;
    
            $pemeliharaan_airbersih = $tarif->trf_pemeliharaan;
            $beban_airbersih = $tarif->trf_beban;
            $arkot_airbersih = ($tarif->trf_arkot / 100) * $byr_airbersih;
    
            $ppn = ($byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih) * ($tarif->trf_ppn / 100);

            $ttl_airbersih = $byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih + $ppn;
        }

        //Update Tagihan

        //opsi
        $tagihan->awal_airbersih = $awal;
        //opsi

        $tagihan->akhir_airbersih = $akhir;
        $tagihan->pakai_airbersih = $pakai_airbersih;
        $tagihan->byr_airbersih = $byr_airbersih;
        $tagihan->pemeliharaan_airbersih = $pemeliharaan_airbersih;
        $tagihan->beban_airbersih = $beban_airbersih;
        $tagihan->arkot_airbersih = $arkot_airbersih;
        $tagihan->sub_airbersih = round($ttl_airbersih);
        $tempat = TempatUsaha::find($tagihan->id_tempat);
        if($tempat->dis_airbersih != NULL){
            $diskon = round($ttl_airbersih);
        }
        else{
            $diskon = $tagihan->dis_airbersih;
        }
        $tagihan->ttl_airbersih = $tagihan->sub_airbersih - $tagihan->dis_airbersih;
        $tagihan->sel_airbersih = $tagihan->ttl_airbersih - $tagihan->rea_airbersih;
        
        //Subtotal
        $subtotal = $tagihan->sub_tagihan + $tagihan->sub_airbersih;
        $tagihan->sub_tagihan = $subtotal;
        
        //Diskon
        $tagihan->dis_tagihan = $diskon;

        //TOTAL
        $tagihan->ttl_tagihan = $subtotal - $diskon;
        $tagihan->sel_tagihan = $tagihan->ttl_tagihan - $tagihan->rea_tagihan;

        $tagihan->stt_airbersih = 1;
        $tagihan->save();
    }

    public static function listrikBadge(){
        return Tagihan::where([['tagihan.stt_listrik',0],['tempat_usaha.trf_listrik',1]])
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->count();
    }
    
    public static function airBersihBadge(){
        return Tagihan::where([['tagihan.stt_airbersih',0],['tempat_usaha.trf_airbersih',1]])
        ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
        ->count();
    }

    public static function updateTagihan($id){
        return Tagihan::where('tagihan.id',$id)
        ->leftJoin('user as pengguna','tagihan.id_pengguna','=','pengguna.id')
        ->select(
            'tagihan.kd_kontrol',
            'pengguna.id as penggunaId',
            'pengguna.nama as pengguna',
            'pengguna.ktp as ktp',
            'tagihan.awal_airbersih',
            'tagihan.akhir_airbersih',
            'tagihan.awal_listrik',
            'tagihan.akhir_listrik',
            'tagihan.daya_listrik',
            'tagihan.stt_airbersih',
            'tagihan.stt_listrik',
            'tagihan.stt_keamananipk',
            'tagihan.stt_kebersihan',
            'tagihan.stt_airkotor',
            'tagihan.stt_lain',
        )
        ->first();
    }

    public static function hitungListrik(){
        // $dataset = Tagihan::where('bln_pakai','2020-09')->get();
        // foreach($dataset as $data){
        //     $data->stt_listrik = NULL;
        //     $data->save();
        // }
        $dataset = Tagihan::where([['bln_pakai','2020-09'],['awal_listrik','!=',NULL]])->get();
        foreach($dataset as $tagihan){
            $tarif = TarifListrik::find(1);
            $awal = $tagihan->awal_listrik;
            $akhir = $tagihan->akhir_listrik;
            $daya = $tagihan->daya_listrik;

            $pakai_listrik = $akhir - $awal;
            $batas_rekmin = round(18 * $daya /1000);

            $a = round(($daya * $tarif->trf_standar) / 1000);
            $blok1_listrik = $tarif->trf_blok1 * $a;

            $b = $pakai_listrik - $a;
            $blok2_listrik = $tarif->trf_blok2 * $b;
            $beban_listrik = $daya * $tarif->trf_beban;

            $c = $blok1_listrik + $blok2_listrik + $beban_listrik;
            $rekmin_listrik = 53.44 * $daya;

            if($pakai_listrik <= $batas_rekmin){
                $bpju_listrik = ($tarif->trf_bpju / 100) * $rekmin_listrik;
                $blok1_listrik = 0;
                $blok2_listrik = 0;
                $beban_listrik = 0;
                $byr_listrik = $bpju_listrik + $rekmin_listrik;
                $ppn = ($tarif->trf_ppn / 100) * $byr_listrik;
                $ttl_listrik = $byr_listrik + $ppn;
            }
            else{
                $bpju_listrik = ($tarif->trf_bpju / 100) * $c;
                $rekmin_listrik = 0;
                $byr_listrik = $bpju_listrik + $blok1_listrik + $blok2_listrik + $beban_listrik;
                $ppn = ($tarif->trf_ppn / 100) * $byr_listrik;
                $ttl_listrik = $byr_listrik + $ppn;
            }

            $tagihan->pakai_listrik = $pakai_listrik;
            $tagihan->byr_listrik = $byr_listrik;
            $tagihan->rekmin_listrik = $rekmin_listrik;
            $tagihan->blok1_listrik = $blok1_listrik;
            $tagihan->blok2_listrik = $blok2_listrik;
            $tagihan->beban_listrik = $beban_listrik;
            $tagihan->bpju_listrik = $bpju_listrik;
            $tagihan->sub_listrik = round($ttl_listrik);
            $tempat = TempatUsaha::find($tagihan->id_tempat);
            $meter = MeteranListrik::find($tempat->id_meteran_listrik);
            $meter->akhir = $tagihan->akhir_listrik;
            $meter->daya = $daya;
            $meter->save();

            $tagihan->ttl_listrik = $tagihan->sub_listrik - $tagihan->dis_listrik;
            $tagihan->sel_listrik = $tagihan->ttl_listrik - $tagihan->rea_listrik;
            $tagihan->stt_listrik = 1;
            $tagihan->save();
        }
    }

    public static function hitungAir(){
        $dataset = Tagihan::where([['bln_pakai','2020-10'],['awal_airbersih','!=',NULL]])->get();
        foreach($dataset as $tagihan){
            $tarif = TarifAirBersih::find(1);
            $awal = $tagihan->awal_airbersih;
            $akhir = $tagihan->akhir_airbersih;

            $pakai_airbersih = $akhir - $awal;
            if($pakai_airbersih > 10){
                $a = 10 * $tarif->trf_1;
                $b = ($pakai_airbersih - 10) * $tarif->trf_2;
                $byr_airbersih = $a + $b;
        
                $pemeliharaan_airbersih = $tarif->trf_pemeliharaan;
                $beban_airbersih = $tarif->trf_beban;
                $arkot_airbersih = ($tarif->trf_arkot / 100) * $byr_airbersih;
        
                $ppn = ($byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih) * ($tarif->trf_ppn / 100);

                $ttl_airbersih = $byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih + $ppn;
            }
            else{      
                $byr_airbersih = $pakai_airbersih * $tarif->trf_1;
        
                $pemeliharaan_airbersih = $tarif->trf_pemeliharaan;
                $beban_airbersih = $tarif->trf_beban;
                $arkot_airbersih = ($tarif->trf_arkot / 100) * $byr_airbersih;
        
                $ppn = ($byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih) * ($tarif->trf_ppn / 100);

                $ttl_airbersih = $byr_airbersih + $pemeliharaan_airbersih + $beban_airbersih + $arkot_airbersih + $ppn;
            }

            //Update Tagihan
            $tagihan->pakai_airbersih = $pakai_airbersih;
            $tagihan->byr_airbersih = $byr_airbersih;
            $tagihan->pemeliharaan_airbersih = $pemeliharaan_airbersih;
            $tagihan->beban_airbersih = $beban_airbersih;
            $tagihan->arkot_airbersih = $arkot_airbersih;
            $tagihan->sub_airbersih = round($ttl_airbersih);
            $tempat = TempatUsaha::find($tagihan->id_tempat);
            $meter = MeteranAir::find($tempat->id_meteran_air);
            $meter->akhir = $tagihan->akhir_airbersih;
            $meter->save();

            $tagihan->ttl_airbersih = $tagihan->sub_airbersih - $tagihan->dis_airbersih;
            $tagihan->sel_airbersih = $tagihan->ttl_airbersih - $tagihan->rea_airbersih;
            $tagihan->stt_airbersih = 1;
            $tagihan->save();
        }
    }

    public static function cekMeter(){
        $air = MeteranAir::get();
        $listrik = MeteranListrik::get();

        foreach($air as $d){
            $tempat = TempatUsaha::where('id_meteran_air',$d->id)->first();
            if($tempat == NULL){
                $d->stt_sedia = 0;
                $d->stt_bayar = 0;
                $d->save();
            }
        }
        foreach($listrik as $d){
            $tempat = TempatUsaha::where('id_meteran_listrik',$d->id)->first();
            if($tempat == NULL){
                $d->stt_sedia = 0;
                $d->stt_bayar = 0;
                $d->save();
            }
        }
    }

    public static function keamananIpk(){
        $dataset = Tagihan::where('ttl_keamananipk','!=',0)->get();

        foreach($dataset as $d){
            $d->sub_keamananipk = $d->ttl_keamananipk;
            $d->stt_keamananipk = 1;
            $d->save();
        }
    }

    public static function kebersihan(){
        $dataset = Tagihan::where('ttl_kebersihan','!=',0)->get();

        foreach($dataset as $d){
            $d->sub_kebersihan = $d->ttl_kebersihan;
            $d->stt_kebersihan = 1;
            $d->save();
        }
    }
}