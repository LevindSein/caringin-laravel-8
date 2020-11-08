<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data Alat Meteran | BP3C</title>
<div class = "container-fluid">
    <ul class="tabs-animated-shadow tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('meteran') == 'listrik') ? 'active' : '' }}" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                <span>Listrik</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link {{ (Session::get('meteran') == 'airbersih') ? 'active' : '' }}" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                <span>Air Bersih</span>
            </a>
        </li>
    </ul>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Alat Meteran</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Alat Meteran</b></a>
                &nbsp;
                <a 
                    href="{{url('utilities/meteran/print')}}"
                    type="submit" 
                    class="btn btn-sm btn-info"><b>
                    <i class="fas fa-fw fa-print fa-sm text-white-50"></i> Print Form</b></a>
            </div>
        </div>
        <div class="card-body">
            
            <div class="tab-content">
                <div class="tab-pane  {{ (Session::get('meteran') == 'listrik') ? 'active' : '' }}" id="tab-animated-0" role="tabpanel">
                    @include('meteran.listrik')
                </div>
                <div class="tab-pane  {{ (Session::get('meteran') == 'airbersih') ? 'active' : '' }}" id="tab-animated-1" role="tabpanel">
                    @include('meteran.airbersih')
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Alat Meteran</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('utilities/meteran/add')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="nomor">Nomor Alat  <span style="color:red;">*</span></label>
                        <input
                            required
                            type="text"
                            autocomplete="off"
                            name="nomor"
                            class="form-control"
                            id="nomor">
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="col-sm-2">Tambah Alat</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="listrik"
                                    id="listrik"
                                    data-related-item="divListrik">
                                <label class="form-check-label" for="listrik">
                                    Listrik
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="form-group" id="divListrik">
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="standListrik"
                                        id="standListrik"
                                        placeholder="Masukkan Stand Akhir Listrik">
                                    <br>
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            autocomplete="off" 
                                            class="form-control input-group"
                                            name="dayaListrik"
                                            id="dayaListrik"
                                            placeholder="Masukkan Daya Listrik"
                                            aria-describedby="inputGroupPrepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">Watt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="air"
                                    id="air"
                                    data-related-item="divAir">
                                <label class="form-check-label" for="air">
                                    Air Bersih
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="form-group" id="divAir">
                                    <input 
                                        type="text" 
                                        autocomplete="off" 
                                        class="form-control"
                                        name="standAir"
                                        id="standAir"
                                        placeholder="Masukkan Stand Akhir Air">
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
</script>

<script>
    
$(document).ready(function () {
    $('#myModal').on('shown.bs.modal', function () {
        $('#nomor').trigger('focus');
    });
});

document
    .getElementById('standAir')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('standListrik')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );
document
    .getElementById('dayaListrik')
    .addEventListener(
        'input',
        event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
    );

function checkListrik() {
    if ($('#listrik').is(':checked')) {
        document
            .getElementById('standListrik')
            .required = true;
        document
            .getElementById('dayaListrik')
            .required = true;
    } else {
        document
            .getElementById('standListrik')
            .required = false;
        document
            .getElementById('dayaListrik')
            .required = false;
    }
}
$('input[type="checkbox"]')
    .click(checkListrik)
    .each(checkListrik);

function checkAir() {
    if ($('#air').is(':checked')) {
        document
            .getElementById('standAir')
            .required = true;
    } else {
        document
            .getElementById('standAir')
            .required = false;
    }
}
$('input[type="checkbox"]')
    .click(checkAir)
    .each(checkAir);
</script>
@endsection