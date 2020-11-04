<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Tagihan;
use App\Models\Pedagang;

use Exception;

class TagihanController extends Controller
{
    public function data(Request $request, $data){
        //inisialisasi
        date_default_timezone_set('Asia/Jakarta');
        $date = date("Y-m-01", time());
        $months = date("Y-m", time());
        $month = date("m", time());
        $year = date("Y", time());

        if($data == "now"){
            $bulan = Tagihan::indoBln($months);
            $bln = $months;
        }
        else if($data == "periode"){
            $bulan = Tagihan::indoBln($request->get('tahun').'-'.$request->get('bulan'));
            $bln = $request->get('tahun').'-'.$request->get('bulan');
        }
        else{
            return redirect()->back();
        }

        return view('tagihan.data',[
            'dataset'=>Tagihan::data($bln),
            'month'=>$month,
            'bulan'=>$bulan,
            'tahun'=>$year,
            'dataTahun'=>Tagihan::dataTahun(),
        ]);
    }

    public function update($id){

    }
    
    public function store(Request $request, $id){

    }

    public function delete($id){

    }

    public function fasilitas($fasilitas){
        $dataset = Tagihan::tagihan($fasilitas);
        if($dataset == "Not Periode"){
            return redirect()->back()->with('info','Bukan Periode Penambahan Tagihan');
        }
        else if($dataset == "Done"){
            return redirect()->route('tagihandata',$now)->with('success','Data Tagihan Listrik Selesai');
        }else{}

        if($fasilitas == 'listrik'){
            return view('tagihan.listrik',[
                'dataset'=>$dataset,
                'fasilitas'=>$fasilitas
            ]);
        }
        
        if($fasilitas == 'airbersih'){
            return view('tagihan.airbersih',[
                'dataset'=>$dataset,
                'fasilitas'=>$fasilitas
            ]);
        }
    }

    public function storeFasilitas(Request $request,$fasilitas, $id){
        $tagihanId = $request->get('tagihanId');
        $tempatId = $request->get('tempatId');
        $penggunaId = $request->get('namaPengguna');
        $awal = $request->get('awal');
        $awal = explode(',',$awal);
        $awal = implode("",$awal);
        
        $akhir = $request->get('akhir');
        $akhir = explode(',',$akhir);
        $akhir = implode("",$akhir);

        if($akhir < $awal){
            return redirect()->back()->with('error','Data Akhir Lebih Kecil dari Data Awal');
        }
        
        if($fasilitas == 'listrik'){
            $daya = $request->get('daya');
            $daya = explode(',',$daya);
            $daya = implode("",$daya);
            Tagihan::listrik($awal,$akhir,$daya);
        }

        if($fasilitas == 'airbersih'){
            Tagihan::airBersih($awal,$akhir);
        }
        return redirect()->route('pedagangTagihan',$fasilitas)->with('success','^_^');
    }

    //opsional
    public function pedagang(Request $request, $fasilitas){
        $ktp = $request->get('ktp');
        $nama = ucwords($request->get('nama'));
        $anggota = $request->get('anggota');
        try{
            $pedagang = new Pedagang;
            $pedagang->username = substr(str_shuffle('abcdefghjkmnpqrstuvwxyz'), 0, 4).str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
            $pedagang->nama = $nama;
            $pedagang->anggota = $anggota;
            $pedagang->password = md5(substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 10));
            $pedagang->role = 'nasabah';
            $pedagang->save();

            return redirect()->route('pedagangTagihan', $fasilitas)->with('success', 'Data Pedagang Ditambah');
        }catch(\Exception $e){
            return redirect()->route('pedagangTagihan', $fasilitas)->with('error','Pedagang Gagal Ditambah');
        }
    }
}
