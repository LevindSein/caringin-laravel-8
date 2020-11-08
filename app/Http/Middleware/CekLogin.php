<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Exception;
use App\Models\User;

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
            Session::put('username',$user->username);
            Session::put('role',$user->role);
            Session::put('tarif','listrik');
            Session::put('meteran','listrik');
            Session::put('user','admin');
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
