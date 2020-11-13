@extends('tagihan.form')
@section('title')
<h3 class="h3 mb-4 text-primary"><b>Tambah Tagihan Listrik</b></h3>
@endsection
@section('body')
<form class="user" action="{{url('tagihan/store',[$fasilitas,$dataset->tagihanId])}}" method="POST">
    @csrf
    <div class="form-group col-lg-12">
        <label for="kontrol">Kontrol</label>
        <input
            readonly
            required
            value="{{$dataset->kontrol}}"
            name="kontrol"
            class="form-control"
            id="kontrol">
    </div>
    <div class="col-lg-12">
        <label for="namaPengguna"  id="divPenggunaCheck">Pengguna </label>
        <div class="form-group">
            <select style="width:100%" class="namaPengguna" name="namaPengguna" id="namaPengguna"></select>
        </div>
    </div>
    <div class="form-group row col-lg-12">
        <div class="col-sm-12">
            <div class="form-check" style="text-align:right;">
                <input
                    class="form-check-input nameNull"
                    type="checkbox"
                    name="namaNull"
                    id="namaNull"
                    value="namaNull"
                    data-toggle="modal" 
                    data-target="#myModal">
                <label class="form-check-label" for="namaNull">
                    Nama Tidak Ada
                </label>
            </div>
        </div>
    </div>
    <div class="form-group col-lg-12">
        <label for="awalListrik">Stand Awal Listrik <span style="color:red;">*</span></label>
        <input
            required
            value="{{number_format($dataset->awal)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="awal"
            class="form-control"
            id="awal">
    </div>
    <div class="form-group col-lg-12">
        <label for="awalListrik">Stand Akhir Listrik <span style="color:red;">*</span></label>
        <input
            autofocus
            required
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="akhir"
            class="form-control"
            id="akhir">
    </div>
    <div class="form-group col-lg-12">
        <label for="daya">Daya Listrik <span style="color:red;">*</span></label>
        <input
            autofocus
            required
            value="{{number_format($dataset->daya)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="daya"
            class="form-control"
            id="daya">
    </div>
    <input type="hidden" name="tempatId" id="tempatId" value="{{$dataset->tempatId}}">
    <div class="form-group col-lg-12">
        <Input type="submit" value="Tambah Tagihan" class="btn btn-primary btn-user btn-block">
    </div>
</form>
@endsection