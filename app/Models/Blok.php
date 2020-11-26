<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blok extends Model
{
    protected $table = 'blok';
    protected $fillable = ['id','nama','otoritas','prs_keamanan','prs_ipk','updated_at','created_at'];
}
