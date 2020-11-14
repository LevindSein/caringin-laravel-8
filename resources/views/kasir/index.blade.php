@extends('layout.kasir')
@section('content')
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
                    <th style="text-align:center;"><b>Details</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataset as $data)
                @if($data[2] != 0)
                <tr>
                    <td style="text-align:center;">
                        <form action="{{url('kasir/bayar',$data[3])}}" method="POST">
                            @csrf
                            <button
                                type="submit" 
                                class="btn btn-sm btn-primary">Bayar
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">{{$data[0]}}</td>
                    <td style="text-align:center;">{{$data[1]}}</td>
                    <td style="text-align:right;">{{number_format($data[2])}}</td>
                    <td style="text-align:center;">
                        <a
                            href="{{url('kasir/details',$data[3])}}"
                            type="submit" 
                            class="btn btn-sm btn-primary">Details</a>
                    </td>
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
    id="myModal"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Transaksi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('kasir/cari/transaksi')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <br>
                        <input
                            required
                            autocomplete="off"
                            type="text"
                            style="text-transform:uppercase;"
                            name="kode"
                            maxlength="10"
                            class="form-control"
                            id="kode"
                            placeholder="Masukkan 10 Digit Kode Pembayaran">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
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
                'targets': [0,4], /* column index [0,1,2,3]*/
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
</script>
@endsection