<?php
use App\Models\Tagihan;

date_default_timezone_set('Asia/Jakarta');
$sekarang = date("d-m-Y H:i:s",time());
?>

@extends('tempat.index')
@section('body')
<title>Pengguna Fasilitas | BP3C</title>
@section('title')
<h6 class="m-0 font-weight-bold text-primary">Pengguna Fasilitas {{$fasilitas}}</h6>
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
                <th rowspan="2">Kontrol</th>
                <th rowspan="2">Lokasi</th>
                <th rowspan="2">Pengguna</th>
                <th colspan="4">Diskon / Bebas Bayar</th>
                <th rowspan="2">No.Los</th>
                <th rowspan="2">Jml.Los</th>
                <th rowspan="2">Usaha</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Ket</th>
                <th rowspan="2">Pemilik</th>
                <th rowspan="2">Tagihan</th>
            </tr>
            <tr>
                <th>Listrik</th>
                <th>Air Bersih</th>
                <th>Keamanan IPK</th>
                <th>Kebersihan</th>
            </tr>
        </thead>
        
        <tbody class="table-bordered">
        @foreach($dataset as $data)
        <?php 
        $tagihan = Tagihan::fasilitas($data->id,$fas);
        ?>
            <td class="text-center"
                    <?php if($data->stt_cicil==0){ ?> style="color:green;" <?php } ?>
                    <?php if($data->stt_cicil==1 || $data->stt_cicil==2){ ?> style="color:orange;" <?php } ?>>
                    {{$data->kd_kontrol}}
                </td>
                <td class="text-center">
                    @if($data->lok_tempat == NULL)
                        &mdash;
                    @else
                        {{$data->lok_tempat}}
                    @endif
                </td>
                <td class="text-left">{{$data->pengguna}}</td>
                <td class="text-center">
                    @if($data->dis_listrik == 1)
                    <i class="fas fa-check"></i>
                    @else
                    <i class="fas fa-times"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if($data->dis_airbersih == 1)
                    <i class="fas fa-check"></i>
                    @else
                    <i class="fas fa-times"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if($data->dis_keamananipk == 1)
                    <i class="fas fa-check"></i>
                    @else
                    <i class="fas fa-times"></i>
                    @endif
                </td>
                <td class="text-center">
                    @if($data->dis_kebersihan == 1)
                    <i class="fas fa-check"></i>
                    @else
                    <i class="fas fa-times"></i>
                    @endif
                </td>
                <td class="text-center" style="white-space:normal;">{{$data->no_alamat}}</td>
                <td>{{$data->jml_alamat}}</td>
                <td class="text-left">{{$data->bentuk_usaha}}</td>
                <td class="text-center">
                    @if($data->stt_tempat == 1)
                        &#10004;
                    @elseif($data->stt_tempat == 2)
                        &#10060;
                    @else
                        &nbsp;
                    @endif
                </td>
                <td class="text-center">
                    @if($data->ket_tempat == NULL && $data->stt_tempat == 1)
                        Aktif
                    @elseif($data->ket_tempat == NULL && $data->stt_tempat == NULL)
                        &mdash;
                    @elseif($data->stt_tempat == 2)
                        {{$data->ket_tempat}}
                    @endif
                </td>
                <td class="text-left">{{$data->pemilik}}</td>
                <td>{{number_format($tagihan)}}</td>
            </tr>
            @endforeach
        </tbody>
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
                    title: 'Pemakai Fasilitas {{$fas}} {{$sekarang}}',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 1,
            },
            "scrollX": true,
            "scrollCollapse": true,
            "pageLength": 8,
            "order": [ 0, "asc" ]
        });
    });
</script>
@endsection