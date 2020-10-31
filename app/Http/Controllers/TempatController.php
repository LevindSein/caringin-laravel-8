<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\TempatUsaha;

class TempatController extends Controller
{
    public function add(Request $request){

    }

    public function update($id){

    }

    public function store(Request $request,$id){

    }

    public function delete($id){
        try{
            $tempat = TempatUsaha::find($id);
            $nama = $tempat->kd_kontrol;
            $tempat->delete();
            return redirect()->route('tempatindex')->with('success','Tempat '.$nama.' Dihapus');
        }catch(\Exception $e){
            return redirect()->route('tempatindex')->with('errorUpd','Tempat '.$nama.' Tidak Dapat Dihapus - Memiliki Sejumlah Tagihan');
        }
    }

    public function details($id){
        $nama = TempatUsaha::find($id);
        $nama = $nama->kd_kontrol;
        $dataset = TempatUsaha::details($id);
        if($dataset == NULL){
            return redirect()->back()->with('infoUpd','Tempat '.$nama.' Tidak Memiliki Detail Tagihan');
        }
        else{
            return view('tempat.details',['dataset'=>$dataset,'nama'=>$nama]);
        }
    }
}
