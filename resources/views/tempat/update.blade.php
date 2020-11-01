<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Edit Data Pedagang | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>Edit Data Pedagang</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <form
                            class="user"
                            action="{{url('pedagang/store',[$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="ktp">Nomor KTP</label>
                                <input
                                    value="{{$dataset->ktp}}"
                                    required
                                    type="tel"
                                    min="0"
                                    name="ktp"
                                    maxlength="17"
                                    class="form-control"
                                    id="ktp"
                                    placeholder="321xxxxx">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="nama">Nama Pedagang</label>
                                <input
                                    value="{{$dataset->nama}}"
                                    required
                                    type="text"
                                    style="text-transform: capitalize;"
                                    name="nama"
                                    class="form-control"
                                    id="nama"
                                    maxlength="30"
                                    placeholder="Nama Sesuai KTP">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="anggota">Nomor Anggota</label>
                                <input
                                    value="{{$dataset->anggota}}"
                                    readonly
                                    value=""
                                    name="anggota"
                                    class="form-control"
                                    id="anggota">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <input type="text" value="{{trim($dataset->email,'@gmail.com')}}" class="form-control" maxlength="20" name="email" id="email" placeholder="youremail" aria-describedby="inputGroupPrepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">@gmail.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="hp">No. Handphone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">+62</span>
                                    </div>
                                    <input required type="tel" value="{{substr($dataset->hp,2)}}" class="form-control" maxlength="12" name="hp" id="hp" placeholder="8783847xxx" aria-describedby="inputGroupPrepend">
                                </div>
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

<script>
$('[type=tel]').on('change', function(e) {
  $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
})
$('[type=tel]').on('keypress', function(e) {
  keys = ['0','1','2','3','4','5','6','7','8','9','.']
  return keys.indexOf(event.key) > -1
})
</script>
@endsection