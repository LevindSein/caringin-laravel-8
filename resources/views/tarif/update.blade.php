<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Edit Tarif {{$fas}}| BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>Edit Tarif {{$fas}}</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <form
                            class="user"
                            action="{{url('utilities/tarif/store',[$fasilitas,$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="tarif">Tarif <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input required type="text" value="{{number_format($dataset->tarif)}}" autocomplete="off" class="form-control" name="tarif" id="tarif" placeholder="Edit Tarif" aria-describedby="inputGroupPrepend">
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
document
.getElementById('tarif')
.addEventListener(
    'input',
    event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
);
</script>
@endsection