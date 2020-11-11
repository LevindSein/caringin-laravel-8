<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Edit Blok | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>Edit Blok</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <form
                            class="user"
                            action="{{url('utilities/hari/libur/store',[$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="tanggal">Tanggal <span style="color:red;">*</span></label>
                                <input
                                    required
                                    value="{{$dataset->tanggal}}"
                                    autocomplete="off"
                                    type="date"
                                    name="tanggal"
                                    class="form-control"
                                    id="tanggal">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="ket">Keterangan <span style="color:red;">*</span></label>
                                <input
                                    required
                                    value="{{$dataset->ket}}"
                                    autocomplete="off"
                                    type="text"
                                    name="ket"
                                    maxlength="30"
                                    class="form-control"
                                    id="ket"
                                    placeholder="Keterangan Libur">
                            </div>
                            <div class="form-group col-lg-12">
                                <Button type="submit"class="btn btn-primary btn-user btn-block">Update</Button>
                            </div>
                        </form>
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