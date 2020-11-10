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

        if($email != NULL){
            $email = strtolower($email.'@gmail.com');
        }
        else{
            $email = 'fahniamsyari@yahoo.co.id';
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

        $data = [$ktp, $email, $hp];
        $err = Pedagang::addReport($data);

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
                if($email != 'fahniamsyari@yahoo.co.id'){
                    $pedagang->email = $email;
                }
                $pedagang->hp = $hp;
                $pedagang->password = md5(substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10));
                $pedagang->role = 'nasabah';
                $pedagang->save();

                $ped = Pedagang::where('ktp',$ktp)->first();

                if($pemilik == "pemilik"){
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
                
                if($pengguna == "pengguna"){
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
                return redirect()->back()->with('error','Terjadi Kesalahan Sistem');
            } 
        }
    }

    public function update($id){
        return view('pedagang.update',[
            'dataset'=>Pedagang::find($id),
            'pemilik'=>Pedagang::nasabah($id,'pemilik'),
            'pengguna'=>Pedagang::nasabah($id,'pengguna'),
        ]);
    }

    public function store(Request $request, $id){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $email = $request->get('email');

        if($email != NULL){
            $email = strtolower($email.'@gmail.com');
        }
        else{
            $email = 'fahniamsyari@yahoo.co.id';
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

        $data = [$ktp, $email, $hp];
        $err = Pedagang::updReport($data, $id);

        if($err != "OK"){
            return redirect()->back()->with('error','Pedagang '.$nama.', '.$err.' Telah Digunakan');
        }
        else{
            try{
                $pedagang = Pedagang::find($id);
                $pedagang->nama = $nama;
                $pedagang->ktp = $ktp;
                if($email != 'fahniamsyari@yahoo.co.id'){
                    $pedagang->email = $email;
                }
                $pedagang->hp = $hp;
                $pedagang->save();

                $ped = Pedagang::where('ktp',$ktp)->first();

                if($pemilik == "pemilik"){
                    $alamatPemilik = $request->get('alamatPemilik');
                    foreach($alamatPemilik as $alamat){
                        $tempat = TempatUsaha::where('kd_kontrol',$alamat)->first();
                        if($tempat != NULL){
                            $tempat = TempatUsaha::find($tempat->id);
                            $tempat->id_pemilik = $ped->id;
                            $tempat->save();
                        }
                    }
                    
                    $tempat = TempatUsaha::where('id_pemilik',$id)->get();
                    if($tempat != NULL){
                        foreach($tempat as $t){
                            if(in_array($t->kd_kontrol, $alamatPemilik) == FALSE){
                                $hapus = TempatUsaha::find($t->id);
                                $hapus->id_pemilik = NULL;
                                $hapus->save();
                            }
                        }   
                    }
                }
                else{
                    $tempat = TempatUsaha::where('id_pemilik',$id)->get();
                    if($tempat != NULL){
                        foreach($tempat as $t){
                            $hapus = TempatUsaha::find($t->id);
                            $hapus->id_pemilik = NULL;
                            $hapus->save();
                        }   
                    }
                }
                
                if($pengguna == "pengguna"){
                    $alamatPengguna = $request->get('alamatPengguna');
                    foreach($alamatPengguna as $alamat){
                        $tempat = TempatUsaha::where('kd_kontrol',$alamat)->first();
                        if($tempat != NULL){
                            $tempat = TempatUsaha::find($tempat->id);
                            $tempat->id_pengguna = $ped->id;
                            $tempat->save();
                        }
                    }
                    
                    $tempat = TempatUsaha::where('id_pengguna',$id)->get();
                    if($tempat != NULL){
                        foreach($tempat as $t){
                            if(in_array($t->kd_kontrol, $alamatPengguna) == FALSE){
                                $hapus = TempatUsaha::find($t->id);
                                $hapus->id_pengguna = NULL;
                                $hapus->save();
                            }
                        }   
                    }
                }
                else{
                    $tempat = TempatUsaha::where('id_pengguna',$id)->get();
                    if($tempat != NULL){
                        foreach($tempat as $t){
                            $hapus = TempatUsaha::find($t->id);
                            $hapus->id_pengguna = NULL;
                            $hapus->save();
                        }   
                    }
                }

                return redirect()->route('pedagangindex')->with('success','Pedagang '.$nama.' Diupdate');
            }catch(\Exception $e){
                return redirect()->back()->with('error','Terjadi Kesalahan Sistem');
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