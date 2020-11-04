<?php
$role = Session::get('role');
$random = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
$no_anggota = "BP3C".$random;
use App\Models\User;
$ktp = User::count();
$ktp = $ktp + 1;
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Tambah Tagihan | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        @yield('title')
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        @yield('body')
                    </div>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pedagang</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('tagihan/pedagang',[$fasilitas])}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="ktp">Nomor KTP</label>
                        <input
                            readonly
                            value="{{$ktp}}"
                            name="ktp"
                            class="form-control"
                            id="ktp">
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
                            placeholder="isi sesuai data">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="anggota">Nomor Anggota</label>
                        <input
                            readonly
                            value="{{$no_anggota}}"
                            name="anggota"
                            class="form-control"
                            id="anggota">
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
    document
        .getElementById('akhir')
        .addEventListener(
            'input',
            event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
        );
</script>
<script>
    document
        .getElementById('daya')
        .addEventListener(
            'input',
            event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
        );
</script>
<script>
    $(document).ready(function () {
        $('.namaPengguna').select2({
            placeholder: '--- Cari Nasabah ---',
            ajax: {
                url: "/cari/nasabah",
                dataType: 'json',
                delay: 250,
                processResults: function (nasabah) {
                    return {
                    results:  $.map(nasabah, function (nas) {
                        return {
                        text: nas.nama + " - " + nas.ktp,
                        id: nas.id
                        }
                    })
                    };
                },
                cache: true
            }
        });
    });

    $(document).ready(function(){
        $("#myModal").on('hide.bs.modal', function(){
            $('.nameNull').prop('checked', false);
        });
    });

    $('#myModal').on('shown.bs.modal', function() {
        $('#nama').focus();
    })

        
    var data = {
        id: '{{$dataset->penggunaId}}',
        text: '{{$dataset->pengguna}}' + ' - ' + '{{$dataset->ktp}}'
    };

    var newOption = new Option(data.text, data.id, false, false);
    $('#namaPengguna').append(newOption).trigger('change');
</script>
@endsection