<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifDiskon extends Model
{
    protected $table ='trf_diskon';
    protected $fillable = ['id','tarif','updated_at','created_at'];
}
