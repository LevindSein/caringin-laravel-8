<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteranListrik extends Model
{
    protected $table ='meteran_listrik';
    protected $fillable = ['id','kode','nomor','akhir','daya','status','updated_at','created_at'];
}