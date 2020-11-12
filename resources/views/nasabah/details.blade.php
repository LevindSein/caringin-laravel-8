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
        <div class="card-header">Detail Tagihan {{indoBln($bln)}}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Listrik</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-warning">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-warning progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Air Bersih</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-info">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-info progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Keamanan IPK</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-danger">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-danger progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Kebersihan</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-success">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-success progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Air Kotor</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-primary">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-content">
                            <div class="widget-content-outer">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">
                                        <div class="widget-heading">Lain - Lain</div>
                                        <div class="widget-subheading">Perlu Dibayar</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <div class="widget-numbers text-gray">{{number_format(100000000)}}</div>
                                    </div>
                                </div>
                                <div class="widget-progress-wrapper">
                                    <div class="mb-3 progress">
                                        <div class="progress-bar progress-bar-animated bg-secondary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">{{number_format(0)}}</div>
                                    </div>
                                    <div class="progress-sub-label">
                                        <div class="sub-label-left">Tagihan</div>
                                        <div class="sub-label-right">{{number_format(0)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block text-center card-footer">
                <a href="{{url('nasabah/rincian',[$bln])}}" type="button" class="btn-wide btn btn-light">Rincian</a>
            </div>
        </div>
    </div>
</div>
<!-- End Rincian Tagihan -->
@endsection

@section('js')
@endsection