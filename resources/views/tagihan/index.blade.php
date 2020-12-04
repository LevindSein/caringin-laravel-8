<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Tagihan Pedagang | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            @yield('title')
            <div>
                <a 
                    href="{{url('tagihan/listrik')}}"
                    type="submit"
                    class="btn btn-sm btn-warning"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Listrik </b> <span class="badge badge-pill badge-light">{{$listrikBadge}}</span>
                </a>
                &nbsp;
                <a 
                    href="{{url('tagihan/airbersih')}}"  
                    type="submit"
                    class="btn btn-sm btn-info"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Air Bersih </b> <span class="badge badge-pill badge-light">{{$airBersihBadge}}</span>
                </a>
                &nbsp;
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myPublish" 
                    type="submit" 
                    class="btn btn-sm btn-danger"><b>
                    <i class="fas fa-fw fa-paper-plane fa-sm text-white-50"></i> Publish</b>
                </a>
                &nbsp;
                <div class="dropdown no-arrow" style="display:inline-block">
                    <a 
                        class="dropdown-toggle btn btn-sm btn-success" 
                        href="#" 
                        role="button" 
                        data-toggle="dropdown"
                        aria-haspopup="true" 
                        aria-expanded="false"><b>
                        Menu
                        <i class="fas fa-ellipsis-v fa-sm fa-fw"></i></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Preview Tagihan:</div>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['listrik',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-bolt fa-sm text-gray-500"></i> Listrik
                        </a>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['airbersih',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-tint fa-sm text-gray-500"></i> Air Bersih
                        </a>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['keamananipk',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-lock fa-sm text-gray-500"></i> Keamanan IPK
                        </a>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['kebersihan',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-leaf fa-sm text-gray-500"></i> Kebersihan
                        </a>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['airkotor',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-fill-drip fa-sm text-gray-500"></i> Air Kotor
                        </a>
                        <a 
                            class="dropdown-item" 
                            href="{{url('rekap/pemakaian',['lain',$bulanPakai])}}"
                            target="_blank"
                            type="submit">
                            <i class="fas fa-fw fa-credit-card fa-sm text-gray-500"></i> Lain - Lain
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">Periode:</div>
                        <a 
                            class="dropdown-item" 
                            href="#"
                            data-toggle="modal" 
                            data-target="#myModal" 
                            type="submit">
                            <i class="fas fa-fw fa-search fa-sm text-gray-500"></i> Cari Tagihan
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-header">Edaran:</div>
                        <a 
                            class="dropdown-item" 
                            href="#" 
                            data-toggle="modal" 
                            data-target="#myEdaran" 
                            type="submit">
                            <i class="fas fa-fw fa-print fa-sm text-gray-500"></i> Print Edaran
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
        @yield('body')

        </div>
    </div>    
</div>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
<div
    class="modal fade"
    id="myPublish"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Publish Tagihan {{$bulan}} ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body-short">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle" style="color:#f6c23e;"></i>
                    <br>Pastikan Tagihan benar, sebelum melakukan 
                    <b><i class="fas fa-fw fa-paper-plane fa-sm" style="color:#e74a3b;"></i><span style="color:#e74a3b;">Publish</span></b>. 
                    <br>Lakukan <b>preview</b> pada opsi <b><span style="color:#1cc88a;">Menu</span><i class="fas fa-ellipsis-v fa-sm fa-fw" style="color:#1cc88a;"></i></b>
                    <br>Tagihan yang telah di-publish <b>tidak dapat diedit</b>.
                </div> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" type="submit" href="{{url('tagihan/publish/now')}}">Publish</a>
            </div>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bulan Tagihan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('tagihan/index/periode')}}" method="GET">
                <div class="modal-body-short">
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option selected="selected" hidden="hidden" value="{{$month}}">Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select class="form-control" name="tahun" id="tahun">
                            <option selected="selected" hidden="hidden"  value="{{$tahun}}">{{$tahun}}</option>
                            @foreach($dataTahun as $d)
                            <option value="{{$d->thn_tagihan}}">{{$d->thn_tagihan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="myEdaran"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Edaran</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body-short">
                    <div class="form-group">
                        <label for="blok">BLOK</label>
                        <select class="form-control" name="blok" id="blok" required>
                            <option selected="selected" hidden="hidden"  value="">Pilih Blok</option>
                            @foreach($blok as $b)
                            <option value="{{$b->nama}}">{{$b->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="cetakEdaran" class="btn btn-primary btn-sm">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('js')
<!-- Tambah Content pada Body JS -->
<script>
    document.getElementById("cetakEdaran").onclick = function edaran() {
        var blok = document.getElementById("blok").value;
        var btn = document.getElementById("cetakEdaran");
        ajax_print("{{url('tagihan/print/edaran')}}" + "/" + blok,btn);
    }

    //Print Via Bluetooth atau USB
    function pc_print(data){
        var socket = new WebSocket("ws://127.0.0.1:40213/");
        socket.bufferType = "arraybuffer";
        socket.onerror = function(error) {
    	  alert("Error");
        };			
    	socket.onopen = function() {
    		socket.send(data);
    		socket.close(1000, "Work complete");
    	};
    }		
    function android_print(data){
        window.location.href = data;  
    }
    function ajax_print(url, btn) {
        b = $(btn);
        b.attr('data-old', b.text());
        b.text('Proses');
        $.get(url, function (data) {
    		var ua = navigator.userAgent.toLowerCase();
    		var isAndroid = ua.indexOf("android") > -1; 
    		if(isAndroid) {
    		    android_print(data);
    		}else{
    		    pc_print(data);
    		}
        }).fail(function () {
            alert("Gagal Melakukan Print");
        }).always(function () {
            b.text(b.attr('data-old'));
        });
    }
</script>
@yield('jstable')
@endsection