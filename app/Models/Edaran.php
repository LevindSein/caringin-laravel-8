<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edaran extends Model
{
    private $fasilitas;
    private $harga;
    private $status;
    private $awal;
    private $akhir;
    private $pakai;
    private $daya;

    public function __construct($fasilitas = '', $harga = '', $status = '', $awal = '', $akhir = '', $pakai = '', $daya = '')
    {
        $this->fasilitas = $fasilitas;
        $this->harga = $harga;
        $this->status = $status;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->pakai = $pakai;
        $this->daya = $daya;
    }

    public function __toString()
    {        
        if($this->status == 'title'){
            $nama = substr($this->harga,0,20);
            $fasilitas = str_pad($this->fasilitas,9);
            $fasilitas = str_pad('| '.$fasilitas.': '.$nama, 42).' |';

            return "$fasilitas\n";
        }

        if($this->status == 'fasilitas'){
            $fasilitas = str_pad('| '.$this->fasilitas, 20);
            $harga = str_pad($this->harga, 22, ' ', STR_PAD_LEFT).' |';

            return "$fasilitas$harga\n";
        }

        if($this->status == 'listrik'){
            $fasilitas = str_pad('| '.$this->fasilitas, 20);
            $harga = str_pad($this->harga, 22, ' ', STR_PAD_LEFT).' |';

            $ket = str_pad('|      + Daya', 15);
            $daya = str_pad($this->daya, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $daya = $ket.$daya.$border;

            $ket = str_pad('|        Awal', 15);
            $awal = str_pad($this->awal, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $awal = $ket.$awal.$border;
            
            $ket = str_pad('|        Akhir', 15);
            $akhir = str_pad($this->akhir, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $akhir = $ket.$akhir.$border;

            $ket = str_pad('|        Pakai', 15);
            $pakai = str_pad($this->pakai, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $pakai = $ket.$pakai.$border;

            return "$fasilitas$harga\n$daya\n$awal\n$akhir\n$pakai\n";
        }

        if($this->status == 'airbersih'){
            $fasilitas = str_pad('| '.$this->fasilitas, 20);
            $harga = str_pad($this->harga, 22, ' ', STR_PAD_LEFT).' |';

            $ket = str_pad('|      + Awal', 15);
            $awal = str_pad($this->awal, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $awal = $ket.$awal.$border;
            
            $ket = str_pad('|        Akhir', 15);
            $akhir = str_pad($this->akhir, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $akhir = $ket.$akhir.$border;

            $ket = str_pad('|        Pakai', 15);
            $pakai = str_pad($this->pakai, 12,' ', STR_PAD_LEFT);
            $border = str_pad('|', 17, ' ', STR_PAD_LEFT);
            $pakai = $ket.$pakai.$border;

            return "$fasilitas$harga\n$awal\n$akhir\n$pakai\n";
        }
    }
}
