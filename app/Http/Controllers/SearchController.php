<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blok;
use App\Models\User;

class SearchController extends Controller
{
    public function cariBlok(Request $request){
        $blok = [];
        if ($request->has('q')) {
            $cariBlok = $request->q;
            $blok = Blok::select('id', 'nama')->where('nama', 'LIKE', '%'.$cariBlok.'%')->get();
        }
        return response()->json($blok);
    }

    public function cariNasabah(Request $request){
        $nasabah = [];
        if ($request->has('q')) {
            $cariNasabah = $request->q;
            $nasabah = User::select('id', 'nama', 'ktp')
            ->where('nama', 'LIKE', '%'.$cariNasabah.'%')
            ->orWhere('ktp', 'LIKE', '%'.$cariNasabah.'%')
            ->get();
        }
        return response()->json($nasabah);
    }
}
