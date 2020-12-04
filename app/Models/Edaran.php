<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edaran extends Model
{
    private $fasilitas;
    private $awal;
    private $akhir;
    private $pakai;
    private $harga;
    private $status;

    public function __construct($fasilitas = '', $awal = '', $akhir = '', $pakai = '', $harga = '', $status = '')
    {
        $this->fasilitas = $fasilitas;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->pakai = $pakai;
        $this->harga = $harga;
        $this->status = $status;
    }

    public function __toString()
    {        
        if($this->status == 'kebersihan'){
            //153 + 10 / 151 + 12
            $fasPemberitahuanWidth = 19;
            $hargaPemberitahuanWidth = 12;
            $fasPemberitahuanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPemberitahuanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);
            
            $fasPelunasanWidth = 19;
            $hargaPelunasanWidth = 12;
            $fasPelunasanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPelunasanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);

            $fasPembayaranWidth = 87;
            $hargaPembayaranWidth = 12;
            $fasPembayaranShow = str_pad('| '.$this->fasilitas, $fasPembayaranWidth);
            $hargaPembayaranShow = str_pad($this->harga.' |', $hargaPembayaranWidth, ' ', STR_PAD_LEFT);

            return "$fasPemberitahuanShow$hargaPemberitahuanShow $fasPelunasanShow$hargaPelunasanShow $fasPembayaranShow$hargaPembayaranShow\n";
        }

        if($this->status == 'listrik'){
            //153 + 10 / 151 + 12
            $fasPemberitahuanWidth = 19;
            $hargaPemberitahuanWidth = 12;
            $fasPemberitahuanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPemberitahuanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);
            
            $fasPelunasanWidth = 19;
            $hargaPelunasanWidth = 12;
            $fasPelunasanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPelunasanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);

            $fasPembayaranWidth = 20;
            $awalPembayaranWidth = 12;
            $akhirPembayaranWidth = 19;
            $pakaiPembayaranWidth = 19;
            $hargaPembayaranWidth = 29;
            $fasPembayaranShow = str_pad('| '.$this->fasilitas, $fasPembayaranWidth);
            $awalPembayaranShow = str_pad($this->awal, $awalPembayaranWidth,' ', STR_PAD_LEFT);
            $akhirPembayaranShow = str_pad($this->akhir, $akhirPembayaranWidth,' ', STR_PAD_LEFT);
            $pakaiPembayaranShow = str_pad($this->pakai, $pakaiPembayaranWidth,' ', STR_PAD_LEFT);
            $hargaPembayaranShow = str_pad($this->harga.' |', $hargaPembayaranWidth, ' ', STR_PAD_LEFT);

            return "$fasPemberitahuanShow$hargaPemberitahuanShow $fasPelunasanShow$hargaPelunasanShow $fasPembayaranShow$awalPembayaranShow$akhirPembayaranShow$pakaiPembayaranShow$hargaPembayaranShow\n";
        }

        if($this->status == 'total'){
            //153 + 10 / 151 + 12
            $fasPemberitahuanWidth = 19;
            $hargaPemberitahuanWidth = 12;
            $fasPemberitahuanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPemberitahuanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);
            
            $fasPelunasanWidth = 19;
            $hargaPelunasanWidth = 12;
            $fasPelunasanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPelunasanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);

            $fasPembayaranWidth = 87;
            $hargaPembayaranWidth = 12;
            $fasPembayaranShow = str_pad('| '.$this->fasilitas.' PEMBAYARAN', $fasPembayaranWidth);
            $hargaPembayaranShow = str_pad($this->harga.' |', $hargaPembayaranWidth, ' ', STR_PAD_LEFT);

            return "$fasPemberitahuanShow$hargaPemberitahuanShow $fasPelunasanShow$hargaPelunasanShow $fasPembayaranShow$hargaPembayaranShow\n";
        }

        if($this->status = 'alamat'){
            $fasPemberitahuanWidth = 19;
            $hargaPemberitahuanWidth = 12;
            $fasPemberitahuanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPemberitahuanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);
            
            $fasPelunasanWidth = 19;
            $hargaPelunasanWidth = 12;
            $fasPelunasanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPelunasanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);

            $fasPembayaranWidth = 87;
            $hargaPembayaranWidth = 12;
            $fasPembayaranShow = str_pad('| Alamat   : '.$this->harga, $fasPembayaranWidth);
            $hargaPembayaranShow = str_pad(' |', $hargaPembayaranWidth, ' ', STR_PAD_LEFT);

            return "$fasPemberitahuanShow$hargaPemberitahuanShow $fasPelunasanShow$hargaPelunasanShow $fasPembayaranShow$hargaPembayaranShow\n";
        }

        if($this->status = 'pedagang'){
            $fasPemberitahuanWidth = 19;
            $hargaPemberitahuanWidth = 12;
            $fasPemberitahuanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPemberitahuanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);
            
            $fasPelunasanWidth = 19;
            $hargaPelunasanWidth = 12;
            $fasPelunasanShow = str_pad('| '.$this->fasilitas, $fasPemberitahuanWidth);
            $hargaPelunasanShow = str_pad($this->harga.' |', $hargaPemberitahuanWidth, ' ', STR_PAD_LEFT);

            $fasPembayaranWidth = 70;
            $hargaPembayaranWidth = 27;
            $fasPembayaranShow = str_pad('| Pedagang : '.$this->harga, $fasPembayaranWidth);
            $hargaPembayaranShow = str_pad($this->pakai, $hargaPembayaranWidth).' |';

            return "$fasPemberitahuanShow$hargaPemberitahuanShow $fasPelunasanShow$hargaPelunasanShow $fasPembayaranShow$hargaPembayaranShow\n";
        }
    }
}
