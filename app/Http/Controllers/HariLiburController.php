<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HariLibur;

class HariLiburController extends Controller
{
    public function add(Request $request){
        $tanggal = new HariLibur;
        $tanggal->tanggal = $request->get('tanggal');
        $tanggal->ket = ucwords($request->get('ket'));
        $tanggal->save();
        
        return redirect()->route('hariliburindex')->with('success','Tanggal Ditambah');
    }

    public function update($id){
        return view('harilibur.update',[
            'dataset'=>HariLibur::find($id)
        ]);
    }

    public function store(Request $request, $id){
        $tanggal = HariLibur::find($id);
        $tanggal->tanggal = $request->get('tanggal');
        $tanggal->ket = ucwords($request->get('ket'));
        $tanggal->save();

        return redirect()->route('hariliburindex')->with('success','Tanggal Diupdate');
    }

    public function delete($id){
        $tanggal = HariLibur::find($id);
        $nama = $tanggal->tanggal;
        $ket = $tanggal->ket;
        $tanggal->delete();
        
        return redirect()->route('hariliburindex')->with('success','Tanggal '.$nama.' - '.$ket.' Dihapus');
    }
}
