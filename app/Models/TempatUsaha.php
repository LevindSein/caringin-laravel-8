<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\TempatUsaha;
use Exception;

class TempatUsaha extends Model
{
    protected $table ='tempat_usaha';
    protected $fillable = [
        'id',
        'trf_kebersihan',
        'trf_keamananipk',
        'trf_listrik',
        'trf_airbersih',
        'trf_airkotor',
        'trf_lain',
        'id_pengguna',
        'id_pemilik',
        'kd_kontrol',
        'no_alamat',
        'jml_alamat',
        'bentuk_usaha',
        'id_meteran_air',
        'id_meteran_listrik',
        'blok',
        'daya',
        'dis_airbersih',
        'dis_listrik',
        'dis_keamananipk',
        'dis_kebersihan',
        'stt_cicil',
        'stt_tempat',
        'ket_tempat',
        'lok_tempat',
        'otoritas_user',
        'updated_at',
        'created_at'
    ];

    public static function pengguna(){
        return DB::table('tempat_usaha')->count();
    }

    public static function penggunaAktif(){
        return DB::table('tempat_usaha')->where('stt_tempat',1)->count();
    }

    public static function penggunaNonAktif(){
        return DB::table('tempat_usaha')->where('stt_tempat',0)->count();
    }

    public static function penggunaAirBersih(){
        return DB::table('tempat_usaha')->where('trf_airbersih',1)->count();
    }

    public static function penggunaListrik(){
        return DB::table('tempat_usaha')->where('trf_listrik',1)->count();
    }

    public static function penggunaKeamananIpk(){
        return DB::table('tempat_usaha')->whereNotNull('trf_keamananipk')->count();
    }

    public static function penggunaKebersihan(){
        return DB::table('tempat_usaha')->whereNotNull('trf_kebersihan')->count();
    }

    public static function data(){
        return DB::table('tempat_usaha')
        ->leftJoin('user as user_pengguna','tempat_usaha.id_pengguna','=','user_pengguna.id')
        ->leftJoin('user as user_pemilik','tempat_usaha.id_pemilik','=','user_pemilik.id')
        ->leftJoin('meteran_air','tempat_usaha.id_meteran_air','=','meteran_air.id')
        ->leftJoin('meteran_listrik','tempat_usaha.id_meteran_listrik','=','meteran_listrik.id')
        ->leftJoin('trf_kebersihan','tempat_usaha.trf_kebersihan','=','trf_kebersihan.id')
        ->leftJoin('trf_keamanan_ipk','tempat_usaha.trf_keamananipk','=','trf_keamanan_ipk.id')
        ->leftJoin('trf_air_kotor','tempat_usaha.trf_airkotor','=','trf_air_kotor.id')
        ->leftJoin('trf_lain','tempat_usaha.trf_lain','=','trf_lain.id')
        ->select(
            'tempat_usaha.id',
            'user_pengguna.nama as pengguna',
            'user_pemilik.nama as pemilik',
            'tempat_usaha.trf_kebersihan',
            'tempat_usaha.trf_keamananipk',
            'tempat_usaha.trf_airbersih',
            'tempat_usaha.trf_listrik',
            'tempat_usaha.trf_airkotor',
            'tempat_usaha.trf_lain',
            'tempat_usaha.kd_kontrol',
            'tempat_usaha.lok_tempat',
            'tempat_usaha.no_alamat',
            'tempat_usaha.jml_alamat',
            'tempat_usaha.bentuk_usaha',
            'meteran_air.nomor as air',
            'meteran_listrik.nomor as listrik',
            'trf_kebersihan.tarif as kebersihan',
            'trf_keamanan_ipk.tarif as keamananipk',
            'trf_air_kotor.tarif as airkotor',
            'trf_lain.tarif as lain',
            'tempat_usaha.stt_cicil',
            'tempat_usaha.dis_airbersih',
            'tempat_usaha.dis_listrik',
            'tempat_usaha.dis_keamananipk',
            'tempat_usaha.dis_kebersihan',
            'tempat_usaha.stt_tempat',
            'tempat_usaha.ket_tempat',
            )
        ->orderBy('tempat_usaha.kd_kontrol','asc')
        ->get();
    }
  
    public static function details($id){
        return DB::table('tagihan')
        ->where([['id_tempat',$id],['stt_lunas',0]])
        ->select('bln_tagihan','sel_tagihan')
        ->get();
    }

    public static function airAvailable(){
        return DB::table('meteran_air')->where([['stt_sedia',0],['stt_bayar',0]])->get();
    }
    
    public static function listrikAvailable(){
        return DB::table('meteran_listrik')->where([['stt_sedia',0],['stt_bayar',0]])->get();
    }

    public static function trfKeamananIpk(){
        return DB::table('trf_keamanan_ipk')->get();
    }
    
    public static function trfKebersihan(){
        return DB::table('trf_kebersihan')->get();
    }
    
    public static function trfAirKotor(){
        return DB::table('trf_air_kotor')->get();
    }
    
    public static function trfLain(){
        return DB::table('trf_lain')->get();
    }
    
    public static function trfDiskon(){
        return DB::table('trf_diskon')->get();
    }

    public static function kode($blok,$los){
        $kode = "";
        if(is_numeric($los[0]) == TRUE){
            if($los[0] < 10){
                $kode = $blok."-"."00".$los[0];
            }
            else if($los[0] < 100){
                $kode = $blok."-"."0".$los[0];
            }
            else{
                $kode = $blok."-".$los[0];
            }
        }
        else{
            $num = 0;
            $strnum = 0;
            for($i=0; $i < strlen($los[0]); $i++){
                if (is_numeric($los[0][$i]) == TRUE){
                    $num++;
                }
                else{
                    $strnum = 1;
                    break;
                }
            }

            if($num == 1){
                $kode = $blok."-"."00".$los[0];
            }
            else if($num == 2){
                $kode = $blok."-"."0".$los[0];
            }
            else if($num >= 3 || $strnum == 1){
                $kode = $blok."-".$los[0];
            }
        }
        return $kode;
    }

    public static function fasilitas($fas){
        if($fas == 'diskon'){
            return DB::table('tempat_usaha')
            ->leftJoin('user as user_pengguna','tempat_usaha.id_pengguna','=','user_pengguna.id')
            ->leftJoin('user as user_pemilik','tempat_usaha.id_pemilik','=','user_pemilik.id')
            ->where('tempat_usaha.dis_airbersih','!=',NULL)
            ->orWhere('tempat_usaha.dis_listrik','!=',NULL)
            ->orWhere('tempat_usaha.dis_keamananipk','!=',NULL)
            ->orWhere('tempat_usaha.dis_kebersihan','!=',NULL)
            ->select(
                'tempat_usaha.id',
                'user_pengguna.nama as pengguna',
                'user_pemilik.nama as pemilik',
                'tempat_usaha.kd_kontrol',
                'tempat_usaha.lok_tempat',
                'tempat_usaha.no_alamat',
                'tempat_usaha.jml_alamat',
                'tempat_usaha.bentuk_usaha',
                'tempat_usaha.dis_listrik',
                'tempat_usaha.dis_airbersih',
                'tempat_usaha.dis_keamananipk',
                'tempat_usaha.dis_kebersihan',
                'tempat_usaha.stt_cicil',
                'tempat_usaha.stt_tempat',
                'tempat_usaha.ket_tempat',
                )
            ->get();
        }
        else{
            return DB::table('tempat_usaha')
            ->leftJoin('user as user_pengguna','tempat_usaha.id_pengguna','=','user_pengguna.id')
            ->leftJoin('user as user_pemilik','tempat_usaha.id_pemilik','=','user_pemilik.id')
            ->where('tempat_usaha.trf_'.$fas,'!=',NULL)
            ->select(
                'tempat_usaha.id',
                'user_pengguna.nama as pengguna',
                'user_pemilik.nama as pemilik',
                'tempat_usaha.kd_kontrol',
                'tempat_usaha.lok_tempat',
                'tempat_usaha.no_alamat',
                'tempat_usaha.jml_alamat',
                'tempat_usaha.bentuk_usaha',
                'tempat_usaha.stt_cicil',
                'tempat_usaha.stt_tempat',
                'tempat_usaha.ket_tempat',
                )
            ->get();
        }
    }

    public static function rekap(){
        return DB::table('tempat_usaha')
            ->select(
                'blok',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN trf_airbersih != 'NULL' THEN 1 ELSE 0 END) as airbersih"),
                DB::raw("SUM(CASE WHEN trf_listrik != 'NULL' THEN 1 ELSE 0 END) as listrik"),
                DB::raw("SUM(CASE WHEN trf_keamananipk != 'NULL' THEN 1 ELSE 0 END) as keamananipk"),
                DB::raw("SUM(CASE WHEN trf_kebersihan != 'NULL' THEN 1 ELSE 0 END) as kebersihan"),
                DB::raw("SUM(CASE WHEN stt_tempat = '1' THEN 1 ELSE 0 END) as aktif"),
                )
            ->groupBy('blok')
            ->get();
    }

    public static function detailRekap($blok){
        return DB::table('tempat_usaha')
        ->leftJoin('user as user_pengguna','tempat_usaha.id_pengguna','=','user_pengguna.id')
        ->leftJoin('user as user_pemilik','tempat_usaha.id_pemilik','=','user_pemilik.id')
        ->where('blok',$blok)
        ->select('kd_kontrol','stt_tempat','blok','user_pengguna.nama as pengguna','user_pemilik.nama as pemilik')
        ->get();
    }

    public static function updateData($id){
        return TempatUsaha::where('tempat_usaha.id',$id)
        ->leftJoin('user as pemilik','tempat_usaha.id_pemilik','=','pemilik.id')
        ->leftJoin('user as pengguna','tempat_usaha.id_pengguna','=','pengguna.id')
        ->leftJoin('meteran_air','tempat_usaha.id_meteran_air','=','meteran_air.id')
        ->leftJoin('meteran_listrik','tempat_usaha.id_meteran_listrik','=','meteran_listrik.id')
        ->leftJoin('trf_kebersihan','tempat_usaha.trf_kebersihan','=','trf_kebersihan.id')
        ->leftJoin('trf_keamanan_ipk','tempat_usaha.trf_keamananipk','=','trf_keamanan_ipk.id')
        ->leftJoin('trf_air_kotor','tempat_usaha.trf_airkotor','=','trf_air_kotor.id')
        ->leftJoin('trf_lain','tempat_usaha.trf_lain','=','trf_lain.id')
        ->select(
            'tempat_usaha.id',
            'tempat_usaha.trf_kebersihan',
            'tempat_usaha.trf_keamananipk',
            'tempat_usaha.trf_listrik',
            'tempat_usaha.trf_airbersih',
            'tempat_usaha.trf_airkotor',
            'tempat_usaha.trf_lain',
            'pemilik.id as pemilikId',
            'pemilik.nama as pemilik',
            'pemilik.ktp as pemilikKtp',
            'pengguna.id as penggunaId',
            'pengguna.nama as pengguna',
            'pengguna.ktp as penggunaKtp',
            'tempat_usaha.no_alamat',
            'tempat_usaha.bentuk_usaha',
            'tempat_usaha.blok',
            'meteran_air.id as airId',
            'meteran_air.kode as airKode',
            'meteran_air.nomor as airNomor',
            'meteran_air.akhir as airAkhir',
            'meteran_listrik.id as listrikId',
            'meteran_listrik.kode as listrikKode',
            'meteran_listrik.nomor as listrikNomor',
            'meteran_listrik.akhir as listrikAkhir',
            'trf_keamanan_ipk.id as keamananIpkId',
            'trf_keamanan_ipk.tarif as keamananIpk',
            'trf_kebersihan.id as kebersihanId',
            'trf_kebersihan.tarif as kebersihan',
            'trf_air_kotor.id as arkotId',
            'trf_air_kotor.tarif as arkot',
            'trf_lain.id as lainId',
            'trf_lain.tarif as lain',
            'tempat_usaha.dis_airbersih',
            'tempat_usaha.dis_listrik',
            'tempat_usaha.dis_keamananipk',
            'tempat_usaha.dis_kebersihan',
            'tempat_usaha.stt_cicil',
            'tempat_usaha.stt_tempat',
            'tempat_usaha.ket_tempat',
            'tempat_usaha.lok_tempat',)
        ->first();
    }
}