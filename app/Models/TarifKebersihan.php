<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifKebersihan extends Model
{
    protected $table ='trf_kebersihan';
    protected $fillable = ['id','tarif','updated_at','created_at'];
}
