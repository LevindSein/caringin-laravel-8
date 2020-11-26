<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Edit Data User | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>Edit Data User</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <form
                            class="user"
                            action="{{url('user/store',[$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="ktp">Nomor KTP <span style="color:red;">*</span></label>
                                <input
                                    required
                                    value="{{$dataset->ktp}}"
                                    autocomplete="off"
                                    type="tel"
                                    min="0"
                                    name="ktp"
                                    maxlength="17"
                                    class="form-control"
                                    id="ktp"
                                    placeholder="321xxxxx">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="nama">Nama  <span style="color:red;">*</span></label>
                                <input
                                    required
                                    value="{{$dataset->nama}}"
                                    autocomplete="off"
                                    name="nama"
                                    class="form-control"
                                    style="text-transform: capitalize;"
                                    id="nama"
                                    placeholder="Nama Sesuai KTP">
                            </div>
                            <div class="form-group row col-lg-12">
                                <div class="col-sm-2">Role</div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="role"
                                            id="roleAdmin"
                                            value="admin"
                                            <?php if($dataset->role == 'admin'){ ?>
                                            checked
                                            <?php } ?>>
                                        <label class="form-check-label" for="roleAdmin">
                                            Admin
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="role"
                                            id="roleManajer"
                                            value="manajer"
                                            <?php if($dataset->role == 'manajer'){ ?>
                                            checked
                                            <?php } ?>>
                                        <label class="form-check-label" for="roleManajer">
                                            Manajer
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="role"
                                            id="roleKeuangan"
                                            value="keuangan"
                                            <?php if($dataset->role == 'keuangan'){ ?>
                                            checked
                                            <?php } ?>>
                                        <label class="form-check-label" for="roleKeuangan">
                                            Keuangan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="role"
                                            id="roleKasir"
                                            value="kasir"
                                            <?php if($dataset->role == 'kasir'){ ?>
                                            checked
                                            <?php } ?>>
                                        <label class="form-check-label" for="roleKasir">
                                            Kasir
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <input type="text" value="{{substr($dataset->email, 0, strpos($dataset->email, '@'))}}" autocomplete="off" class="form-control" maxlength="20" name="email" id="email" placeholder="youremail" aria-describedby="inputGroupPrepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">@gmail.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="hp">No. Handphone <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">+62</span>
                                    </div>
                                    <input required type="tel" value="{{substr($dataset->hp,2)}}" autocomplete="off" class="form-control" maxlength="12" name="hp" id="hp" placeholder="8783847xxx" aria-describedby="inputGroupPrepend">
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
@endsection