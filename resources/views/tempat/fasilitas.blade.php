<?php
use App\Models\Tagihan;
?>

@extends('tempat.index')
@section('body')
<title>Pengguna Fasilitas | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pengguna Fasilitas {{$fasilitas}}</h6>
            <div>
                <a 
                    href="{{url('tempatusaha/data')}}" 
                    type="submit"
                    class="btn btn-sm btn-danger"><b>
                    <i class="fas fa-fw fa-chevron-left fa-sm text-white-50"></i> Data Tempat</b>
                </a>
                &nbsp;
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit"
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Tempat Usaha</b>
                </a>
                &nbsp;
                <a 
                    href="{{url('tempatusaha/rekap')}}" 
                    type="submit"
                    class="btn btn-sm btn-warning"><b>
                    <i class="fas fa-fw fa-eye fa-sm text-white-50"></i> Rekap</b>
                </a>
                &nbsp;
                <div class="dropdown no-arrow" style="display:inline-block">
                    <a 
                        class="dropdown-toggle btn btn-sm btn-info" 
                        href="#" 
                        role="button" 
                        data-toggle="dropdown"
                        aria-haspopup="true" 
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Pengguna Fasilitas:</div>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/airbersih')}}">Air Bersih</a>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/listrik')}}">Listrik</a>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/keamananipk')}}">Keamanan & IPK</a>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/kebersihan')}}">Kebersihan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/airkotor')}}">Air Kotor</a>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/diskon')}}">Diskon / Bebas Bayar</a>
                        <a class="dropdown-item" href="{{url('tempatusaha/fasilitas/lain')}}">Lain - Lain</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="tableTempat"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                    <tr>
                            <th>Kontrol</th>
                            <th>Lokasi</th>
                            <th>Pengguna</th>
                            <th>No.Los</th>
                            <th>Jml.Los</th>
                            <th>Usaha</th>
                            <th>Status</th>
                            <th>Ket</th>
                            <th>Pemilik</th>
                            <th>Tagihan</th>
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
                                @elseif($stt_tempat == 2)
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
        </div>
    </div>    
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
                    title: 'Pemakai Fasilitas {{$fas}}',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
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