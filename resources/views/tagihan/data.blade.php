@extends('tagihan.index')
@section('body')
@section('title')
<h6 class="m-0 font-weight-bold text-primary">Tagihan Periode {{$bulan}}</h6>
@endsection
<div class="table-responsive ">
    <table
        class="table"
        id="tableTagihan"
        width="100%"
        cellspacing="0"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th rowspan="2">Kontrol</th>
                <th rowspan="2">Pengguna</th>
                <th colspan="4" class="listrik">Listrik</th>
                <th colspan="3" class="air">Air</th>
                <th rowspan="2" class="keamanan">Keamanan IPK (Rp.)</th>
                <th rowspan="2" class="kebersihan">Kebersihan (Rp.)</th>
                <th rowspan="2" style="background-color:rgba(255, 212, 71, 0.2);">Jumlah (Rp.)</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th class="listrik-hover">Daya</th>
                <th class="listrik-hover">Lalu</th>
                <th class="listrik-hover">Baru</th>
                <th class="listrik-hover">Total (Rp.)</th>
                <th class="air-hover">Lalu</th>
                <th class="air-hover">Baru</th>
                <th class="air-hover">Total (Rp.)</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            @foreach($dataset as $d)
            <tr>
                <td class="text-center">{{$d->kd_kontrol}}</td>
                <td class="text-left">{{$d->pengguna}}</td>
                <td>{{number_format($d->daya_listrik)}}</td>
                <td>{{number_format($d->awal_listrik)}}</td>
                <td>{{number_format($d->akhir_listrik)}}</td>
                <td>{{number_format($d->sel_listrik)}}</td>
                <td>{{number_format($d->awal_airbersih)}}</td>
                <td>{{number_format($d->akhir_airbersih)}}</td>
                <td>{{number_format($d->sel_airbersih)}}</td>
                <td>{{number_format($d->sel_keamananipk)}}</td>
                <td>{{number_format($d->sel_kebersihan)}}</td>
                <td>{{number_format($d->sel_tagihan)}}</td>
                <td class="text-center">
                    <a
                        href="{{url('tagihan/update',[$d->id])}}">
                        <i class="fas fa-edit fa-sm"></i></a>
                    &nbsp;
                    <a
                        href="{{url('tagihan/delete',[$d->id])}}">
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
            '#tableTagihan'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Tagihan Periode {{$bulan}}',
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                    }
                }
            ],
            "scrollX": true,
            "scrollCollapse": true,
            "deferRender": true,
            "fixedColumns":   {
                "leftColumns": 2,
                "rightColumns": 1,
            },
            "pageLength": 8,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [12] }
            ],
            "order": [ 0, "asc" ]
        });
    });
</script>
@endsection