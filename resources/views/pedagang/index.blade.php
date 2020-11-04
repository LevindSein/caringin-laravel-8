<?php
$role = Session::get('role');
$random = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
$no_anggota = "BP3C".$random;
?>

@php
    $view = '';
    if ($role == 'master') {
        $view = 'layout.master';
    } 
    else if ($role == NULL){
        return "YES";
    }
@endphp

@extends($view)
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data Pedagang | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Pedagang</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Pedagang</b></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="tablePedagang"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                        <tr>
                            <th style="max-width:10px;">No</th>
                            <th>Nama</th>
                            <th>No. Anggota</th>
                            <th>No. KTP</th>
                            <th>Email</th>
                            <th>No. Hp</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="table-bordered">
                        <?php $i = 1; ?>
                        @foreach($dataset as $data)
                        <tr>
                            <td class="text-center" style="max-width:10px;">{{$i}}</td>
                            <td class="text-left">{{$data->nama}}</td>
                            <td class="text-center">{{$data->anggota}}</td>
                            <td class="text-center">{{$data->ktp}}</td>
                            <td class="text-center">{{$data->email}}</td>
                            <td class="text-center">{{$data->hp}}</td>
                            <td class="text-center">
                                <a
                                    href="{{url('pedagang/details',[$data->id])}}"
                                    type="submit" 
                                    class="btn btn-sm btn-primary">Details</a>
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{url('pedagang/update',[$data->id])}}">
                                    <i class="fas fa-edit fa-sm"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('pedagang/delete',[$data->id])}}">
                                    <i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
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
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pedagang</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('pedagang/add')}}" method="POST">
                <div class="modal-body">
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
                        <label for="nama">Nama Pedagang <span style="color:red;">*</span></label>
                        <input
                            required
                            autocomplete="off"
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
                            readonly
                            autocomplete="off"
                            value="{{$no_anggota}}"
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
                                    data-related-item="divPemilik">
                                <label class="form-check-label" for="pemilik">
                                    Pemilik
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="alamatPemilik"  id="divPemilik">Alamat <span style="color:red;">*</span></label>
                                <div class="form-group">
                                    <select style="width:100%" class="alamatPemilik" name="alamatPemilik[]" id="alamatPemilik" multiple></select>
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
    $(document).ready(function () {
        $(
            '#tablePedagang'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "scrollX": true,
            "bSortable": false,
            "deferRender": true,
            "pageLength": 8,
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Data Pedagang',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5]
                    }
                }
            ],
            "fixedColumns":   {
                "leftColumns": 2,
                "rightColumns": 2,
            },
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [2,3,4,5,6,7] }, 
                { "bSearchable": false, "aTargets": [6,7] }
            ]
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
  keys = ['0','1','2','3','4','5','6','7','8','9']
  return keys.indexOf(event.key) > -1
})
</script>
@endsection