<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Details Pedagang | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>{{$nama}}</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <div class="form-group col-lg-12">
                            <div class="d-sm-flex align-items-center justify-content-between">
                                <label>Alamat</label>
                                <label>Tagihan</label>
                            </div>
                            @foreach($dataset as $d)
                            <div class="input-group">
                                <input readonly type="text" value="{{$d[0]}}" class="form-control" name="alamat" id="alamat" aria-describedby="inputGroupPrepend">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupPrepend">Rp. {{number_format($d[1])}}</span>
                                </div>
                            </div><br>
                            @endforeach
                            <div class="form-group col-lg-12">
                                <a href="{{url('pedagang/data')}}" type="button" class="btn btn-primary btn-user btn-block">OK</a>
                            </div>
                        </div>
                    </div>
                </div>
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
@endsection