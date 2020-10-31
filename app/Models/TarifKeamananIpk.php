<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifKeamananIpk extends Model
{
    protected $table ='trf_keamanan_ipk';
    protected $fillable = ['id','tarif','updated_at','created_at'];
}
