<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CekManajer
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
        if(Session::get('role') == 'manajer'){
            return $next($request);
        }
        else{
            if(Session::get('role') == NULL){
                return redirect()->route('login')->with('info','Silahkan Login Terlebih Dahulu');
            }
            else{
                abort(403);
            }
        }
    }
}
