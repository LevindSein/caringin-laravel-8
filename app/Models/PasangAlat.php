<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasangAlat extends Model
{
    protected $table ='pasang_alat';
    protected $fillable = [
        'id',
        'id_tempat',
        'kd_kontrol',
        'id_pemilik',
        'id_pengguna',
        'id_meteran_air',
        'id_meteran_listrik',
        'stt_pasang',
        'ttl_pasang',
        'rea_pasang',
        'sel_pasang',
        'updated_at',
        'created_at'];
}
