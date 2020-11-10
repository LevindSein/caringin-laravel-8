<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedagang extends Model
{
    protected $table ='user';
    protected $fillable = [
        'id', 
        'username', 
        'nama', 
        'anggota', 
        'ktp', 
        'email', 
        'hp', 
        'password', 
        'remember_token', 
        'role', 
        'updated_at', 
        'created_at'
    ];

    public static function data(){
        return DB::table('user')->where('role','nasabah')->get();
    }

    public static function addReport($data){
        $ktp = DB::table('user')->where('ktp',$data[0])->first();
        $email = DB::table('user')->where('email',$data[1])->first();
        $hp = DB::table('user')->where('hp',$data[2])->first();

        if($ktp != NULL){
            return "KTP";
        }

        if($email != NULL){
            return "Email";
        }

        if($hp != NULL){
            return "Nomor HP";
        }
        return "OK";
    }

    public static function updReport($data, $id){
        $ktp = DB::table('user')->where([['ktp',$data[0]],['id','!=',$id]])->first();
        $email = DB::table('user')->where([['email',$data[1]],['id','!=',$id]])->first();
        $hp = DB::table('user')->where([['hp',$data[2]],['id','!=',$id]])->first();

        if($ktp != NULL){
            return "KTP";
        }

        if($email != NULL){
            return "Email";
        }

        if($hp != NULL){
            return "Nomor HP";
        }
        return "OK";
    }
    
    public static function details($id){
        $details = array();
        $tempat = DB::table('tempat_usaha')->where('id_pengguna',$id)->get();
        for($i=0; $i<count($tempat); $i++){
            $tagihan = DB::table('tagihan')
            ->where([
                ['id_tempat',$tempat[$i]->id],
                ['stt_lunas',0]])
            ->select(DB::raw('SUM(sel_tagihan) as selisih'))
            ->get();
            $details[$i][0] = $tempat[$i]->kd_kontrol;
            $details[$i][1] = $tagihan[0]->selisih;
            $details[$i][2] = $tempat[$i]->id;
        }
        return $details;
    }

    public static function nasabah($id, $status){
        if($status == 'pemilik')
            $data = DB::table('tempat_usaha')->where('id_pemilik',$id)->select('kd_kontrol')->get();

        if($status == 'pengguna')
            $data = DB::table('tempat_usaha')->where('id_pengguna',$id)->select('kd_kontrol')->get();

        $nasabah = array();
        $i = 0;
        foreach($data as $d){
            $nasabah[$i] = $d->kd_kontrol; 
            $i++;
        }
        return $nasabah;
    }
}
