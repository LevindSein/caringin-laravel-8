<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CekAdmin
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
        if(Session::get('role') == 'admin'){
            return $next($request);
        }
        else{
            if(Session::get('role') == NULL){
                return redirect()->route('login')->with('warning','Silahkan Login Terlebih Dahulu');
            }
            else{
                abort(403);
            }
        }
    }
}
