<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{
    public function add(Request $request){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $role = $request->get('role');
        $email = $request->get('email');

        Session::put('user',$role);

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

        $data = [$ktp, $email, $hp];
        $err = User::addReport($data);

        if($err != "OK"){
            return redirect()->back()->with('error','User '.$nama.', '.$err.' Telah Digunakan');
        }
        else{
            try{
                $user = new User;
                $username = substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4).str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
                $user->username = $username;
                $user->nama = $nama;
                $user->ktp = $ktp;
                if($email != 'fahniamsyari@yahoo.co.id'){
                    $user->email = $email;
                }
                $user->hp = $hp;
                $pass = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10);
                $user->password = md5($pass);
                $user->role = $role;
                $user->save();

                return redirect()->route('userindex')->with('successUpd','User '.$nama.' Ditambah, Username >> '.$username.' <<  ,Password >> '.$pass.' <<');
            }catch(\Exception $e){
                return redirect()->back()->with('error','Terjadi Kesalahan Sistem');
            } 
        }
    }

    public function update($id){
        return view('user.update',[
            'dataset'=>User::find($id)
        ]);
    }

    public function store(Request $request, $id){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $role = $request->get('role');
        $email = $request->get('email');

        Session::put('user',$role);

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

        $data = [$ktp, $email, $hp];
        $err = User::updReport($data, $id);

        if($err != "OK"){
            return redirect()->back()->with('error','User '.$nama.', '.$err.' Telah Digunakan');
        }
        else{
            try{
                $user = User::find($id);
                $user->nama = $nama;
                $user->ktp = $ktp;
                if($email != 'fahniamsyari@yahoo.co.id'){
                    $user->email = $email;
                }
                $user->hp = $hp;
                $user->role = $role;
                $user->save();


                return redirect()->route('userindex')->with('success','User '.$nama.' Diupdate');
            }catch(\Exception $e){
                return redirect()->back()->with('error','Terjadi Kesalahan Sistem');
            } 
        }
    }

    public function delete($id){
        try{
            $user = User::find($id);
            $nama = $user->nama;
            
            Session::put('user',$user->role);

            $user->delete();
            return redirect()->route('userindex')->with('success','User '.$nama.' Dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('errorUpd','User '.$nama.' Tidak Dapat Dihapus - User Memiliki Catatan Sistem');
        }
    }

    public function reset($id){
        $user = User::find($id);
        $nama = $user->nama;
        $username = $user->username;
        $pass = substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10);
        $user->password = md5($pass);
        
        Session::put('user',$user->role);
        
        $user->save();

        return redirect()->route('userindex')->with('successUpd','User '.$nama.' Direset, Username >> '.$username.' <<  ,Password >> '.$pass.' <<');
    }

    public function otoritas($id){
        $dataset = User::find($id);

        $pilihanKelola = array('pedagang','tempatusaha','tagihan','blok','pemakaian','pendapatan','datausaha','alatmeter','tarif','harilibur');
        
        if($dataset->otoritas != NULL){
            $otoritas = json_decode($dataset->otoritas);
        }
        else{
            $kelola[] = ['blok' => null];
            for($i=0; $i<count($pilihanKelola); $i++){
                $kelola[] = [$pilihanKelola[$i] => false];
            }
            $otoritas = json_encode($kelola);
            $otoritas = json_decode($otoritas);
        }

        Session::put('user',$dataset->role);
        if($dataset->role != 'admin'){
            return redirect()->route('userindex')->with('info','Bukan Admin');
        }
        return view('user.otoritas',['dataset'=>$dataset,'otoritas'=>$otoritas]);
    }

    public function otoritasStore(Request $request,$id){
        $kelola[] = ['blok' => $request->get('blokOtoritas')];

        $pilihanKelola = array('pedagang','tempatusaha','tagihan','blok','pemakaian','pendapatan','datausaha','alatmeter','tarif','harilibur');

        for($i=0; $i<count($pilihanKelola); $i++){
            if(in_array($pilihanKelola[$i],$request->get('kelola'))){
                $kelola[] = [$pilihanKelola[$i] => true];
            }
            else{
                $kelola[] = [$pilihanKelola[$i] => false];
            }
        }

        $json = json_encode($kelola);

        $dataset = User::find($id);
        $dataset->otoritas = $json;
        $dataset->save();
        Session::put('user',$dataset->role);
        return redirect()->route('userindex')->with('success','Otoritas Ditambah');
    }
}
