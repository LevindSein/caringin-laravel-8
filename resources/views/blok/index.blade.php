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
<title>Data Blok | BP3C</title>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Blok</h6>
            <div>
                <a 
                    href="#" 
                    data-toggle="modal"
                    data-target="#myModal" 
                    type="submit" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Blok</b></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="blok"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Blok</th>
                            <th>Jml.Los</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered">
                        <?php $no = 1; ?>
                        @foreach($dataset as $d)
                        <?php
                        $pengguna = DB::table('tempat_usaha')->where('blok',$d->nama)->count();
                        ?>
                        <tr>
                            <td class="text-center">{{$no}}</td>
                            <td class="text-center">{{$d->nama}}</td>
                            <td class="text-center">{{$pengguna}}</td>
                            <td class="text-center">
                                <a
                                    href="{{url('utilities/blok/update',[$d->id])}}"
                                    title="Edit">
                                    <i class="fas fa-edit fa-sm"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('utilities/blok/delete',[$d->id])}}"
                                    title="Hapus">
                                    <i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>
                            </td>
                        </tr>
                        <?php $no++; ?>
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
    tabIndex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Blok</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('utilities/blok/add')}}" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="blokInput">Blok <span style="color:red;">*</span></label>
                        <input
                            required
                            autocomplete="off"
                            type="text"
                            name="blokInput"
                            id="blokInput"
                            maxlength="8"
                            style="text-transform:uppercase;"
                            class="form-control"
                            placeholder="EX : A-10">
                    </div>
                    <!-- <div class="keamananipk-persen">
                        <div class="form-group col-lg-12">
                            <label for="keamanan">Persentase Keamanan</label>
                            <div class="input-group">
                                <input 
                                    type="number"
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
                    </div> -->
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

<script>
    $(document).ready(function () {
        $(
            '#blok'
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
                    title: 'Data Blok {{$sekarang}}',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
        });
    });
</script>

<!-- <script>
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
</script> -->
@endsection