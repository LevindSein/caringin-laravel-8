<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'otoritas',
        'stt_aktif',
        'updated_at', 
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otoritas',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function admin(){
        return User::where('role','admin')->orderBy('updated_at','desc')->get();
    }
    
    public static function keuangan(){
        return User::where('role','keuangan')->orderBy('updated_at','desc')->get();
    }

    public static function manajer(){
        return User::where('role','manajer')->orderBy('updated_at','desc')->get();
    }

    public static function kasir(){
        return User::where('role','kasir')->orderBy('updated_at','desc')->get();
    }

    public static function nasabah(){
        return User::where('role','nasabah')->orderBy('updated_at','desc')->get();
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
}
