<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        return User::where('role','admin')->get();
    }
    
    public static function keuangan(){
        return User::where('role','keuangan')->get();
    }

    public static function manajer(){
        return User::where('role','manajer')->get();
    }

    public static function kasir(){
        return User::where('role','kasir')->get();
    }
}
