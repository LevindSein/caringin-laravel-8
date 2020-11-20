<?php
$role = Session::get('role');
date_default_timezone_set('Asia/Jakarta');
$sekarang = date("d-m-Y H:i:s",time());
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Riwayat Login | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Login</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table 
                    class="table table-bordered" 
                    id="history"
                    cellspacing="0"
                    width="100%"
                    style="font-size:0.75rem;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>KTP</th>
                            <th>HP</th>
                            <th>Role</th>
                            <th>Platform</th>
                            <th>Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        @foreach($dataset as $data)
                        <tr>
                            <td class="text-center">{{$i}}</td>
                            <td class="text-center">{{$data->username}}</td>
                            <td class="text-center">{{$data->nama}}</td>
                            <td class="text-center">{{$data->ktp}}</td>
                            <td class="text-center">{{$data->hp}}</td>
                            <td class="text-center">{{$data->role}}</td>
                            <td class="text-center">{{$data->platform}}</td>
                            <td class="text-center">{{$data->created_at}}</td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
@endsection

@section('js')
<!-- Tambah Content pada Body JS -->
<script>
    $(document).ready(function () {
        $(
            '#history'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "scrollX": true,
            "bSortable": false,
            "deferRender": true,
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Data Riwayat Login {{$sekarang}}',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    titleAttr: 'Download Excel'
                }
            ]
        });
    });
</script>
@endsection