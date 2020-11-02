<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteranListrik extends Model
{
    protected $table ='meteran_listrik';
    protected $fillable = ['id','kode','nomor','akhir','daya','stt_sedia','stt_bayar','updated_at','created_at'];
}