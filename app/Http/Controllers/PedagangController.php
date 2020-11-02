<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Pedagang;
use App\Models\TempatUsaha;

class PedagangController extends Controller
{
    public function add(Request $request){        
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $anggota = $request->get('anggota');
        $email = $request->get('email');
        if($email == ""){
            $email = NULL;
        }
        else{
            $email = strtolower($email.'@gmail.com');
        }

        $hp = $request->get('hp');
        if($hp[0] == '0'){
            $hp = '62'.substr($hp,1);
        }
        else{
            $hp = '62'.$hp;
        }
        $pemilik = $request->get('pemilik');
        $pengguna = $request->get('pengguna');

        $err = Pedagang::addReport($ktp,$email,$hp);

        if($err != "OK"){
            return redirect()->back()->with('error','Pedagang '.$nama.', '.$err.' Telah Digunakan');
        }
        else{
            try{
                $pedagang = new Pedagang;
                $pedagang->username = substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4).str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
                $pedagang->nama = $nama;
                $pedagang->anggota = $anggota;
                $pedagang->ktp = $ktp;
                if($email != NULL){
                    $pedagang->email = $email;
                }
                $pedagang->hp = $hp;
                $pedagang->password = md5(substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10));
                $pedagang->role = 'nasabah';
                $pedagang->save();

                $ped = Pedagang::where('nama',$nama)->first();
                if($pemilik = "pemilik"){
                    $alamatPemilik = $request->get('alamatPemilik');
                    foreach($alamatPemilik as $alamat){
                        $tempat = DB::table('tempat_usaha')->where('id',$alamat)->first();
                        if($tempat != NULL){
                            $tempat = TempatUsaha::find($tempat->id);
                            $tempat->id_pemilik = $ped->id;
                            $tempat->save();
                        }
                    }
                }
                
                if($pengguna = "pengguna"){
                    $alamatPengguna = $request->get('alamatPengguna');
                    foreach($alamatPengguna as $alamat){
                        $tempat = DB::table('tempat_usaha')->where('id',$alamat)->first();
                        if($tempat != NULL){
                            $tempat = TempatUsaha::find($tempat->id);
                            $tempat->id_pengguna = $ped->id;
                            $tempat->save();
                        }
                    }
                }

                return redirect()->route('pedagangindex')->with('success','Pedagang '.$nama.' Ditambah');
            }catch(\Exception $e){
                return redirect()->back()->with('error','Pedagang '.$nama.', '.$err.' Telah Digunakan');
            } 
        }
    }

    public function update($id){
        return view('pedagang.update',['dataset'=>Pedagang::find($id)]);
    }

    public function store(Request $request, $id){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $email = strtolower($request->get('email').'@gmail.com');
        $hp = $request->get('hp');
        if($hp[0] == '0'){
            $hp = '62'.substr($hp,1);
        }
        else{
            $hp = '62'.$hp;
        }

        $err = Pedagang::updReport($ktp,$email,$hp,$id);

        if($err != "OK"){
            return redirect()->back()->with('error','Pedagang '.$nama.', '.$err.' Telah Digunakan');
        }
        else{
            try{
                $pedagang = Pedagang::find($id);
                $pedagang->nama = $nama;
                $pedagang->ktp = $ktp;
                $pedagang->email = $email;
                $pedagang->hp = $hp;
                $user->save();

                return redirect()->route('pedagangindex')->with('success','Pedagang '.$nama.' Ditambah');
            }catch(\Exception $e){
                return redirect()->back()->with('error','Pedagang '.$nama.', '.$err.' Telah Digunakan');
            } 
        }
    }

    public function delete($id){
        try{
            $pedagang = Pedagang::find($id);
            $nama = $pedagang->nama;
            $pedagang->delete();
            return redirect()->route('pedagangindex')->with('success','Pedagang '.$nama.' Dihapus');
        }catch(\Exception $e){
            return redirect()->route('pedagangindex')->with('errorUpd','Pedagang '.$nama.' Tidak Dapat Dihapus - Pedagang menempati Los');
        }
    }

    public function details($id){
        $nama = Pedagang::find($id);
        $nama = $nama->nama;
        $dataset = Pedagang::details($id);
        if($dataset == NULL){
            return redirect()->back()->with('infoUpd','Pedagang '.$nama.' Tidak Memiliki Detail');
        }
        else{
            return view('pedagang.details',['dataset'=>$dataset,'nama'=>$nama]);
        }
    }
}