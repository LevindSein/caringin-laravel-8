<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Models\User;
use App\Models\LoginLog;

class CekLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date("Y-m-d",time());
        $checkAwal = date("Y-m-20",time());
        $time1 = strtotime($now);
        $checkAkhir1 = date("Y-m-01", strtotime("+1 month", $time1));
        $time2 = strtotime($now);
        $checkAkhir2 = date("Y-m-15", strtotime("+1 month", $time2));

        $pass = md5($request->get('password'));
        $user = User::where([['username', $request->username],['password',$pass]])->first();
        try{
            Session::put('userId',$user->id);
            Session::put('username',$user->nama);
            Session::put('role',$user->role);
            Session::put('tarif','listrik');
            Session::put('meteran','listrik');
            Session::put('user','admin');

            if($now >= $checkAwal && $now < $checkAkhir1){
                Session::put('tagihan','checking1');
            }
            else if($now >= $checkAkhir1 && $now < $checkAkhir2){
                Session::put('tagihan','checking2');
            }
            else{
                Session::put('tagihan','done');
            }

            if(LoginLog::count() > 7000){
                LoginLog::orderBy('id','asc')->limit(1000)->delete();
            }

            $loginLog = new LoginLog;
            $loginLog->username = $user->username;
            $loginLog->nama = $user->nama;
            $loginLog->ktp = $user->ktp;
            $loginLog->hp = $user->hp;
            $loginLog->role = $user->role;
            $loginLog->save();

            if ($user->role == 'master') {
                return redirect()->route('masterindex')->with('success','Login Berhasil');
            }
            else if ($user->role == 'admin') {
                return redirect()->route('adminindex')->with('success','Login Berhasil');
            }
            else if ($user->role == 'manajer') {
                return redirect()->route('manajerindex')->with('success','Login Berhasil');
            }
            else if ($user->role == 'keuangan') {
                return redirect()->route('keuanganindex')->with('success','Login Berhasil');
            }
            else if ($user->role == 'kasir') {
                return redirect()->route('kasirindex')->with('success','Login Berhasil');
            }
            else if ($user->role == 'nasabah') {
                return redirect()->route('nasabahindex')->with('success','Login Berhasil');
            }
        }catch(\Exception $e){
            return redirect()->route('login')->with('error','Login Gagal');
        }

        return $next($request);
    }
}
