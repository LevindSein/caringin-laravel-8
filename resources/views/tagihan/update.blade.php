@extends('tagihan.form')
@section('title')
<h3 class="h3 mb-4 text-primary"><b>Edit Tagihan</b></h3>
<title>Edit Tagihan</title>
@endsection
@section('body')
<form class="user" action="{{url('tagihan/store')}}" method="POST">
    @csrf
    <div class="form-group col-lg-12">
        <label for="kontrol">Kontrol</label>
        <input
            readonly
            required
            value="{{$dataset->kd_kontrol}}"
            name="kontrol"
            class="form-control"
            id="kontrol">
    </div>
    <div class="col-lg-12">
        <label for="namaPengguna"  id="divPenggunaCheck">Pengguna </label>
        <div class="form-group">
            <select style="width:100%" class="namaPengguna" name="pengguna" id="pengguna"></select>
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
    @if($dataset->stt_airbersih != NULL)
    <div class="form-group col-lg-12">
        <label for="awalListrik">Stand Awal Air Bersih <span style="color:red;">*</span></label>
        <input
            required
            value="{{number_format($dataset->awal_airbersih)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="awal"
            class="form-control"
            id="awal">
    </div>
    <div class="form-group col-lg-12">
        <label for="awalListrik">Stand Akhir Air Bersih <span style="color:red;">*</span></label>
        <input
            required
            value="{{number_format($dataset->akhir_airbersih)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="akhir"
            class="form-control"
            id="akhir">
    </div>
    @endif
    @if($dataset->stt_listrik != NULL)
    <div class="form-group col-lg-12">
        <label for="daya">Daya Listrik <span style="color:red;">*</span></label>
        <input
            required
            value="{{number_format($dataset->daya_listrik)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="daya"
            class="form-control"
            id="daya">
    </div>
    <div class="form-group col-lg-12">
        <label for="awalListrik">Stand Awal Listrik <span style="color:red;">*</span></label>
        <input
            required
            value="{{number_format($dataset->awal_listrik)}}"
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
            required
            value="{{number_format($dataset->akhir_listrik)}}"
            autocomplete="off"
            type="text" 
            pattern="^[\d,]+$"
            name="akhir"
            class="form-control"
            id="akhir">
    </div>
    @endif
    <div class="form-group col-lg-12">
        <Input type="submit" value="Tambah Tagihan" class="btn btn-primary btn-user btn-block">
    </div>
</form>
@endsection

@section('jsplus')
<script>
var data = [
    {
        id: '{{$dataset->penggunaId}}',
        text: '{{$dataset->pengguna}}' + ' - ' + '{{$dataset->ktp}}'
    }
];

var pengguna = new Option(data[0].text, data[0].id, false, false);
$('#pengguna').append(pengguna).trigger('change');
</script>
@endsection