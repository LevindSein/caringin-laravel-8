@extends('tempat.index')
@section('body')
<title>Data Tempat Usaha | BP3C</title>
@section('title')
<h6 class="m-0 font-weight-bold text-primary">Data Tempat Usaha</h6>
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
                <th rowspan="2">No.Los</th>
                <th rowspan="2">Jml.Los</th>
                <th rowspan="2">Usaha</th>
                <th colspan="6">Fasilitas</th>
                <th rowspan="2">Diskon (%)</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Ket</th>
                <th rowspan="2">Pemilik</th>
                <th rowspan="2">Tagihan</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Air Bersih</th>
                <th>Listrik</th>
                <th>Keamanan IPK (RP.)</th>
                <th>Kebersihan (RP.)</th>
                <th>Air Kotor (RP.)</th>
                <th>Lain-Lain (RP.)</th>
            </tr>
        </thead>
        
        <tbody class="table-bordered">
            @foreach($dataset as $data)
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
                    @if($data->trf_airbersih != NULL)
                        @if($data->air == NULL)
                            0
                        @else
                            {{$data->air}}
                        @endif
                    @else
                        &mdash;
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_listrik != NULL)
                        @if($data->listrik == NULL)
                            0
                        @else
                            {{$data->listrik}}
                        @endif
                    @else
                        &mdash;
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_keamananipk == NULL)
                        &mdash;
                    @else
                        {{number_format($data->keamananipk)}}
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_kebersihan == NULL)
                        &mdash;
                    @else
                        {{number_format($data->kebersihan)}}
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_airkotor == NULL)
                        &mdash;
                    @else
                        {{number_format($data->airkotor)}}
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_lain == NULL)
                        &mdash;
                    @else
                        {{number_format($data->lain)}}
                    @endif
                </td>
                <td class="text-center">
                    @if($data->trf_diskon == NULL)
                        &mdash;
                    @else
                        {{number_format($data->diskon)}}
                    @endif
                </td>
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
                <td class="text-center">
                    <a
                        href="{{url('tempatusaha/details',[$data->id])}}"
                        type="submit" 
                        class="btn btn-sm btn-primary">Details</a>
                </td>
                <td class="text-center">
                <a
                        href="{{url('tempatusaha/update',[$data->id])}}">
                        <i class="fas fa-edit fa-sm"></i></a>
                    &nbsp;
                    <a
                        href="{{url('tempatusaha/delete',[$data->id])}}">
                        <i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>
                </td>
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
                    title: 'Data Tempat Usaha',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
                    }
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 2,
            },
            "scrollX": true,
            "scrollCollapse": true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [16, 17] }
            ],
            "pageLength": 8,
            "order": [ 0, "asc" ]
        });
    });
</script>
@endsection