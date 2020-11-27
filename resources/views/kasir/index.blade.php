@extends('layout.kasir')
@section('content')
<div class="form-group d-flex align-items-center justify-content-end">
    <div>
        <a 
            type="button"
            class="btn btn-outline-inverse-info"
            data-toggle="modal"
            data-target="#myModal"
            title="Cari Transaksi">
            <i class="mdi mdi-magnify btn-icon-append"></i>
        </a>
    </div>&nbsp;
    <div>
        <a 
            type="button"
            class="btn btn-outline-inverse-info"
            data-toggle="modal"
            data-target="#myPenerimaan"
            title="Cetak Penerimaan">
            <i class="mdi mdi-printer btn-icon-append"></i>  
        </a>
    </div>
    @if($platform == 'mobile')
    &nbsp;
    <div>
        <a 
            id="btn-scan-qr"
            type="button"
            class="btn btn-outline-inverse-info"
            title="Scan Qrcode">
            <i class="mdi mdi-qrcode-scan btn-icon-append"></i>  
        </a>
    </div>
    @endif
</div>
<div id="container">
    <div id="qr-result" hidden="">
        <input hidden id="outputData"></input>
    </div>
    <canvas hidden="" id="qr-canvas"></canvas>
</div>
<div class="row">
    <div class="table-responsive">
        <table 
            id="tableTest" 
            class="table table-bordered" 
            cellspacing="0"
            width="100%">
            <thead>
                <tr>
                    <th style="text-align:center;"><b>Action</b></th>
                    <th style="text-align:center;"><b>Kontrol</b></th>
                    <th style="text-align:center;"><b>Pengguna</b></th>
                    <th style="text-align:center;"><b>Tagihan</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataset as $data)
                @if($data[2] != 0)
                <tr>
                    <td style="text-align:center;">
                    @if($platform == 'mobile')
                        <button
                            onclick="ajax_print('{{url('/kasir/bayar',[$data[3]])}}',this)"
                            class="btn btn-sm btn-warning">Bayar
                        </button>
                    @else
                        <?php $id = $data[3]; ?>
                        <button
                            onclick="ajax_tagihan({{$id}},'{{url('/kasir/rincian',[$id])}}')"
                            class="btn btn-sm btn-warning">Bayar
                        </button>
                    @endif
                    </td>
                    <td style="text-align:center;">{{$data[0]}}</td>
                    <td style="text-align:center;">{{$data[1]}}</td>
                    <td style="text-align:center;color:green;"><b>{{number_format($data[2])}}</b></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modal')
<div
    class="modal fade"
    id="rincianTagihan"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Rincian</h3>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('kasir/bayar/store')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <br>
                    <input hidden id="tempatId" name="tempatId"></input>
                    <div class="col-lg-12 justify-content-between" style="display: flex;flex-wrap: wrap;">
                        <div>
                            <span style="color:#3f6ad8;"><strong>Fasilitas</strong></span>
                        </div>
                        <div>
                            <span style="color:#3f6ad8;"><strong>Nominal</strong></span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group col-lg-12 justify-content-between" style="display:none;flex-wrap:wrap;" id="divListrik">
                        <div>
                            <span id="listrik">Listrik</span>
                        </div>
                        <div>
                            <span id="nominalListrik"></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 justify-content-between" style="display:none;flex-wrap:wrap;" id="divAirBersih">
                        <div>
                            <span id="airbersih">Air Bersih</span>
                        </div>
                        <div>
                            <span id="nominalAirBersih"></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 justify-content-between" style="display:none;flex-wrap:wrap;" id="divKeamananIpk">
                        <div>
                            <span id="keamananipk">Keamanan & IPK</span>
                        </div>
                        <div>
                            <span id="nominalKeamananIpk"></span>
                        </div>
                    </div>
                    <div class="form-group col-lg-12 justify-content-between" style="display:none;flex-wrap:wrap;" id="divKebersihan">
                        <div>
                            <span id="kebersihan">Kebersihan</span>
                        </div>
                        <div>
                            <span id="nominalKebersihan"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="printStruk" class="btn btn-primary btn-sm">Bayar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
     $(document).ready(function () {
        var table = $(
            '#tableTest'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "dom": "r<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "scrollX": true,
            "deferRender": true,
            "responsive": true,
            pageLength: 3,
            order: [],
            columnDefs: [ {
                'targets': [0], /* column index [0,1,2,3]*/
                'orderable': false, /* true or false */
            }],
        });
        new $.fn.dataTable.FixedHeader(table);
    });

    
    $(document).ready(function () {
        $('#myModal').on('shown.bs.modal', function () {
            $('#kode').trigger('focus');
        });
    });

    $('#kode').on('keypress', function (event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
        event.preventDefault();
        return false;
        }
    });

    //Print Via Bluetooth atau USB
    function pc_print(data){
        var socket = new WebSocket("ws://127.0.0.1:40213/");
        socket.bufferType = "arraybuffer";
        socket.onerror = function(error) {
    	  alert("Oops! Sistem gagal melakukan printing");
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
        $.get(url, function (data) {
    		var ua = navigator.userAgent.toLowerCase();
    		var isAndroid = ua.indexOf("android") > -1; 
    		if(isAndroid) {
    		    android_print(data);
    		}else{
    		    pc_print(data);
    		}
        });
    }

    //Show Tagihan
    function ajax_tagihan(id,url){
        document.getElementById("tempatId").value = id;
        jQuery.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function(response) {
                if(response.tagihanListrik != 0){
                    document.getElementById("divListrik").style.display = "flex";
                    document.getElementById("nominalListrik").innerHTML = response.tagihanListrik;
                }
                else{
                    document.getElementById("divListrik").style.display = "none";
                }
                if(response.tagihanAirBersih != 0){
                    document.getElementById("divAirBersih").style.display = "flex";
                    document.getElementById("nominalAirBersih").innerHTML = response.tagihanAirBersih;
                }
                else{
                    document.getElementById("divAirBersih").style.display = "none";
                }
                if(response.tagihanKeamananIpk != 0){
                    document.getElementById("divKeamananIpk").style.display = "flex";
                    document.getElementById("nominalKeamananIpk").innerHTML = response.tagihanKeamananIpk;
                }
                else{
                    document.getElementById("divKeamananIpk").style.display = "none";
                }
                if(response.tagihanKebersihan != 0){
                    document.getElementById("divKebersihan").style.display = "flex";
                    document.getElementById("nominalKebersihan").innerHTML = response.tagihanKebersihan;
                }
                else{
                    document.getElementById("divKebersihan").style.display = "none";
                }
            }
        }).fail(function () {
            alert("Oops! Terjadi Kesalahan Sistem");
        });
        $('#rincianTagihan').modal('show');
    }

    document.getElementById("printStruk").onclick = function strukPembayaran() {
        var id = document.getElementById("tempatId").value;
        var btn = document.getElementById("printStruk");
        ajax_print("{{url('kasir/bayar')}}" + "/" + id,btn);
    }
</script>

@if($platform == 'mobile')
<script src="{{asset('js/qrCodeScanner.js')}}"></script>
@endif
@endsection