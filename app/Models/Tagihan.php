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
use App\Models\TempatUsaha;
use App\Models\HariLibur;
use App\Models\MeteranAir;
use App\Models\MeteranListrik;

class Tagihan extends Model
{
    protected $table ='tagihan';
    protected $fillable = [
        'id',
        'id_tempat',
        'id_pemilik',
        'id_pengguna',
        'nama',
        'user',
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
        $bln_tagihan = date("Y-m", time());
        $thn_tagihan = date("Y", time());
        $tgl_tagihan = date("Y-m-01",time());
        $tgl_expired = date("Y-m-15",time());

        if($now < $tgl_expired){
            //Input
            date_default_timezone_set('Asia/Jakarta');
            $now = date("Y-m",time());

            if($fasilitas == 'listrik'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tempat_usaha.trf_listrik','!=',NULL],
                    ['tagihan.stt_listrik',NULL],
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
                    return "Done";
                }
            }
            if($fasilitas == 'airbersih'){
                $dataset = DB::table('tagihan')
                ->leftJoin('tempat_usaha','tagihan.id_tempat','=','tempat_usaha.id')
                ->leftJoin('user','tagihan.id_pengguna','=','user.id')
                ->where([
                    ['tempat_usaha.trf_airbersih','!=',NULL],
                    ['tagihan.stt_airbersih',NULL],
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
                    return "Done";
                }
            }
        }
        else{
            return "Not Periode";
        }
    }

    public static function checking1(){
        //Tagihan antara tanggal 20 - akhir bulan

        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d",time());
        $bln_tagihan = date("Y-m", time());
        $thn_tagihan = date("Y", time());
        $tgl_tagihan = date("Y-m-01",time());
        $tgl_expired = date("Y-m-15",time());

        $tempat = DB::table('tempat_usaha')->get();
        $dataTempat = $tempat->count();
        $dataTagihan = DB::table('tagihan')->where('bln_tagihan')->count();
        if($dataTempat != $dataTagihan){
            foreach($tempat as $t){
                $tagihan = DB::table('tagihan')->where([['id_tempat',$t->id],['tgl_tagihan',$tgl_tagihan]])->first();
                if($tagihan == NULL){
                    //Deklarasi Tagihan
                    $subtotal = 0;
                    $record = TempatUsaha::find($t->id);
                    $tagihan = new Tagihan;

                    //--- Data Tagihan Global ---
                    $tagihan->id_tempat = $t->id;
                    $tagihan->id_pemilik = $t->id_pemilik;
                    $tagihan->id_pengguna = $t->id_pengguna;
                    $tagihan->blok = $t->blok;
                    $tagihan->tgl_tagihan = $tgl_tagihan;
                    $expired = "";
                    do{
                        $libur = HariLibur::where('tanggal', $tgl_expired)->first();
                        if($libur == NULL){
                            $expired = $tgl_expired;
                            $done = TRUE;
                        }
                        else{
                            $stop_date = new DateTime($tgl_expired);
                            $stop_date->modify('+1 day');
                            $expired = $stop_date->format('Y-m-d');
                            $done = FALSE;
                        }
                    }
                    while($done == TRUE);
                    $tagihan->tgl_expired = $expired; //Perlu Cek Hari Libur
                    $tagihan->bln_tagihan = $bln_tagihan;
                    $tagihan->thn_tagihan = $thn_tagihan;
                    $tagihan->stt_lunas = 0;
                    $tagihan->stt_bayar = 0;
                    $tagihan->stt_denda = 0;
                    $tagihan->stt_kebersihan = 1;
                    $tagihan->stt_keamananipk = 1;

                    //inisiasi
                    $jml_alamat = $record->jml_alamat;
                    $diskon = 0;

                    //--- Data Tagihan Khusus ---

                    if($t->trf_airbersih == NULL){
                        $tagihan->stt_airbersih = 1;
                    }
                    
                    if($t->trf_listrik == NULL){
                        $tagihan->stt_listrik = 1;
                    }
                    
                    //Air Bersih
                    if($t->trf_airbersih != NULL){
                        $meter = MeteranAir::find($t->id_meteran_air);
                        $tagihan->awal_airbersih = $meter->akhir;
                    }

                    //Listrik
                    if($t->trf_listrik != NULL){
                        $meter = MeteranListrik::find($t->id_meteran_listrik);
                        $tagihan->daya_listrik = $meter->daya;
                        $tagihan->awal_listrik = $meter->akhir;
                    }

                    //Tarif Keamanan & IPK
                    if($t->trf_keamananipk != NULL){
                        $tarif = TarifKeamananIpk::find($t->trf_keamananipk);
                        $tagihan->ttl_keamananipk = $tarif->tarif * $jml_alamat;
                        $tagihan->sel_keamananipk = $tarif->tarif * $jml_alamat;
                        $subtotal = $subtotal + $tarif->tarif * $jml_alamat;
                    }

                    // Tarif Kebersihan
                    if($t->trf_kebersihan != NULL){
                        $tarif = TarifKebersihan::find($t->trf_kebersihan);
                        $tagihan->ttl_kebersihan = $tarif->tarif * $jml_alamat;
                        $tagihan->sel_kebersihan = $tarif->tarif * $jml_alamat;
                        $subtotal = $subtotal + $tarif->tarif * $jml_alamat;
                    }

                    // Tarif Kebersihan
                    if($t->trf_airkotor != NULL){
                        $tarif = TarifAirKotor::find($t->trf_airkotor);
                        $tagihan->ttl_airkotor = $tarif->tarif;
                        $tagihan->sel_airkotor = $tarif->tarif;
                        $subtotal = $subtotal + $tarif->tarif;
                    }
                    
                    // Tarif Lain Lain
                    if($t->trf_lain != NULL){
                        $tarif = TarifLain::find($t->trf_lain);
                        $tagihan->ttl_lain = $tarif->tarif;
                        $tagihan->sel_lain = $tarif->tarif;
                        $subtotal = $subtotal + $tarif->tarif;
                    }

                    //Sub Total 
                    $subtotal = round($subtotal);
                    $tagihan->ttl_tagihan_seb = $subtotal;
                    //Diskon
                    $diskon = round(($diskon * $subtotal) / 100);
                    $tagihan->diskon_tagihan = $diskon;
                    //TOTAL
                    $tagihan->ttl_tagihan = $subtotal - $diskon;
                    $tagihan->rea_tagihan = 0;
                    $tagihan->den_tagihan = 0;
                    $tagihan->sel_tagihan = $subtotal - $diskon;

                    $tagihan->save();
                }
            }
        }
        Session::put('tagihan','done');
    }

    public static function checking2(){
        //tagihan antara awal bulan - tanggal 15
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

        $tagihan->akhir_listrik = $akhir;
        $tagihan->pakai_listrik = $pakai_listrik;
        $tagihan->byr_listrik = $byr_listrik;
        $tagihan->rekmin_listrik = $rekmin_listrik;
        $tagihan->blok1_listrik = $blok1_listrik;
        $tagihan->blok2_listrik = $blok2_listrik;
        $tagihan->beban_listrik = $beban_listrik;
        $tagihan->bpju_listrik = $bpju_listrik;
        $tagihan->ttl_listrik = $ttl_listrik;
        $tagihan->sel_listrik = $ttl_listrik - $tagihan->rea_listrik;
        
        //Subtotal
        $subtotal = round($tagihan->ttl_tagihan_seb + $ttl_listrik);
        $tagihan->ttl_tagihan_seb = $subtotal;
        
        //Diskon
        $diskon = $tagihan->prs_diskon;
        $diskon = round(($diskon * $subtotal) / 100);
        $tagihan->diskon_tagihan = $diskon;

        //TOTAL
        $tagihan->ttl_tagihan = $subtotal - $diskon;
        $tagihan->sel_tagihan = $subtotal - $diskon - $tagihan->rea_tagihan;

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
        $tagihan->akhir_airbersih = $akhir;
        $tagihan->pakai_airbersih = $pakai_airbersih;
        $tagihan->byr_airbersih = $byr_airbersih;
        $tagihan->pemeliharaan_airbersih = $pemeliharaan_airbersih;
        $tagihan->beban_airbersih = $beban_airbersih;
        $tagihan->arkot_airbersih = $arkot_airbersih;
        $tagihan->ttl_airbersih = round($ttl_airbersih);
        $tagihan->sel_airbersih = round($ttl_airbersih - $tagihan->rea_airbersih);

        //Subtotal
        $subtotal = round($tagihan->ttl_tagihan_seb + $ttl_airbersih);
        $tagihan->ttl_tagihan_seb = $subtotal;
        
        //Diskon
        $diskon = $tagihan->prs_diskon;
        $diskon = round(($diskon * $subtotal) / 100);
        $tagihan->diskon_tagihan = $diskon;

        //TOTAL
        $tagihan->ttl_tagihan = $subtotal - $diskon;
        $tagihan->sel_tagihan = $subtotal - $diskon - $tagihan->rea_tagihan;

        $tagihan->stt_airbersih = 1;
        $tagihan->save();
    }
}
