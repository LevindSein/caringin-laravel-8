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
                            action="{{url('utilities/blok/store',[$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="blokInput">Blok <span style="color:red;">*</span></label>
                                <input
                                    required
                                    value="{{$dataset->nama}}"
                                    autocomplete="off"
                                    type="text"
                                    name="blokInput"
                                    id="blokInput"
                                    maxlength="8"
                                    style="text-transform:uppercase;"
                                    class="form-control"
                                    placeholder="EX : A-10">
                            </div>
                            <div class="keamananipk-persen">
                                <div class="form-group col-lg-12">
                                    <label for="keamanan">Persentase Keamanan</label>
                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            value="{{$dataset->prs_keamanan}}"
                                            autocomplete="off"
                                            min="0"
                                            max="100"
                                            class="form-control keamanan"
                                            name="keamanan"
                                            id="keamanan"
                                            oninput="functionKeamanan()"
                                            placeholder="Persentase Keamanan"
                                            aria-describedby="inputGroupPrepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="ipk">Persentase IPK</label>
                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            value="{{$dataset->prs_ipk}}"
                                            autocomplete="off"
                                            min="0"
                                            max="100"
                                            class="form-control ipk"
                                            name="ipk"
                                            id="ipk"
                                            oninput="functionIpk()"
                                            placeholder="Persentase IPK"
                                            aria-describedby="inputGroupPrepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">%</span>
                                        </div>
                                    </div>
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
function functionKeamanan() {
    $(".keamananipk-persen").each(function() { 
        var keamanan = document.getElementById("keamanan").value;

        var ipk = 100 - keamanan;
        $(this).find('.ipk').val(ipk);
    });
}
function functionIpk() {
    $(".keamananipk-persen").each(function() { 
        var ipk = document.getElementById("ipk").value;

        var keamanan = 100 - ipk;
        $(this).find('.keamanan').val(keamanan);
    });
}

$('#blokInput').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9\s\-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});

$("#blokInput").on("input", function() {
  if (/^,/.test(this.value)) {
    this.value = this.value.replace(/^,/, "")
  }
  else if (/^0/.test(this.value)) {
    this.value = this.value.replace(/^0/, "")
  }
})
</script>
@endsection