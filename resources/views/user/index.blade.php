<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data User | BP3C</title>
<div class = "container-fluid">
    <ul class="tabs-animated-shadow tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('user') == 'admin') ? 'active' : '' }}" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                <span>Admin</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('user') == 'manajer') ? 'active' : '' }}" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                <span>Manajer</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('user') == 'keuangan') ? 'active' : '' }}" id="tab-c-2" data-toggle="tab" href="#tab-animated-2">
                <span>Keuangan</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('user') == 'kasir') ? 'active' : '' }}" id="tab-c-3" data-toggle="tab" href="#tab-animated-3">
                <span>Kasir</span>
            </a>
        </li>
    </ul>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data User</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> User</b></a>
            </div>
        </div>
        <div class="card-body">
            
            <div class="tab-content">
                <div class="tab-pane  {{ (Session::get('user') == 'admin') ? 'active' : '' }}" id="tab-animated-0" role="tabpanel">
                    @include('user.admin')
                </div>
                <div class="tab-pane  {{ (Session::get('user') == 'manajer') ? 'active' : '' }}" id="tab-animated-1" role="tabpanel">
                    @include('user.manajer')
                </div>
                <div class="tab-pane  {{ (Session::get('user') == 'keuangan') ? 'active' : '' }}" id="tab-animated-2" role="tabpanel">
                    @include('user.keuangan')
                </div>
                <div class="tab-pane  {{ (Session::get('user') == 'kasir') ? 'active' : '' }}" id="tab-animated-3" role="tabpanel">
                    @include('user.kasir')
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
    id="myModal"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('user/add')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="ktp">Nomor KTP <span style="color:red;">*</span></label>
                        <input
                            required
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
                        <label for="nomor">Nama  <span style="color:red;">*</span></label>
                        <input
                            required
                            autocomplete="off"
                            name="nama"
                            class="form-control"
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
                                    value="admin">
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
                                    value="manajer">
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
                                    value="keuangan">
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
                                    value="kasir">
                                <label class="form-check-label" for="roleKasir">
                                    Kasir
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <input type="text" autocomplete="off" class="form-control" maxlength="20" name="email" id="email" placeholder="youremail" aria-describedby="inputGroupPrepend">
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
                            <input required type="tel" autocomplete="off" class="form-control" maxlength="12" name="hp" id="hp" placeholder="8783847xxx" aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Tambah Content pada Body JS -->
@endsection