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

    public static function addReport($ktp,$email,$hp){
        $ktp = DB::table('user')->where('ktp',$ktp)->first();
        if($email != NULL){
            $email = DB::table('user')->where('email',$email)->first();
        }
        $hp = DB::table('user')->where('hp',$hp)->first();

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

    public static function updReport($ktp, $email, $hp, $id){
        $ktp = DB::table('user')->where([['ktp',$ktp],['id','!=',$id]])->first();
        $email = DB::table('user')->where([['email',$email],['id','!=',$id]])->first();
        $hp = DB::table('user')->where([['hp',$hp],['id','!=',$id]])->first();

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
        }
        return $details;
    }
}
