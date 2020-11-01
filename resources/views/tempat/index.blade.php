<?php
$role = Session::get('role');
?>

@extends( $role == 'master' ? 'layout.master' : 'layout.admin')
@section('head')
<!-- Tambah Content Pada Head -->
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data Tempat Usaha | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Tempat Usaha</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Tempat Usaha</b></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="tableTempat"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                    <tr>
                            <th rowspan="2">Kontrol</th>
                            <th rowspan="2">Lokasi</th>
                            <th rowspan="2">Pengguna</th>
                            <th rowspan="2">No.Los</th>
                            <th rowspan="2">Jml.Los</th>
                            <th rowspan="2">Usaha</th>
                            <th colspan="6">Fasilitas</th>
                            <th rowspan="2">Diskon (%)</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">Ket</th>
                            <th rowspan="2">Pemilik</th>
                            <th rowspan="2">Tagihan</th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th>Air Bersih</th>
                            <th>Listrik</th>
                            <th>Keamanan IPK (RP.)</th>
                            <th>Kebersihan (RP.)</th>
                            <th>Air Kotor (RP.)</th>
                            <th>Lain-Lain (RP.)</th>
                        </tr>
                    </thead>
                    
                    <tbody class="table-bordered">
                        @foreach($dataset as $data)
                        <td class="text-center"
                                <?php if($data->stt_cicil==0){ ?> style="color:green;" <?php } ?>
                                <?php if($data->stt_cicil==1 || $data->stt_cicil==2){ ?> style="color:orange;" <?php } ?>>
                                {{$data->kd_kontrol}}
                            </td>
                            <td class="text-center">
                                @if($data->lok_tempat == NULL)
                                    &mdash;
                                @else
                                    {{$data->lok_tempat}}
                                @endif
                            </td>
                            <td class="text-left">{{$data->pengguna}}</td>
                            <td class="text-center" style="white-space:normal;">{{$data->no_alamat}}</td>
                            <td>{{$data->jml_alamat}}</td>
                            <td class="text-left">{{$data->bentuk_usaha}}</td>
                            <td class="text-center">
                                @if($data->trf_airbersih != NULL)
                                    @if($data->air == NULL)
                                        0
                                    @else
                                        {{$data->air}}
                                    @endif
                                @else
                                    &mdash;
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_listrik != NULL)
                                    @if($data->listrik == NULL)
                                        0
                                    @else
                                        {{$data->listrik}}
                                    @endif
                                @else
                                    &mdash;
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_keamananipk == NULL)
                                    &mdash;
                                @else
                                    {{number_format($data->keamananipk)}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_kebersihan == NULL)
                                    &mdash;
                                @else
                                    {{number_format($data->kebersihan)}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_airkotor == NULL)
                                    &mdash;
                                @else
                                    {{number_format($data->airkotor)}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_lain == NULL)
                                    &mdash;
                                @else
                                    {{number_format($data->lain)}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->trf_diskon == NULL)
                                    &mdash;
                                @else
                                    {{number_format($data->diskon)}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->stt_tempat == 1)
                                    &#10004;
                                @elseif($data->stt_tempat == 2)
                                    &#10060;
                                @else
                                    &nbsp;
                                @endif
                            </td>
                            <td class="text-center">
                                @if($data->ket_tempat == NULL && $data->stt_tempat == 1)
                                    Aktif
                                @elseif($data->ket_tempat == NULL && $data->stt_tempat == NULL)
                                    &mdash;
                                @elseif($stt_tempat == 2)
                                    {{$data->ket_tempat}}
                                @endif
                            </td>
                            <td class="text-left">{{$data->pemilik}}</td>
                            <td class="text-center">
                                <a
                                    href="javascript:void(0)" 
                                    onclick="location.href='{{url('tempatusaha/details',[$data->id])}}'" 
                                    type="submit" 
                                    class="btn btn-sm btn-primary">Details</a>
                            </td>
                            <td class="text-center">
                            <a
                                    href="javascript:void(0)" 
                                    onclick="location.href='{{url('tempatusaha/update',[$data->id])}}'">
                                    <i class="fas fa-edit fa-sm"></i></a>
                                &nbsp;
                                <a
                                    href="javascript:void(0)" 
                                    onclick="location.href='{{url('tempatusaha/delete',[$data->id])}}'">
                                    <i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>
                            </td>
                        </tr>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tempat Usaha</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('tempatusaha/add')}}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="blok">Blok <span style="color:red;">*</span></label>
                        <div class="form-group">
                            <select class="blok" name="blok" id="blok" required></select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="los">Nomor Los <span style="color:red;">*</span></label>
                        <input
                            required
                            type="text"
                            autocomplete="off"
                            name="los"
                            id="los"
                            class="form-control"
                            placeholder="1A,2,3 (Pisahkan dengan Koma)">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="lokasi">Lokasi</label>
                        <input
                            type="text"
                            name="lokasi"
                            autocomplete="off"
                            id="lokasi"
                            maxLength="50"
                            class="form-control"
                            placeholder="Pedagang K5 Di Depan A-1-001">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="los">Bentuk Usaha <span style="color:red;">*</span></label>
                        <input
                            required
                            type="text"
                            name="usaha"
                            autocomplete="off"
                            id="usaha"
                            maxLength="30"
                            class="form-control"
                            placeholder="Misal : Distributor Logistik">
                    </div>

                    <!-- Pemilik -->
                    <div class="form-group col-lg-12">
                        <label for="pemilik">Pemilik Tempat</label>
                        <div class="form-group">
                            <select class="pemilik" name="pemilik" id="pemilik"></select>
                        </div>
                    </div>

                    <!-- Pengguna -->
                    <div class="form-group col-lg-12">
                        <label for="pengguna">Pengguna Tempat</label>
                        <div class="form-group">
                            <select class="pengguna" name="pengguna" id="pengguna"></select>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="form-group row col-lg-12">
                        <div class="col-sm-2">Fasilitas</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="air"
                                    id="myCheck1"
                                    value="a"
                                    data-related-item="myDiv1">
                                <label class="form-check-label" for="myCheck1">
                                    Air Bersih
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv1">Meteran Air <span style="color:red;">*</span></label>
                                <select class="form-control" name="meterAir" id="myDiv1">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Alat</option>
                                    @foreach($airAvailable as $air)
                                    <option value="{{$air->id}}">{{$air->kode}} - {{$air->nomor}} ({{$air->akhir}})</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="listrik"
                                    id="myCheck2"
                                    value="l"
                                    data-related-item="myDiv2">
                                <label class="form-check-label" for="myCheck2">
                                    Listrik
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv2">Meteran Listrik <span style="color:red;">*</span></label>
                                <select class="form-control" name="meterListrik" id="myDiv2">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Alat</option>
                                    <option value="Fahni"></option>
                                </select>
                            </div>


                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="ipkkeamanan"
                                    id="myCheck3"
                                    data-related-item="myDiv3">
                                <label class="form-check-label" for="myCheck3">
                                    Keamanan & IPK
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv3">Kategori Tarif <span style="color:red;">*</span></label>
                                <select class="form-control" name="trfKeamananIpk" id="myDiv3">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tarif</option>
                                    <option value="Fahni">Fahni</option>
                                </select>
                            </div>


                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="kebersihan"
                                    id="myCheck4"
                                    data-related-item="myDiv4">
                                <label class="form-check-label" for="myCheck4">
                                    Kebersihan
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv4">Kategori Tarif <span style="color:red;">*</span></label>
                                <select class="form-control" name="trfKebersihan" id="myDiv4">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tarif</option>
                                    <option value="Fahni"></option>
                                </select>
                            </div>

                            <hr class="sidebar-divider d-none d-md-block">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="airkotor"
                                    id="myCheck5"
                                    data-related-item="myDiv5">
                                <label class="form-check-label" for="myCheck5">
                                    Air Kotor
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv5">Kategori Tarif <span style="color:red;">*</span></label>
                                <select class="form-control" name="trfAirKotor" id="myDiv5">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tarif</option>
                                    <option value="Fahni"></option>
                                </select>
                            </div>

                            
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="lain"
                                    id="myCheck6"
                                    data-related-item="myDiv6">
                                <label class="form-check-label" for="myCheck6">
                                    Lain - Lain
                                </label>
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="myDiv6">Kategori Tarif <span style="color:red;">*</span></label>
                                <select class="form-control" name="trfLain" id="myDiv6">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tarif</option>
                                    <option value="Fahni"></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    <div class="form-group row col-lg-12">
                        <div class="col-sm-2">Metode Pembayaran</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="cicilan"
                                    id="cicilan1"
                                    value="0"
                                    checked>
                                <label class="form-check-label" for="cicilan1">
                                    Kontan
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="cicilan"
                                    id="cicilan2"
                                    value="1">
                                <label class="form-check-label" for="cicilan2">
                                    Cicilan
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="cicilan"
                                    id="cicilan3"
                                    value="2">
                                <label class="form-check-label" for="cicilan3">
                                    Diskon / Bebas Bayar
                                </label>
                            </div> 
                            <div class="form-group" style="display:none" id="diskon">
                                <label for="myDiv7">Kategori Tarif <span style="color:red;">*</span></label>
                                <select class="form-control" name="trfDiskon" id="myDiv7">
                                    <option disabled="disabled" selected="selected" hidden="hidden" value="">Pilih Tarif</option>
                                    <option value="Fahni"></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group row col-lg-12">
                        <div class="col-sm-2">Status Tempat</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="status"
                                    id="myStatus1"
                                    value="s1"
                                    checked="checked">
                                <label class="form-check-label" for="myStatus1">
                                    Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="status"
                                    id="myStatus2"
                                    value="s2">
                                <label class="form-check-label" for="myStatus2">
                                    Non-Aktif
                                </label>
                            </div>
                            <div class="form-group" style="display:none" id="ketStatus">
                                <input
                                    type="text"
                                    name="status"
                                    id="status"
                                    maxLength="50"
                                    class="form-control"
                                    placeholder="Jelaskan Kondisi Tempat">
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
<script type="text/javascript">
$(document).ready(function () {
    $('.blok').select2({
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

$(document).ready(function () {
    $('.pemilik, .pengguna').select2({
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
</script>

<script>
    $(document).ready(function () {
        $(
            '#tableTempat'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "deferRender": true,
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Data Tempat Usaha',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
                    }
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 2,
            },
            "scrollX": true,
            "scrollCollapse": true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [16, 17] }
            ],
            "pageLength": 8,
            "order": [ 0, "asc" ]
        });
    });
</script>

<!-- Fasilitas Button -->
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

<!-- Checking -->
<script>
    function checkAir() {
        if ($('#myCheck1').is(':checked')) {
            document
                .getElementById('myDiv1')
                .required = true;
        } else {
            document
                .getElementById('myDiv1')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkAir)
        .each(checkAir);
    
    function checkListrik() {
        if ($('#myCheck2').is(':checked')) {
            document
                .getElementById('myDiv2')
                .required = true;
        } else {
            document
                .getElementById('myDiv2')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkListrik)
        .each(checkListrik);

    function checkKeamananIpk() {
        if ($('#myCheck3').is(':checked')) {
            document
                .getElementById('myDiv3')
                .required = true;
        } else {
            document
                .getElementById('myDiv3')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkKeamananIpk)
        .each(checkKeamananIpk);

    
    function checkKebersihan() {
        if ($('#myCheck4').is(':checked')) {
            document
                .getElementById('myDiv4')
                .required = true;
        } else {
            document
                .getElementById('myDiv4')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkKebersihan)
        .each(checkKebersihan);

    function checkAirKotor() {
        if ($('#myCheck5').is(':checked')) {
            document
                .getElementById('myDiv5')
                .required = true;
        } else {
            document
                .getElementById('myDiv5')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkAirKotor)
        .each(checkAirKotor);

    function checkLain() {
        if ($('#myCheck6').is(':checked')) {
            document
                .getElementById('myDiv6')
                .required = true;
        } else {
            document
                .getElementById('myDiv6')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkLain)
        .each(checkLain);
</script>

<!-- Pembayaran -->
<script>
    function cicilan() {
        if ($('#cicilan1').is(':checked')) {
            document
                .getElementById('diskon')
                .style
                .display = 'none';
            document
                .getElementById('myDiv7')
                .required = false;
        }
        else if($('#cicilan2').is(':checked')) {
            document
                .getElementById('diskon')
                .style
                .display = 'none';
            document
                .getElementById('myDiv7')
                .required = false;
        }
        else{
            document
                .getElementById('diskon')
                .style
                .display = 'block';
            document
                .getElementById('myDiv7')
                .required = true;
        }
    }
    $('input[type="radio"]')
        .click(cicilan)
        .each(cicilan);
</script>


<!-- Status Button -->
<script>
    function statusTempat() {
        if ($('#myStatus1').is(':checked')) {
            document
                .getElementById('ketStatus')
                .style
                .display = 'none';
            document
                .getElementById('status')
                .required = false;
        }
        else {
            document
                .getElementById('ketStatus')
                .style
                .display = 'block';
            document
                .getElementById('status')
                .required = true;
        }
    }
    $('input[type="radio"]')
        .click(statusTempat)
        .each(statusTempat);
</script>
@endsection