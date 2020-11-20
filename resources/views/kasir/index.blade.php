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
                        <button
                            onclick="window.location = '{{url('/kasir/bayar',[$data[3]])}}'"
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

//Print Via Bluetooth
function ajax_print(url, btn) {
    b = $(btn);
    b.attr('data-old', b.text());
    b.text('wait');
    $.get(url, function (data) {
        window.location.href = data;  // main action
    }).fail(function () {
        alert("ajax error");
    }).always(function () {
        b.text(b.attr('data-old'));
    })
}
</script>
@if($platform == 'mobile')
<script src="{{asset('js/qrCodeScanner.js')}}"></script>
@endif
@endsection