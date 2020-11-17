<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Exception;

class CekMaster
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
        $user = User::where([['nama', Session::get('username')],['role','master']])->first();
        try{
            if(Session::get('role') == 'master' && $user != NULL){
                return $next($request);
            }
            else{
                if(Session::get('role') == NULL){
                    Session::flush();
                    return redirect()->route('login')->with('info','Silahkan Login Terlebih Dahulu');
                }
                else{
                    Session::flush();
                    return redirect()->route('login')->with('info','Silahkan Login Terlebih Dahulu');
                }
            }
        }
        catch(\Exception $e){
            Session::flush();
            return redirect()->route('login')->with('info','Silahkan Login Terlebih Dahulu');
        }
    }
}
