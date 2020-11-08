<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Laporan Pendapatan | BP3C</title>
<div class = "container-fluid">
    <ul class="tabs-animated-shadow tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                <span>Harian</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                <span>Bulanan</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-c-2" data-toggle="tab" href="#tab-animated-2">
                <span>Tahunan</span>
            </a>
        </li>
    </ul>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Pendapatan</h6>
        </div>
        <div class="card-body">
            
            <div class="tab-content">
                <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                    @include('pendapatan.harian')
                </div>
                <div class="tab-pane" id="tab-animated-1" role="tabpanel">
                    @include('pendapatan.bulanan')
                </div>
                <div class="tab-pane" id="tab-animated-2" role="tabpanel">
                    @include('pendapatan.tahunan')
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
<div
    class="modal fade"
    id="modalHarian"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Pendapatan Harian by Range</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('data/harian')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="dari">Dari</label>
                        <input
                            required
                            autocomplete="off"
                            type="date"
                            name="dari"
                            class="form-control"
                            id="dari">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="sampai">Sampai</label>
                        <input
                            required
                            autocomplete="off"
                            type="date"
                            name="sampai"
                            class="form-control"
                            id="sampai">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="modalBulanan"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Pendapatan Bulanan by Range</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('data/bulanan')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label>Dari</label>
                        <div class="input-group">
                            <select class="form-control" name="dariBulan" id="dariBulan" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Bulan</option>
                            </select>
                            <select class="form-control" name="dariTahun" id="dariTahun" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Sampai</label>
                        <div class="input-group">
                            <select class="form-control" name="sampaiBulan" id="sampaiBulan" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Bulan</option>
                            </select>
                            <select class="form-control" name="sampaiTahun" id="sampaiTahun" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tahun</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="modalTahunan"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cari Pendapatan Tahunan by Range</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('data/tahunan')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label>Dari</label>
                        <div class="form-group">
                            <select class="form-control" name="dari" id="dari" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Sampai</label>
                        <div class="form-group">
                            <select class="form-control" name="sampai" id="sampai" required>
                                <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tahun</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Tambah Content pada Body JS -->
@endsection