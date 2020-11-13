<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\Tagihan;

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
        $pass = md5($request->get('password'));
        $user = User::where([['username', $request->username],['password',$pass]])->first();
        try{
            Session::put('userId',$user->id);
            Session::put('username',$user->nama);
            Session::put('role',$user->role);
            Session::put('tarif','listrik');
            Session::put('meteran','listrik');
            Session::put('user','admin');
            Session::put('tagihan','uncheck');

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
                return redirect()->route('masterindex')->with('success','Selamat Datang');
            }
            else if ($user->role == 'admin') {
                return redirect()->route('adminindex')->with('success','Selamat Datang');
            }
            else if ($user->role == 'manajer') {
                return redirect()->route('manajerindex')->with('success','Selamat Datang');
            }
            else if ($user->role == 'keuangan') {
                return redirect()->route('keuanganindex')->with('success','Selamat Datang');
            }
            else if ($user->role == 'kasir') {
                return redirect()->route('kasirindex')->with('success','Selamat Datang');
            }
            else if ($user->role == 'nasabah') {
                return redirect()->route('nasabahindex')->with('success','Selamat Datang');
            }
        }catch(\Exception $e){
            return redirect()->route('login')->with('error','Username atau Password Salah');
        }

        return $next($request);
    }
}
