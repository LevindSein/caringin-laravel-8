<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasangAlat extends Model
{
    protected $table ='pasang_alat';
    protected $fillable = ['id','id_tempat','id_pemilik','id_pengguna','stt_pasang','ttl_pasang','rea_pasang','sel_pasang','updated_at','created_at'];
}
