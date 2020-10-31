<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifLain extends Model
{
    protected $table ='trf_lain';
    protected $fillable = ['id','tarif','updated_at','created_at'];
}
