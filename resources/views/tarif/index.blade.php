<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Tarif Fasilitas | BP3C</title>
<div class = "container-fluid">
    <ul class="tabs-animated-shadow tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('tarif') == 'listrik') ? 'active' : '' }}" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                <span>Listrik</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('tarif') == 'airbersih') ? 'active' : '' }}" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                <span>Air Bersih</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link  {{ (Session::get('tarif') == 'keamananipk') ? 'active' : '' }}" id="tab-c-2" data-toggle="tab" href="#tab-animated-2">
                <span>Keamanan & IPK</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('tarif') == 'kebersihan') ? 'active' : '' }}" id="tab-c-3" data-toggle="tab" href="#tab-animated-3">
                <span>Kebersihan</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('tarif') == 'airkotor') ? 'active' : '' }}" id="tab-c-4" data-toggle="tab" href="#tab-animated-4">
                <span>Air Kotor</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('tarif') == 'lain') ? 'active' : '' }}" id="tab-c-6" data-toggle="tab" href="#tab-animated-6">
                <span>Lain - Lain</span>
            </a>
        </li>
    </ul>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tarif Fasilitas</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Tarif Fasilitas</b></a>
            </div>
        </div>
        <div class="card-body">
            
            <div class="tab-content">
                <div class="tab-pane  {{ (Session::get('tarif') == 'listrik') ? 'active' : '' }}" id="tab-animated-0" role="tabpanel">
                    @include('tarif.listrik')
                </div>
                <div class="tab-pane  {{ (Session::get('tarif') == 'airbersih') ? 'active' : '' }}" id="tab-animated-1" role="tabpanel">
                    @include('tarif.airbersih')
                </div>
                <div class="tab-pane {{ (Session::get('tarif') == 'keamananipk') ? 'active' : '' }}" id="tab-animated-2" role="tabpanel">
                    @include('tarif.keamananipk')
                </div>
                <div class="tab-pane {{ (Session::get('tarif') == 'kebersihan') ? 'active' : '' }}" id="tab-animated-3" role="tabpanel">
                    @include('tarif.kebersihan')
                </div>
                <div class="tab-pane {{ (Session::get('tarif') == 'airkotor') ? 'active' : '' }}" id="tab-animated-4" role="tabpanel">
                    @include('tarif.airkotor')
                </div>
                <div class="tab-pane {{ (Session::get('tarif') == 'lain') ? 'active' : '' }}" id="tab-animated-6" role="tabpanel">
                    @include('tarif.lain')
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tarif</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('utilities/tarif/add')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group row col-lg-12">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="checkKeamananIpk"
                                    id="myCheck1"
                                    data-related-item="myDiv1">
                                <label class="form-check-label" for="myCheck1">
                                    Keamanan IPK
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="input-group" id="myDiv1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="keamananIpk"
                                        id="keamananIpk"
                                        placeholder="Masukkan Tarif Baru"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="checkKebersihan"
                                    id="myCheck2"
                                    data-related-item="myDiv2">
                                <label class="form-check-label" for="myCheck2">
                                    Kebersihan
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="input-group" id="myDiv2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="kebersihan"
                                        id="kebersihan"
                                        placeholder="Masukkan Tarif Baru"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="checkAirKotor"
                                    id="myCheck3"
                                    data-related-item="myDiv3">
                                <label class="form-check-label" for="myCheck3">
                                    Air Kotor
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="input-group" id="myDiv3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="airkotor"
                                        id="airkotor"
                                        placeholder="Masukkan Tarif Baru"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="checkDiskon"
                                    id="myCheck4"
                                    data-related-item="myDiv4">
                                <label class="form-check-label" for="myCheck4">
                                    Diskon
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="input-group" id="myDiv4">
                                    <input 
                                        type="number"
                                        max="100"
                                        min="0" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="diskon"
                                        id="diskon"
                                        placeholder="Masukkan Diskon Baru"
                                        aria-describedby="inputGroupPrepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="checkLain"
                                    id="myCheck5"
                                    data-related-item="myDiv5">
                                <label class="form-check-label" for="myCheck5">
                                    Lain - Lain
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="input-group" id="myDiv5">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="lain"
                                        id="lain"
                                        placeholder="Masukkan Tarif Baru"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
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
<script>
function evaluate() {
    var item = $(this);
    var relatedItem = $("#" + item.attr("data-related-item")).parent();

    if (item.is(":checked")) {
        relatedItem.fadeIn();
    } else {
        relatedItem.fadeOut();
    }
}
$('input[type="checkbox"]')
    .click(evaluate)
    .each(evaluate);
  
document
    .getElementById('keamananIpk')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('kebersihan')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('airkotor')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('lain')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
</script>
@endsection