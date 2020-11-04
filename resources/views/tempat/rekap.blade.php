@extends('tempat.index')
@section('body')
<title>Rekap Tempat Usaha | BP3C</title>
@section('title')
<h6 class="m-0 font-weight-bold text-primary">Rekap Tempat Usaha</h6>
@endsection
<div class="table-responsive ">
    <table
        class="table"
        id="tableTempat"
        width="100%"
        cellspacing="0"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th rowspan="2">Blok</th>
                <th rowspan="2">Jml Unit</th>
                <th colspan="4">Pengguna</th>
                <th colspan="4">Sisa</th>
                <th colspan="2">Status</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Listrik</th>
                <th>Air Bersih</th>
                <th>Keamanan IPK</th>
                <th>Kebersihan</th>
                <th>Listrik</th>
                <th>Air Bersih</th>
                <th>Keamanan IPK</th>
                <th>Kebersihan</th>
                <th>Aktif</th>
                <th>Pasif</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            <?php
            $unit = 0;
            $pengListrik = 0;
            $pengAirBersih = 0;
            $pengKeamananIpk = 0;
            $pengKebersihan = 0;
            $aktif = 0;
            ?>
            @foreach($dataset as $d)
            <?php 
            $unit = $unit + $d->total;
            $pengListrik = $pengListrik + $d->listrik;
            $pengAirBersih = $pengAirBersih + $d->airbersih;
            $pengKeamananIpk = $pengKeamananIpk + $d->keamananipk;
            $pengKebersihan = $pengKebersihan + $d->kebersihan;
            $aktif = $aktif + $d->aktif;
            ?>
            <tr>
                <td class="text-center">{{$d->blok}}</td>
                <td class="text-center">{{number_format($d->total)}}</td>
                <td class="text-center">{{number_format($d->listrik)}}</td>
                <td class="text-center">{{number_format($d->airbersih)}}</td>
                <td class="text-center">{{number_format($d->keamananipk)}}</td>
                <td class="text-center">{{number_format($d->kebersihan)}}</td>
                <td class="text-center">{{number_format($d->total - $d->listrik)}}</td>
                <td class="text-center">{{number_format($d->total - $d->airbersih)}}</td>
                <td class="text-center">{{number_format($d->total - $d->keamananipk)}}</td>
                <td class="text-center">{{number_format($d->total - $d->kebersihan)}}</td>
                <td class="text-center">{{number_format($d->aktif)}}</td>
                <td class="text-center">{{number_format($d->total - $d->aktif)}}</td>
                <td class="text-center">
                    <a
                        href="javascript:void(0)" 
                        onclick="location.href='{{url('tempatusaha/rekap',[$d->blok])}}'" 
                        type="submit" 
                        class="btn btn-sm btn-primary">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
            <td style="font-weight: bold;" class="text-center">Total</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($pengListrik)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($pengAirBersih)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($pengKeamananIpk)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($pengKebersihan)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit - $pengListrik)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit - $pengAirBersih)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit - $pengKeamananIpk)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit - $pengKebersihan)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($aktif)}}</td>
            <td style="font-weight: bold;" class="text-center">{{number_format($unit - $aktif)}}</td>
            <td></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@section('jstable')
<script>
    $(document).ready(function () {
        $(
            '#tableTempat'
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
                    title: 'Rekap Tempat Usaha',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    }
                }
            ],
            "fixedColumns":   {
                "leftColumns": 2,
                "rightColumns": 3,
            },
            "scrollX": true,
            "scrollCollapse": true,
            "pageLength": 8,
            "order": [ 0, "asc" ]
        });
    });
</script>
@endsection