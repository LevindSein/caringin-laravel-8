<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
        'trf_diskon',
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
        'stt_cicil',
        'stt_tempat',
        'ket_tempat',
        'lok_tempat',
        'otoritas_user',
        'kd_linkaja',
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
        ->leftJoin('trf_diskon','tempat_usaha.trf_diskon','=','trf_diskon.id')
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
            'tempat_usaha.trf_diskon',
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
            'trf_diskon.tarif as diskon',
            'tempat_usaha.stt_cicil',
            'tempat_usaha.stt_tempat',
            'tempat_usaha.ket_tempat',
            )
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
}