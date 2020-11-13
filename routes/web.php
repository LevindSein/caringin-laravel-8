<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\LoginController;

use App\Models\Pedagang;
use App\Models\TempatUsaha;
use App\Models\HariLibur;
use App\Models\Blok;
use App\Models\User;

use App\Models\TarifAirBersih;
use App\Models\TarifListrik;
use App\Models\TarifKeamananIpk;
use App\Models\TarifKebersihan;
use App\Models\TarifAirKotor;
use App\Models\TarifLain;

use App\Models\MeteranListrik;
use App\Models\MeteranAir;

use App\Models\LoginLog;

//Home
Route::get('/', function(){
    return redirect()->route('login');
})->name('home');
Route::get('login',function(){
    return view('login.login');
})->name('login');

//LOGIN
Route::post('storelogin')->middleware('ceklogin');

//LOGOUT
Route::get('logout',function(){
    $tagihan = Session::get('tagihan');
    Session::flush();
    Session::put('tagihan', $tagihan);
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
})->name('tarifindex');
Route::post('utilities/tarif/add',[TarifController::class, 'add']);
Route::get('utilities/tarif/update/{fasilitas}/{id}',[TarifController::class, 'update']);
Route::post('utilities/tarif/store/{fasilitas}/{id}',[TarifController::class, 'store']);
Route::get('utilities/tarif/delete/{fasilitas}/{id}',[TarifController::class, 'delete']);

Route::get('utilities/meteran',function(){
    return view('meteran.index',[
        'listrik'=>MeteranListrik::all(),
        'airbersih'=>MeteranAir::all()
    ]);
})->name('meteranindex');
Route::post('utilities/meteran/add',[MeteranController::class, 'add']);
Route::get('utilities/meteran/delete/{fasilitas}/{id}',[MeteranController::class, 'delete']);
Route::get('utilities/meteran/print',[MeteranController::class, 'print']);

Route::get('utilities/hari/libur',function(){
    return view('harilibur.index',[
        'dataset'=>HariLibur::orderBy('tanggal','asc')->get()
    ]);
})->name('hariliburindex');
Route::post('utilities/hari/libur/add',[HariLiburController::class, 'add']);
Route::get('utilities/hari/libur/update/{id}',[HariLiburController::class, 'update']);
Route::post('utilities/hari/libur/store/{id}',[HariLiburController::class, 'store']);
Route::get('utilities/hari/libur/delete/{id}',[HariLiburController::class, 'delete']);

Route::get('utilities/blok',function(){
    return view('blok.index',[
        'dataset'=>Blok::orderBy('nama','asc')->get()
    ]);
})->name('blokindex');
Route::post('utilities/blok/add',[BlokController::class, 'add']);
Route::get('utilities/blok/update/{id}',[BlokController::class, 'update']);
Route::post('utilities/blok/store/{id}',[BlokController::class, 'store']);
Route::get('utilities/blok/delete/{id}',[BlokController::class, 'delete']);

Route::get('rekap/pendapatan',[PendapatanController::class, 'index']);
Route::post('rekap/pendapatan/harian',[PendapatanController::class, 'harian']);
Route::post('rekap/pendapatan/bulanan',[PendapatanController::class, 'bulanan']);
Route::post('rekap/pendapatan/tahunan',[PendapatanController::class, 'tahunan']);
Route::get('rekap/pendapatan/details/{filter}/{id}',[PendapatanController::class, 'details']);

Route::get('rekap/pemakaian',[PemakaianController::class, 'index']);
Route::get('rekap/pemakaian/{fasilitas}/{bulan}',[PemakaianController::class, 'fasilitas']);

Route::get('data',[DataController::class, 'index']);
Route::get('data/details/{data}/{bulan}',[DataController::class, 'details']);

Route::get('user',function(){
    return view('user.index',[
        'admin'=>User::admin(),
        'keuangan'=>User::keuangan(),
        'manajer'=>User::manajer(),
        'kasir'=>User::kasir(),
        'nasabah'=>User::nasabah(),
    ]);
})->name('userindex');
Route::post('user/add',[UserController::class, 'add']);
Route::get('user/update/{id}',[UserController::class, 'update']);
Route::post('user/store/{id}',[UserController::class, 'store']);
Route::get('user/delete/{id}',[UserController::class, 'delete']);
Route::get('user/reset/{id}',[UserController::class, 'reset']);

Route::get('log',function(){
    return view('log.index',[
        'dataset'=>LoginLog::orderBy('created_at','desc')->get()
    ]);
});

Route::get('nasabah/details/{bln}',[NasabahController::class, 'details']);
Route::get('nasabah/rincian/{bln}',[NasabahController::class, 'rincian']);

//opsional
Route::post('tagihan/pedagang/{fasilitas}',[TagihanController::class, 'pedagang']);

Route::middleware(['masteradmin'])->group(function () {
    
});
