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
                                <label for="ktp">Nomor KTP <span style="color:red;">*</span></label>
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
                                <label for="nama">Nama Pedagang <span style="color:red;">*</span></label>
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
                            <div class="form-group row col-lg-12">
                                <div class="col-sm-2">Status</div>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="pemilik"
                                            id="pemilik"
                                            value="pemilik"
                                            data-related-item="divPemilik"
                                            checked>
                                        <label class="form-check-label" for="pemilik">
                                            Pemilik
                                        </label>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <label for="alamatPemilik"  id="divPemilik">Alamat <span style="color:red;">*</span></label>
                                        <div class="form-group">
                                            <select style="width:100%" class="alamatPemilik" name="alamatPemilik[]" id="alamatPemilik" multiple>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="pengguna"
                                            id="pengguna"
                                            value="pengguna"
                                            data-related-item="divPengguna">
                                        <label class="form-check-label" for="pengguna">
                                            Pengguna
                                        </label>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <label for="alamatPengguna"  id="divPengguna">Alamat <span style="color:red;">*</span></label>
                                        <div class="form-group">
                                            <select style="width:100%" class="alamatPengguna" name="alamatPengguna[]" id="alamatPengguna" multiple></select>
                                        </div>
                                    </div>
                                </div>
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
                                <label for="hp">No. Handphone <span style="color:red;">*</span></label>
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
<script type="text/javascript">
$(document).ready(function () {
    $('.alamatPemilik').select2({
        placeholder: '--- Pilih Kepemilikan ---',
        ajax: {
            url: "/cari/alamat",
            dataType: 'json',
            delay: 250,
            processResults: function (alamat) {
                return {
                results:  $.map(alamat, function (al) {
                    return {
                    text: al.kd_kontrol,
                    id: al.id
                    }
                })
                };
            },
            cache: true
        }
    });
});

$('.alamatPemilik').on('select2:select', function(e) {
  var text = 'A'; // get text
  var id = 'B'; // get value

  tagsArray.push(text);
  console.log(tagsArray);
});

$(document).ready(function () {
    $('.alamatPengguna').select2({
        placeholder: '--- Pilih Tempat ---',
        ajax: {
            url: "/cari/alamat",
            dataType: 'json',
            delay: 250,
            processResults: function (alamat) {
                return {
                results:  $.map(alamat, function (al) {
                    return {
                    text: al.kd_kontrol,
                    id: al.id
                    }
                })
                };
            },
            cache: true
        }
    });
});
</script>

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
    
    function checkPemilik() {
        if ($('#pemilik').is(':checked')) {
            document
                .getElementById('alamatPemilik')
                .required = true;
        } else {
            document
                .getElementById('alamatPemilik')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkPemilik)
        .each(checkPemilik);

    function checkPengguna() {
        if ($('#pengguna').is(':checked')) {
            document
                .getElementById('alamatPengguna')
                .required = true;
        } else {
            document
                .getElementById('alamatPengguna')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkPengguna)
        .each(checkPengguna);
</script>

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