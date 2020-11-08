<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\MeteranListrik;
use App\Models\MeteranAir;

use Exception;

class MeteranController extends Controller
{
    public function add(Request $request, $id){
        
    }

    public function delete($fasilitas, $id){
        try{
            if($fasilitas == 'listrik'){
                $data = MeteranListrik::find($id);
                $data->delete();
                Session::put('meteran',$fasilitas);
                return redirect()->back()->with('success','Alat Meter Dihapus');
            }

            if($fasilitas == 'airbersih'){
                $data = MeteranAir::find($id);
                $data->delete();
                Session::put('meteran',$fasilitas);
                return redirect()->back()->with('success','Alat Meter Dihapus');
            }
        }
        catch(\Exception $e){
            Session::put('meteran',$fasilitas);
            return redirect()->back()->with('error','Alat Meter Terpasang');
        }
    }
}
