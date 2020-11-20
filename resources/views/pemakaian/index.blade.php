<?php
$role = Session::get('role');

function tgl_indo($tanggal){
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
    $pecahkan = explode('-', $tanggal);
	return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Pemakaian Bulanan | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pemakaian Bulanan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table
                    class="table display table-bordered"
                    id="pemakaian"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Print</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($dataset as $d)
                        <tr>
                            <td class="text-center" <?php $bulan = tgl_indo($d->bln_pakai); ?>>{{$bulan}}</td>
                            <td class="text-center">
                                <a
                                    href="{{url('rekap/pemakaian',['listrik',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Listrik">
                                    <i class="fas fa-bolt" style="color:#fd7e14;"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('rekap/pemakaian',['airbersih',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Air Bersih">
                                    <i class="fas fa-tint" style="color:#36b9cc"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('rekap/pemakaian',['keamananipk',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Keamanan & IPK">
                                    <i class="fas fa-lock" style="color:#e74a3b"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('rekap/pemakaian',['kebersihan',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Kebersihan">
                                    <i class="fas fa-leaf" style="color:#1cc88a;"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('rekap/pemakaian',['airkotor',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Air Kotor">
                                    <i class="fas fa-fill-drip" style="color:#5a5c69;"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('rekap/pemakaian',['lain',$d->bln_pakai])}}"
                                    target="_blank"
                                    class="btn btn-light"
                                    title="Lain - Lain">
                                    <i class="fas fa-credit-card" style="color:#6610f2;"></i></a>
                            </td>
                        </tr>
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
            '#pemakaian'
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
            "ordering": false
        });
    });
</script>
@endsection