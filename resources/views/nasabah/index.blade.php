<?php
date_default_timezone_set('Asia/Jakarta');
$bulan = date("Y-m",time());
$sekarang = date("d-m-Y H:i:s",time());

function indoBln($date){
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $date);
    return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

@extends('layout.nasabah')
@section('content')
<!-- Rincian Tagihan -->
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Riwayat Tagihan</div>
            <div class="table-responsive card-body">
                <table 
                    id="tableTest" 
                    class="table table-bordered" 
                    cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Tagihan</th>
                            <th style="text-align:center;">Total (Rp.)</th>
                            <th style="text-align:center;">Realisasi</th>
                            <th style="text-align:center;">Selisih</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataset as $data)
                        <tr>
                            <td style="text-align:center;">{{indoBln($data->bln_tagihan)}}</td>
                            <td style="text-align:right;">{{number_format($data->tagihan)}}</td>
                            <td style="text-align:right;">{{number_format($data->realisasi)}}</td>
                            <td style="text-align:right;">{{number_format($data->selisih)}}</td>
                            <td class="text-center">
                                <a
                                    href="{{url('#')}}"
                                    type="submit" 
                                    class="btn btn-sm btn-primary">Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Rincian Tagihan -->
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
            "scrollX": true,
            "deferRender": true,
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Data Tagihan',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "responsive": true,
            pageLength: 12,
            order: [],
            columnDefs: [ {
                'targets': [0,4], /* column index [0,1,2,3]*/
                'orderable': false, /* true or false */
            }],
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
@endsection