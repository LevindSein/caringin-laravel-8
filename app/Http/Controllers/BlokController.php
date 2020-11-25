<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Blok;
use App\Models\TempatUsaha;
use App\Models\Tagihan;
use App\Models\Penghapusan;

class BlokController extends Controller
{
    public function add(Request $request){
        $blok = new Blok;
        $blok->nama = strtoupper($request->get('blokInput'));
        // $keamanan = $request->get('keamanan');
        // $ipk = $request->get('ipk');
        // if($keamanan != NULL){
        //     $blok->prs_keamanan = $keamanan;
        // }
        // if($ipk != NULL){
        //     $blok->prs_ipk = $keamanan;
        // }
        $blok->save();
        return redirect()->route('blokindex')->with('success','Blok Berhasil Ditambah');
    }

    public function update($id){
        return view('blok.update',[
            'dataset'=>Blok::find($id)
        ]);
    }

    public function store(Request $request, $id){
        $blok = Blok::find($id);
        $blokLama = $blok->nama;
        $nama = strtoupper($request->get('blokInput'));
        $blok->nama = $nama;
        // $keamanan = $request->get('keamanan');
        // $ipk = $request->get('ipk');
        // if($keamanan != NULL){
        //     $blok->prs_keamanan = $keamanan;
        // }
        // if($ipk != NULL){
        //     $blok->prs_ipk = $ipk;
        // }

        $blok->save();

        $tempat = TempatUsaha::where('blok',$blokLama)->get();
        $tagihan = Tagihan::where('blok',$blokLama)->get();
        // $penghapusan = Penghapusan::where('blok',$nama)->get();
        
        if($tempat != NULL){
            foreach($tempat as $t){
                $t->blok = $nama;
                $t->save();
            }
        }

        if($tagihan != NULL){
            foreach($tagihan as $t){
                $t->blok = $nama;
                $t->save();
            }
        }

        return redirect()->route('blokindex')->with('success','Blok Berhasil Diupdate');
    }

    public function delete($id){
        $blok = Blok::find($id);
        $nama = $blok->nama;
        $pengguna = Tempatusaha::where('blok',$nama)->count();
        if($pengguna != 0 || $pengguna != NULL){
            return redirect()->back()->with('info','Tidak dapat dihapus. Blok digunakan');
        }
        else{
            $blok->delete();
            return redirect()->route('blokindex')->with('success','Blok '.$nama.' Dihapus');
        }
    }
}
