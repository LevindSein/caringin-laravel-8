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
                <th colspan="2">Listrik</th>
                <th colspan="2">Air Bersih</th>
                <th colspan="2">Keamanan & IPK</th>
                <th colspan="2">Kebersihan</th>
                <th rowspan="2">Air Kotor</th>
                <th rowspan="2">Lain - Lain</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Ket</th>
                <th rowspan="2">Pemilik</th>
                <th rowspan="2">Tagihan</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Meteran</th>
                <th>Bebas Bayar</th>
                <th>Meteran</th>
                <th>Bebas Bayar</th>
                <th>Tarif</th>
                <th>Diskon</th>
                <th>Tarif</th>
                <th>Diskon</th>
            </tr>
        </thead>
        
        <tbody class="table-bordered">
            @foreach($dataset as $data)
            <tr>
                <td class="text-center" style="{{ ($data->stt_cicil == 0) ? 'color:green;' : 'color:orange;' }}">{{$data->kd_kontrol}}</td>
                <td class="text-center">@if($data->lok_tempat == NULL) &mdash; @else {{$data->lok_tempat}} @endif</td>
                <td class="text-left">{{$data->pengguna}}</td>
                <td class="text-center" style="white-space:normal;">{{$data->no_alamat}}</td>
                <td class="text-center">{{$data->jml_alamat}}</td>
                <td class="text-center">{{$data->bentuk_usaha}}</td>
                <td class="text-center">@if($data->trf_listrik == NULL) <i class="fas fa-times"></i> @else {{$data->listrik}} @endif</td>
                <td class="text-center">@if($data->dis_listrik == 0) <i class="fas fa-times"></i> @else <i class="fas fa-check"></i> @endif</td>
                <td class="text-center">@if($data->trf_airbersih == NULL) <i class="fas fa-times"></i> @else {{$data->air}} @endif</td>
                <td class="text-center">@if($data->dis_airbersih == 0) <i class="fas fa-times"></i> @else <i class="fas fa-check"></i> @endif</td>
                <td class="text-center">@if($data->trf_keamananipk == NULL) <i class="fas fa-times"></i> @else {{number_format($data->keamananipk)}} @endif</td>
                <td class="text-center">@if($data->dis_keamananipk == 0) <i class="fas fa-times"></i> @else <i class="fas fa-check"></i> @endif</td>
                <td class="text-center">@if($data->trf_kebersihan == NULL) <i class="fas fa-times"></i> @else {{number_format($data->kebersihan)}} @endif</td>
                <td class="text-center">@if($data->dis_kebersihan == 0) <i class="fas fa-times"></i> @else <i class="fas fa-check"></i> @endif</td>
                <td class="text-center">@if($data->trf_airkotor == NULL) <i class="fas fa-times"></i> @else {{number_format($data->airkotor)}} @endif</td>
                <td class="text-center">@if($data->trf_lain == NULL) <i class="fas fa-times"></i> @else {{number_format($data->lain)}} @endif</td>
                <td class="text-center">@if($data->stt_tempat == 1) &#10004; @else &#10060; @endif</td>
                <td class="text-center">@if($data->stt_tempat == 1) Aktif @else {{$data->ket_tempat}} @endif</td>
                <td class="text-left">{{$data->pemilik}}</td>
                <td class="text-center">
                    <a
                        href="{{url('tempatusaha/details',[$data->id])}}"
                        type="submit" 
                        class="btn btn-sm btn-primary">Details</a>
                </td>
                <td class="text-center">
                    <a
                        href="{{url('tempatusaha/update',[$data->id])}}"
                        title="Edit">
                        <i class="fas fa-edit fa-sm"></i></a>
                    &nbsp;
                    <a
                        href="{{url('tempatusaha/delete',[$data->id])}}"
                        title="Hapus">
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 2,
            },
            "scrollX": true,
            "scrollCollapse": true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [19,20] }
            ],
            "pageLength": 8,
            "order": [ 0, "asc" ]
        });
    });
</script>
@endsection