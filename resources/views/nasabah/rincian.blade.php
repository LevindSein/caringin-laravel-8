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
            <div class="card-header">Rincian Tagihan Bulan {{indoBln($bln)}}</div>
            <div class="table-responsive card-body">
                <table 
                    id="tableRincian" 
                    class="table table-bordered" 
                    cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Kontrol</th>
                            <th style="text-align:center;">Total</th>
                            <th style="text-align:center;">Listrik</th>
                            <th style="text-align:center;">Air Bersih</th>
                            <th style="text-align:center;">Keamanan IPK</th>
                            <th style="text-align:center;">Kebersihan</th>
                            <th style="text-align:center;">Air Kotor</th>
                            <th style="text-align:center;">Lain Lain</th>
                            <th style="text-align:center;">Realisasi</th>
                            <th style="text-align:center;">Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataset as $data)
                        <tr>
                            <td style="text-align:center;">{{$data->kd_kontrol}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_tagihan)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_listrik)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_airbersih)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_keamananipk)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_kebersihan)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_airkotor)}}</td>
                            <td style="text-align:right;">{{number_format($data->ttl_lain)}}</td>
                            <td style="text-align:right;">{{number_format($data->rea_tagihan)}}</td>
                            <td style="text-align:right;">{{number_format($data->sel_tagihan)}}</td>
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
            '#tableRincian'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "deferRender": true,
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Rincian Tagihan {{indoBln($bln)}}',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "responsive": true,
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
@endsection