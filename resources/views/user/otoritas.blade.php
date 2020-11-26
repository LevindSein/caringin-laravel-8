@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Otoritas Admin | BP3C</title>
<div class = "container-fluid">
    <div class="d-sm-flex align-items-center justify-content-center">
        <h3 class="h3 mb-4 text-primary"><b>Otoritas Admin</b></h3>
    </div>
    <div class="mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="card shadow col-lg-6">
                    <div class="p-4">
                        <form
                            class="user"
                            action="{{url('user/otoritas/store',[$dataset->id])}}"
                            method="POST">
                            @csrf
                            <div class="form-group col-lg-12">
                                <label for="username">Username</label>
                                <input
                                    readonly
                                    value="{{$dataset->username}}"
                                    name="username"
                                    class="form-control"
                                    id="username">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="nama">Nama</label>
                                <input
                                    readonly
                                    value="{{$dataset->nama}}"
                                    name="nama"
                                    class="form-control"
                                    id="nama">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="role">Role</label>
                                <input
                                    readonly
                                    value="{{$dataset->role}}"
                                    style="text-transform:capitalize;"
                                    name="role"
                                    class="form-control"
                                    id="role">
                            </div>
                            <hr class="sidebar-divider d-none d-md-block col-lg-10 text-center">
                            <div class="form-group col-lg-12">
                                <div class="form-group">
                                    <label for="blokOtoritas">Blok <span style="color:red;">*</span></label>
                                    <div class="form-group">
                                        <select style="width:100%" class="blokOtoritas" name="blokOtoritas[]" id="blokOtoritas" multiple required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center form-group">
                                <strong>Pilih Pengelolaan :</strong>
                            </div>
                            <div class="form-group col-lg-12 justify-content-between" style="display: flex;flex-wrap: wrap;">
                                <div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[1]->pedagang) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="pedagang"
                                            value="pedagang">
                                        <label class="form-check-label" for="pedagang">
                                            Pedagang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[2]->tempatusaha) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="tempatusaha"
                                            value="tempatusaha">
                                        <label class="form-check-label" for="tempatusaha">
                                            Tempat Usaha
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[3]->tagihan) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="tagihan"
                                            value="tagihan">
                                        <label class="form-check-label" for="tagihan">
                                            Tagihan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[4]->blok) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="blok"
                                            value="blok">
                                        <label class="form-check-label" for="blok">
                                            Blok
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[5]->pemakaian) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="pemakaian"
                                            value="pemakaian">
                                        <label class="form-check-label" for="pemakaian">
                                            Pemakaian
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[6]->pendapatan) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="pendapatan"
                                            value="pendapatan">
                                        <label class="form-check-label" for="pendapatan">
                                            Pendapatan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[7]->datausaha) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="datausaha"
                                            value="datausaha">
                                        <label class="form-check-label" for="datausaha">
                                            Data Usaha
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[8]->alatmeter) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="alatmeter"
                                            value="alatmeter">
                                        <label class="form-check-label" for="alatmeter">
                                            Alat Meter
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[9]->tarif) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="tarif"
                                            value="tarif">
                                        <label class="form-check-label" for="tarif">
                                            Tarif Fasilitas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input
                                            <?php if($otoritas[10]->harilibur) { ?> checked <?php }?>
                                            class="form-check-input"
                                            type="checkbox"
                                            name="kelola[]"
                                            id="harilibur"
                                            value="harilibur">
                                        <label class="form-check-label" for="harilibur">
                                            Hari Libur
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <Button type="submit"class="btn btn-primary btn-user btn-block">Simpan Otoritas</Button>
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
<script type="text/javascript">
$(document).ready(function () {
    $('.blokOtoritas').select2({
        placeholder: '--- Pilih Blok ---',
        ajax: {
            url: "/cari/blok",
            dataType: 'json',
            delay: 250,
            processResults: function (blok) {
                return {
                results:  $.map(blok, function (bl) {
                    return {
                    text: bl.nama,
                    id: bl.nama
                    }
                })
                };
            },
            cache: true
        }
    });
});

var s1 = $("#blokOtoritas").select2();
var valBlok = <?php echo json_encode($otoritas[0]->blok); ?>;

valBlok.forEach(function(e){
    if(!s1.find('option:contains(' + e + ')').length) 
        s1.append($('<option>').text(e));
});
s1.val(valBlok).trigger("change"); 
</script>
@endsection