<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Exception;
use App\Models\TempatUsaha;
use App\Models\MeteranAir;
use App\Models\MeteranListrik;
use App\Models\PasangAlat;
use App\Models\TarifAirBersih;
use App\Models\TarifListrik;

class TempatController extends Controller
{
    public function add(Request $request){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y-m-d", time());

            //deklarasi model
            $tempat = new TempatUsaha;

            //blok
            $blok = $request->get('blok');
            $tempat->blok = $blok;
            
            //no_alamat
            $los = strtoupper($request->get('los'));
            $tempat->no_alamat = $los;
            
            //jml_alamat
            $los = explode(",",$los);
            $tempat->jml_alamat = count($los);
            
            //kd_kontrol
            $kode = TempatUsaha::kode($blok,$los);
            $tempat->kd_kontrol = $kode;
            
            //bentuk_usaha
            $tempat->bentuk_usaha = ucwords($request->get('usaha'));
            
            //lok_tempat
            $lokasi = $request->get('lokasi');
            if($lokasi != NULL){
                $tempat->lok_tempat = $lokasi;
            }

            //id_pemilik
            $id_pemillik = $request->get('pemilik');
            $tempat->id_pemilik = $id_pemillik;

            // //id_pengguna
            $id_pengguna = $request->get('pengguna');
            $tempat->id_pengguna = $id_pengguna;

            //Fasilitas
            if(empty($request->get('air')) == FALSE){
                $tempat->trf_airbersih = 1;
                $id_meteran_air = $request->get('meterAir');
                $tempat->id_meteran_air = $id_meteran_air;
                $meteran = MeteranAir::find($id_meteran_air);
                $meteran->stt_sedia = 1;
                $meteran->stt_bayar = 0;
                $meteran->save();

                if(empty($request->get('dis_airbersih')) == FALSE){
                    $tempat->dis_airbersih = 1;
                }

                //Tagihan Pasang
                $record = DB::table('pasang_alat')->where([['kd_kontrol',$kode],['id_meteran_air','!=',NULL],['tanggal',$tanggal]])->first();
                if($record == NULL){
                    $tarif = TarifAirBersih::find(1);
                    $pasang = new PasangAlat;
                    $pasang->kd_kontrol = $kode;
                    $pasang->id_pemilik = $id_pemillik;
                    $pasang->id_pengguna = $id_pengguna;
                    $pasang->id_meteran_air = $id_meteran_air;
                    $pasang->stt_pasang = 1; //Air
                    $pasang->ttl_pasang = $tarif->trf_pasang;
                    $pasang->rea_pasang = 0;
                    $pasang->sel_pasang = $tarif->trf_pasang;
                    $pasang->tanggal = $tanggal;
                    $pasang->save();
                }
                
                //Download Surat Perintah Bayar

            }

            if(empty($request->get('listrik')) == FALSE){
                $tempat->trf_listrik = 1;
                $value = $request->get('meterListrik');
                $value = explode(',',$value);
                $id_meteran_listrik = $value[0];
                $dayaListrik = $value[1];
                $tempat->id_meteran_listrik = $id_meteran_listrik;
                $tempat->daya = $dayaListrik;
                $meteran = MeteranListrik::find($id_meteran_listrik);
                $meteran->stt_sedia = 1;
                $meteran->stt_bayar = 0;
                $meteran->save();

                if(empty($request->get('dis_listrik')) == FALSE){
                    $tempat->dis_listrik = 1;
                }

                //Tagihan Pasang
                $record = DB::table('pasang_alat')->where([['kd_kontrol',$kode],['id_meteran_listrik','!=',NULL],['tanggal',$tanggal]])->first();
                if($record == NULL){
                    $tarif = TarifListrik::find(1);
                    $pasang = new PasangAlat;
                    $pasang->kd_kontrol = $kode;
                    $pasang->id_pemilik = $id_pemillik;
                    $pasang->id_pengguna = $id_pengguna;
                    $pasang->id_meteran_listrik = $id_meteran_listrik;
                    $pasang->stt_pasang = 2; //Listrik
                    $pasang->ttl_pasang = $tarif->trf_pasang;
                    $pasang->rea_pasang = 0;
                    $pasang->sel_pasang = $tarif->trf_pasang;
                    $pasang->tanggal = $tanggal;
                    $pasang->save();
                }

                //Download Surat Perintah Bayar
                
            }

            if(empty($request->get('keamananipk')) == FALSE){
                $tempat->trf_keamananipk = $request->get('trfKeamananIpk');

                if(empty($request->get('dis_keamananipk')) == FALSE){
                    $tempat->dis_keamananipk = 1;
                }
            }

            if(empty($request->get('kebersihan')) == FALSE){
                $tempat->trf_kebersihan = $request->get('trfKebersihan');

                if(empty($request->get('dis_kebersihan')) == FALSE){
                    $tempat->dis_kebersihan = 1;
                }
            }

            if(empty($request->get('airkotor')) == FALSE){
                $tempat->trf_airkotor = $request->get('trfAirKotor');
            }

            if(empty($request->get('lain')) == FALSE){
                $tempat->trf_lain = $request->get('trfLain');
            }

            // stt_cicil / Metode Pembayaran
            $stt_cicil = $request->get('cicilan');
            if($stt_cicil == "0"){
                $tempat->stt_cicil = 0; //Kontan
            }
            else if ($stt_cicil == "1"){
                $tempat->stt_cicil = 1; //Cicil
            }

            // stt_tempat
            $stt_tempat = $request->get('status');
            if($stt_tempat == "1"){
                $tempat->stt_tempat = 1;
            }
            else if($stt_tempat == "2"){
                $tempat->stt_tempat = 2;
                $tempat->ket_tempat = $request->get('ket_tempat');
            }

            //Save Record Tempat Usaha Baru
            $tempat->save();

            //get ID
            $id_tempat = $tempat->id;

            //Tagihan Pasang Alat
            if(empty($request->get('air')) == FALSE){
                $pasang = PasangAlat::where([
                    ['kd_kontrol',$kode],['id_meteran_air',$id_meteran_air],['id_tempat',NULL],['tanggal',$tanggal]
                    ])->first();
                if($pasang != NULL){
                    $id_pasang = $pasang->id;
                    $pasang = PasangAlat::find($id_pasang);
                    $pasang->id_tempat = $id_tempat;
                    $pasang->save();
                }
            }
            
            if(empty($request->get('listrik')) == FALSE){
                $pasang = PasangAlat::where([
                    ['kd_kontrol',$kode],['id_meteran_listrik',$id_meteran_listrik],['id_tempat',NULL],['tanggal',$tanggal]
                    ])->first();
                if($pasang != NULL){
                    $id_pasang = $pasang->id;
                    $pasang = PasangAlat::find($id_pasang);
                    $pasang->id_tempat = $id_tempat;
                    $pasang->save();
                }
            }

            return redirect()->route('tempatdata')->with('success','Data Tempat Ditambah');
        }catch(\Exception $e){
            return redirect()->back()->with('errorUpd','Data Gagal Ditambah');
        }
    }

    public function update($id){
        return view('tempat.update',[
            'dataset'=>TempatUsaha::updateData($id),
            'airAvailable'=>TempatUsaha::airAvailable(),
            'listrikAvailable'=>TempatUsaha::listrikAvailable(),
            'trfKeamananIpk'=>TempatUsaha::trfKeamananIpk(),
            'trfKebersihan'=>TempatUsaha::trfKebersihan(),
            'trfAirKotor'=>TempatUsaha::trfAirKotor(),
            'trfLain'=>TempatUsaha::trfLain(),
            'trfDiskon'=>TempatUsaha::trfDiskon(),
        ]);
    }

    public function store(Request $request,$id){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y-m-d", time());

            //deklarasi model
            $tempat = TempatUsaha::find($id);

            //blok
            $blok = $request->get('blok');
            $tempat->blok = $blok;
            
            //no_alamat
            $los = strtoupper($request->get('los'));
            $tempat->no_alamat = $los;
            
            //jml_alamat
            $los = explode(",",$los);
            $tempat->jml_alamat = count($los);
            
            //kd_kontrol
            $kode = TempatUsaha::kode($blok,$los);
            $tempat->kd_kontrol = $kode;
            
            //bentuk_usaha
            $tempat->bentuk_usaha = ucwords($request->get('usaha'));
            
            //lok_tempat
            $lokasi = $request->get('lokasi');
            if($lokasi != NULL){
                $tempat->lok_tempat = $lokasi;
            }
            else{
                $tempat->lok_tempat = NULL;
            }

            //id_pemilik
            $id_pemillik = $request->get('pemilik');
            $tempat->id_pemilik = $id_pemillik;

            // //id_pengguna
            $id_pengguna = $request->get('pengguna');
            $tempat->id_pengguna = $id_pengguna;

            $pasangBaruAir = 0;
            $pasangBaruListrik = 0;

            $meterAirLama = $tempat->id_meteran_air;

            //Fasilitas
            if(empty($request->get('air')) == FALSE){
                $id_meteran_air = $request->get('meterAir');
                $tempat->id_meteran_air = $id_meteran_air;
                $meteran = MeteranAir::find($id_meteran_air);
                $meteran->stt_sedia = 1;
                $meteran->stt_bayar = 0;
                $meteran->save();

                if(empty($request->get('dis_airbersih')) == FALSE){
                    $tempat->dis_airbersih = 1;
                }

                if($tempat->trf_airbersih == NULL){
                    $tempat->trf_airbersih = 1;
                    //Tagihan Pasang Baru
                    $record = DB::table('pasang_alat')->where([['kd_kontrol',$kode],['id_meteran_air','!=',NULL],['tanggal',$tanggal]])->first();
                    if($record == NULL){
                        $tarif = TarifAirBersih::find(1);
                        $pasang = new PasangAlat;
                        $pasang->kd_kontrol = $kode;
                        $pasang->id_pemilik = $id_pemillik;
                        $pasang->id_pengguna = $id_pengguna;
                        $pasang->id_meteran_air = $id_meteran_air;
                        $pasang->stt_pasang = 1; //Air
                        $pasang->ttl_pasang = $tarif->trf_pasang;
                        $pasang->rea_pasang = 0;
                        $pasang->sel_pasang = $tarif->trf_pasang;
                        $pasang->tanggal = $tanggal;
                        $pasang->save();
                    }
                    $pasangBaruAir = 1;
                
                    //Download Surat Perintah Bayar Pasang
                }
                else{
                    $tempat->trf_airbersih = 1;
                    //Jika Ganti Meteran Tagihan Ganti
                    if($meterAirLama != $request->get('meterAir')){
                        $tarif = TarifAirBersih::find(1);
                        $pasang = new PasangAlat;
                        $pasang->id_tempat = $id;
                        $pasang->kd_kontrol = $kode;
                        $pasang->id_pemilik = $id_pemillik;
                        $pasang->id_pengguna = $id_pengguna;
                        $pasang->id_meteran_air = $id_meteran_air;
                        $pasang->stt_pasang = 1; //Air
                        $pasang->ttl_pasang = $tarif->trf_pasang;
                        $pasang->rea_pasang = 0;
                        $pasang->sel_pasang = $tarif->trf_pasang;
                        $pasang->tanggal = $tanggal;
                        $pasang->save();
                        
                        $meteran = MeteranAir::find($meterAirLama);
                        $meteran->stt_sedia = 0;
                        $meteran->stt_bayar = 0;
                        $meteran->save();

                        // Download Surat Perintah Bayar
                    }
                }

            }
            else{
                if($tempat->trf_airbersih != NULL){
                    $meteran = MeteranAir::find($tempat->id_meteran_air);
                    $meteran->stt_sedia = 0;
                    $meteran->stt_bayar = 0;
                    $meteran->save();
                }
                $tempat->trf_airbersih = NULL;
                $tempat->id_meteran_air = NULL;
                $tempat->dis_airbersih = NULL;
            }

            $meterListrikLama = $tempat->id_meteran_listrik;

            if(empty($request->get('listrik')) == FALSE){
                $value = $request->get('meterListrik');
                $value = explode(',',$value);
                $id_meteran_listrik = $value[0];
                $dayaListrik = $value[1];
                $tempat->id_meteran_listrik = $id_meteran_listrik;
                $tempat->daya = $dayaListrik;
                $meteran = MeteranListrik::find($id_meteran_listrik);
                $meteran->stt_sedia = 1;
                $meteran->stt_bayar = 0;
                $meteran->save();

                if(empty($request->get('dis_listrik')) == FALSE){
                    $tempat->dis_listrik = 1;
                }

                
                if($tempat->trf_listrik == NULL){
                    $tempat->trf_listrik = 1;
                    //Tagihan Pasang Baru
                    $record = DB::table('pasang_alat')->where([['kd_kontrol',$kode],['id_meteran_listrik','!=',NULL],['tanggal',$tanggal]])->first();
                    if($record == NULL){
                        $tarif = TarifListrik::find(1);
                        $pasang = new PasangAlat;
                        $pasang->kd_kontrol = $kode;
                        $pasang->id_pemilik = $id_pemillik;
                        $pasang->id_pengguna = $id_pengguna;
                        $pasang->id_meteran_listrik = $id_meteran_listrik;
                        $pasang->stt_pasang = 2; //Listrik
                        $pasang->ttl_pasang = $tarif->trf_pasang;
                        $pasang->rea_pasang = 0;
                        $pasang->sel_pasang = $tarif->trf_pasang;
                        $pasang->tanggal = $tanggal;
                        $pasang->save();
                    }
                    $pasangBaruListrik = 1;

                    // Download Surat Perintah Bayar Pasang
                }
                else{
                    $tempat->trf_listrik = 1;
                    //Jika Ganti Meteran Tagihan Ganti
                    if($meterListrikLama != $request->get('meterListrik')){
                        $tarif = TarifListrik::find(1);
                        $pasang = new PasangAlat;
                        $pasang->id_tempat = $id;
                        $pasang->kd_kontrol = $kode;
                        $pasang->id_pemilik = $id_pemillik;
                        $pasang->id_pengguna = $id_pengguna;
                        $pasang->id_meteran_listrik = $id_meteran_listrik;
                        $pasang->stt_pasang = 2; //Listrik
                        $pasang->ttl_pasang = $tarif->trf_pasang;
                        $pasang->rea_pasang = 0;
                        $pasang->sel_pasang = $tarif->trf_pasang;
                        $pasang->tanggal = $tanggal;
                        $pasang->save();

                        $meteran = MeteranListrik::find($meterListrikLama);
                        $meteran->stt_sedia = 0;
                        $meteran->stt_bayar = 0;
                        $meteran->save();

                        // Download Surat Perintah Bayar
                    }
                }
            }
            else{
                if($tempat->trf_listrik != NULL){
                    $meteran = MeteranListrik::find($tempat->id_meteran_listrik);
                    $meteran->stt_sedia = 0;
                    $meteran->stt_bayar = 0;
                    $meteran->save();
                }
                $tempat->trf_listrik = NULL;
                $tempat->daya = NULL;
                $tempat->id_meteran_listrik = NULL;
                $tempat->dis_listrik = NULL;
            }

            if(empty($request->get('keamananipk')) == FALSE){
                $tempat->trf_keamananipk = $request->get('trfKeamananIpk');

                if(empty($request->get('dis_keamananipk')) == FALSE){
                    $tempat->dis_keamananipk = 1;
                }
            }
            else{
                $tempat->trf_keamananipk = NULL;
                $tempat->dis_keamananipk = NULL;
            }

            if(empty($request->get('kebersihan')) == FALSE){
                $tempat->trf_kebersihan = $request->get('trfKebersihan');

                if(empty($request->get('dis_kebersihan')) == FALSE){
                    $tempat->dis_kebersihan = 1;
                }
            }
            else{
                $tempat->trf_kebersihan = NULL;
                $tempat->dis_kebersihan = NULL;
            }

            if(empty($request->get('airkotor')) == FALSE){
                $tempat->trf_airkotor = $request->get('trfAirKotor');
            }
            else{
                $tempat->trf_airkotor = NULL;
            }

            if(empty($request->get('lain')) == FALSE){
                $tempat->trf_lain = $request->get('trfLain');
            }
            else{
                $tempat->trf_lain = NULL;
            }

            // stt_cicil / Metode Pembayaran
            $stt_cicil = $request->get('cicilan');
            if($stt_cicil == "0"){
                $tempat->stt_cicil = 0; //Kontan
            }
            else if ($stt_cicil == "1"){
                $tempat->stt_cicil = 1; //Cicil
            }

            // stt_tempat
            $stt_tempat = $request->get('status');
            if($stt_tempat == "1"){
                $tempat->stt_tempat = 1;
            }
            else if($stt_tempat == "2"){
                $tempat->stt_tempat = 2;
                $tempat->ket_tempat = $request->get('ket_tempat');
            }

            //Save Record Tempat Usaha
            $tempat->save();

            
            //get ID
            $id_tempat = $tempat->id;

            //Tagihan Pasang Alat Baru
            if($pasangBaruAir == 1){
                if(empty($request->get('air')) == FALSE){
                    $pasang = PasangAlat::where([
                        ['kd_kontrol',$kode],['id_meteran_air',$id_meteran_air],['id_tempat',NULL],['tanggal',$tanggal]
                        ])->first();
                    if($pasang != NULL){
                        $id_pasang = $pasang->id;
                        $pasang = PasangAlat::find($id_pasang);
                        $pasang->id_tempat = $id_tempat;
                        $pasang->save();
                    }
                }
            }
            
            if($pasangBaruListrik == 1){
                if(empty($request->get('listrik')) == FALSE){
                    $pasang = PasangAlat::where([
                        ['kd_kontrol',$kode],['id_meteran_listrik',$id_meteran_listrik],['id_tempat',NULL],['tanggal',$tanggal]
                        ])->first();
                    if($pasang != NULL){
                        $id_pasang = $pasang->id;
                        $pasang = PasangAlat::find($id_pasang);
                        $pasang->id_tempat = $id_tempat;
                        $pasang->save();
                    }
                }
            }

            return redirect()->route('tempatdata')->with('success','Data Tempat Diupdate');
        }catch(\Exception $e){
            return redirect()->back()->with('error','Kesalahan Sistem');
        }
    }

    public function delete($id){
        try{
            $tempat = TempatUsaha::find($id);
            $nama = $tempat->kd_kontrol;
            $tempat->delete();
            return redirect()->route('tempatdata')->with('success','Tempat '.$nama.' Dihapus');
        }catch(\Exception $e){
            return redirect()->route('tempatdata')->with('errorUpd','Tempat '.$nama.' Tidak Dapat Dihapus - Memiliki Sejumlah Tagihan');
        }
    }

    public function details($id){
        $nama = TempatUsaha::find($id);
        $nama = $nama->kd_kontrol;
        $dataset = TempatUsaha::details($id);
        if($dataset == NULL){
            return redirect()->back()->with('infoUpd','Tempat '.$nama.' Tidak Memiliki Detail Tagihan');
        }
        else{
            return view('tempat.details',['dataset'=>$dataset,'nama'=>$nama]);
        }
    }

    public function fasilitas($fas){
        $dataset = TempatUsaha::fasilitas($fas);
        if($fas == 'airbersih'){
            $fasilitas = 'Air Bersih';
        }
        else if($fas == 'listrik'){
            $fasilitas = 'Listrik';
        }
        else if($fas == 'keamananipk'){
            $fasilitas = 'Keamanan & IPK';
        }
        else if($fas == 'kebersihan'){
            $fasilitas = 'Kebersihan';
        }
        else if($fas == 'airkotor'){
            $fasilitas = 'Air Kotor';
        }
        else if($fas == 'diskon'){
            $fasilitas = 'Diskon / Bebas Bayar';
        }
        else if($fas == 'lain'){
            $fasilitas = 'Lain - Lain';
        }
        
        if($fas == 'diskon'){
            $view = 'tempat.diskon';
        }
        else{
            $view = 'tempat.fasilitas';
        }
        return view($view,[
            'dataset'=>$dataset,
            'fasilitas'=>$fasilitas,
            'fas'=>$fas,
            'airAvailable'=>TempatUsaha::airAvailable(),
            'listrikAvailable'=>TempatUsaha::listrikAvailable(),
            'trfKeamananIpk'=>TempatUsaha::trfKeamananIpk(),
            'trfKebersihan'=>TempatUsaha::trfKebersihan(),
            'trfAirKotor'=>TempatUsaha::trfAirKotor(),
            'trfLain'=>TempatUsaha::trfLain(),
            'trfDiskon'=>TempatUsaha::trfDiskon(),
        ]);
    }

    public function rekap(){
        $dataset = TempatUsaha::rekap();
        return view('tempat.rekap',[
            'dataset'=>$dataset,
            'airAvailable'=>TempatUsaha::airAvailable(),
            'listrikAvailable'=>TempatUsaha::listrikAvailable(),
            'trfKeamananIpk'=>TempatUsaha::trfKeamananIpk(),
            'trfKebersihan'=>TempatUsaha::trfKebersihan(),
            'trfAirKotor'=>TempatUsaha::trfAirKotor(),
            'trfLain'=>TempatUsaha::trfLain(),
            'trfDiskon'=>TempatUsaha::trfDiskon(),
        ]);
    }

    public function rekapdetail($blok){
        return view('tempat.details-rekap',['dataset'=>TempatUsaha::detailRekap($blok),'blok'=>$blok]);
    }
}
