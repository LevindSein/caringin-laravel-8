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
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\MeteranController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\DataController;

use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Session;
use App\Models\Pedagang;
use App\Models\TempatUsaha;
use App\Models\HariLibur;
use App\Models\TarifAirBersih;
use App\Models\TarifListrik;
use App\Models\TarifKeamananIpk;
use App\Models\TarifKebersihan;
use App\Models\TarifAirKotor;
use App\Models\TarifLain;
use App\Models\Blok;

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

Route::get('cari/blok',[SearchController::class, 'cariBlok']);
Route::get('cari/nasabah',[SearchController::class, 'cariNasabah']);
Route::get('cari/alamat',[SearchController::class, 'cariAlamat']);

Route::get('pedagang/data',function(){
    return view('pedagang.index',['dataset'=>Pedagang::data()]);
})->name('pedagangindex');
Route::post('pedagang/add',[PedagangController::class, 'add']);
Route::get('pedagang/update/{id}',[PedagangController::class, 'update']);
Route::post('pedagang/store/{id}',[PedagangController::class, 'store']);
Route::get('pedagang/delete/{id}',[PedagangController::class, 'delete']);
Route::get('pedagang/details/{id}',[PedagangController::class, 'details']);

Route::get('tempatusaha/data',function(){
    return view('tempat.data',[
        'dataset'=>TempatUsaha::data(),
        'airAvailable'=>TempatUsaha::airAvailable(),
        'listrikAvailable'=>TempatUsaha::listrikAvailable(),
        'trfKeamananIpk'=>TempatUsaha::trfKeamananIpk(),
        'trfKebersihan'=>TempatUsaha::trfKebersihan(),
        'trfAirKotor'=>TempatUsaha::trfAirKotor(),
        'trfLain'=>TempatUsaha::trfLain(),
        'trfDiskon'=>TempatUsaha::trfDiskon(),
    ]);
})->name('tempatdata');
Route::post('tempatusaha/add',[TempatController::class, 'add']);
Route::get('tempatusaha/update/{id}',[TempatController::class, 'update']);
Route::post('tempatusaha/store/{id}',[TempatController::class, 'store']);
Route::get('tempatusaha/delete/{id}',[TempatController::class, 'delete']);
Route::get('tempatusaha/details/{id}',[TempatController::class, 'details']);
Route::get('tempatusaha/fasilitas/{fas}',[TempatController::class, 'fasilitas']);
Route::get('tempatusaha/rekap',[TempatController::class, 'rekap']);
Route::get('tempatusaha/rekap/{blok}',[TempatController::class, 'rekapdetail']);

Route::get('tagihan/index/{data}',[TagihanController::class, 'data'])->name('tagihandata');
Route::get('tagihan/update/{id}',[TagihanController::class, 'update']);
Route::post('tagihan/store',[TagihanController::class, 'store']);
Route::get('tagihan/delete/{id}',[TagihanController::class, 'delete']);
Route::get('tagihan/{fasilitas}',[TagihanController::class, 'fasilitas'])->name('pedagangTagihan');
Route::post('tagihan/store/{fasilitas}/{id}',[TagihanController::class, 'storeFasilitas']);
Route::post('tagihan/edaran',[TagihanController::class, 'edaran']);

Route::get('utilities/tarif',function(){ 
    return view('tarif.index',[
        'listrik'=>TarifListrik::first(),
        'airbersih'=>TarifAirBersih::first(),
        'keamananipk'=>TarifKeamananIpk::orderBy('tarif', 'asc')->get(),
        'kebersihan'=>TarifKebersihan::orderBy('tarif', 'asc')->get(),
        'airkotor'=>TarifAirKotor::orderBy('tarif', 'asc')->get(),
        'lain'=>TarifLain::orderBy('tarif', 'asc')->get(),
    ]);
});
Route::post('utilities/tarif/add',[TarifController::class, 'add']);
Route::get('utilities/tarif/update/{fasilitas}/{id}',[TarifController::class, 'update']);
Route::post('utilities/tarif/store/{fasilitas}/{id}',[TarifController::class, 'store']);
Route::get('utilities/tarif/delete/{fasilitas}/{id}',[TarifController::class, 'delete']);

Route::get('utilities/meteran',function(){
    return view('meteran.index',[
        'listrik'=>MeteranListrik::all(),
        'airbersih'=>MeteranAir::all()
    ]);
});
Route::post('utilities/meteran/add',[MeteranController::class, 'add']);
Route::get('utilities/meteran/delete/{fasilitas}/{id}',[MeteranController::class, 'delete']);

Route::get('utilities/hari/libur',function(){
    return view('harilibur.index',[
        'dataset'=>HariLibur::orderBy('tanggal','asc')->get()
    ]);
});
Route::post('utilities/hari/libur/add',[HariLiburController::class, 'add']);
Route::get('utilities/hari/libur/update/{id}',[HariLiburController::class, 'update']);
Route::post('utilities/hari/libur/store/{id}',[HariLiburController::class, 'store']);
Route::get('utilities/hari/libur/delete/{id}',[HariLiburController::class, 'delete']);

Route::get('utilities/blok',function(){
    return view('blok.index',[
        'dataset'=>Blok::orderBy('nama','asc')->get()
    ]);
});

Route::get('rekap/pendapatan',[PendapatanController::class, 'index']);
Route::get('rekap/pendapatan/{filter}',[PendapatanController::class, 'filter']);

Route::get('rekap/pemakaian',[PemakaianController::class, 'index']);
Route::get('rekap/pemakaian/{fasilitas}/{bulan}',[PemakaianController::class, 'fasilitas']);

Route::get('rekap/data',[DataController::class, 'index']);

//opsional
Route::post('tagihan/pedagang/{fasilitas}',[TagihanController::class, 'pedagang']);

Route::middleware(['masteradmin'])->group(function () {
    
});
