<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManajerController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\NasabahController;

use App\Http\Controllers\PedagangController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Session;
use App\Models\Pedagang;
use App\Models\TempatUsaha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home
Route::get('/', function(){
    return view('login.login');
})->name('home');
Route::get('login',function(){
    return view('login.login');
})->name('login');

//LOGIN
Route::post('storelogin')->middleware('ceklogin');

//LOGOUT
Route::get('logout',function(){
    Session::flush();
    Artisan::call('cache:clear');
    return redirect()->route('login')->with('success','Sampai Bertemu');
});

Route::get('master/dashboard',[MasterController::class, 'index'])->name('masterindex')->middleware('cekmaster');
Route::get('admin/dashboard',[AdminController::class, 'index'])->name('adminindex')->middleware('cekadmin');
Route::get('manajer/dashboard',[ManajerController::class, 'index'])->name('manajerindex')->middleware('cekmanajer');
Route::get('keuangan/index',[KeuanganController::class, 'index'])->name('keuanganindex')->middleware('cekkeuangan');
Route::get('kasir/index',[KasirController::class, 'index'])->name('kasirindex')->middleware('cekkasir');
Route::get('nasabah/index',[NasabahController::class, 'index'])->name('nasabahindex')->middleware('ceknasabah');

Route::get('pedagang/data',function(){;
    return view('pedagang.index',['dataset'=>Pedagang::data()]);
})->name('pedagangindex');
Route::post('pedagang/add',[PedagangController::class, 'add']);
Route::get('pedagang/update/{id}',[PedagangController::class, 'update']);
Route::post('pedagang/store/{id}',[PedagangController::class, 'store']);
Route::get('pedagang/delete/{id}',[PedagangController::class, 'delete']);
Route::get('pedagang/details/{id}',[PedagangController::class, 'details']);

Route::get('tempatusaha/data',[TempatController::class, 'index'])->name('tempatindex');
Route::post('tempatusaha/add',[TempatController::class, 'add']);
Route::get('tempatusaha/update/{id}',[TempatController::class, 'update']);
Route::post('tempatusaha/store/{id}',[TempatController::class, 'store']);
Route::get('tempatusaha/delete/{id}',[TempatController::class, 'delete']);
Route::get('tempatusaha/details/{id}',[TempatController::class, 'details']);

Route::get('cari/blok',[SearchController::class, 'cariBlok']);
Route::get('cari/nasabah',[SearchController::class, 'cariNasabah']);

Route::middleware(['masteradmin'])->group(function () {
    
});
