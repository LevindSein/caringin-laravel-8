<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteranAir extends Model
{
    protected $table ='meteran_air';
    protected $fillable = ['id','kode','nomor','akhir','status','updated_at','created_at'];
}