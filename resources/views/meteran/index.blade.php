<?php
$role = Session::get('role');

date_default_timezone_set('Asia/Jakarta');
$sekarang = date("d-m-Y H:i:s",time());
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
                    target="_blank"
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
                            maxLength="30"
                            style="text-transform:uppercase;"
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
                                    type="radio"
                                    name="radioMeter"
                                    id="listrik"
                                    value="listrik"
                                    data-related-item="divListrik"
                                    checked>
                                <label class="form-check-label" for="listrik">
                                    Listrik
                                </label>
                            </div>
                            <div class="form-group" style="display:none" id="meteranListrik">
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
                                    type="radio"
                                    name="radioMeter"
                                    id="air"
                                    value="air"
                                    data-related-item="divAir">
                                <label class="form-check-label" for="air">
                                    Air Bersih
                                </label>
                            </div>
                            <div class="form-group" style="display:none" id="meteranAir">
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
    function statusMeter() {
        if ($('#listrik').is(':checked')) {
            document
                .getElementById('meteranListrik')
                .style
                .display = 'block';
            document
                .getElementById('meteranAir')
                .style
                .display = 'none';
        }
        else {
            document
                .getElementById('meteranListrik')
                .style
                .display = 'none';
            document
                .getElementById('meteranAir')
                .style
                .display = 'block';
        }
    }
    $('input[type="radio"]')
        .click(statusMeter)
        .each(statusMeter);
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
$('input[type="radio"]')
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
$('input[type="radio"]')
    .click(checkAir)
    .each(checkAir);


$('#nomor').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9\s\-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});

$("#nomor").on("input", function() {
  if (/^,/.test(this.value)) {
    this.value = this.value.replace(/^,/, "")
  }
  else if (/^0/.test(this.value)) {
    this.value = this.value.replace(/^0/, "")
  }
})
</script>
@endsection