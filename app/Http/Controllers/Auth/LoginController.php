<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Tagihan;
use DateTime;
use DateInterval;
use Exception;
use Artisan;

class LoginController extends Controller
{

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function index(){
        return view('login.login');
    }

    public function logout(){
        Session::flush();
        Artisan::call('cache:clear');
        return redirect()->route('login')->with('success','Sampai Bertemu');
    }

    public function store(Request $request){
        
    }
}
