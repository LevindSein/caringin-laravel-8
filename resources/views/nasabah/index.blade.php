@extends('layout.nasabah')
@section('content')
<!-- Card -->
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Tagihan</div>
                    <div class="widget-subheading">Juni 2020</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>10,000,000</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Tunggakan</div>
                    <div class="widget-subheading">Juni 2020</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>10,000,000</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-grow-early">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Denda</div>
                    <div class="widget-subheading">Juni 2020</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span>10,000,000</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Card -->

<!-- Rincian Tagihan -->
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">History Tagihan</div>
            <div class="table-responsive card-body">
                <table 
                    id="tableTest" 
                    class="table table-bordered" 
                    cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Kategori</th>
                            <th style="text-align:center;">Tarif (Rp.)</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i= 1; ?>
                        @foreach($keamananipk as $data)
                        <tr>
                            <td style="text-align:center;">{{$i}}</td>
                            <td style="text-align:right;">{{number_format($data->tarif)}}</td>
                            <td class="text-center">
                                <a
                                    href="{{url('utilities/tarif/update',['keamananipk',$data->id])}}"
                                    title="Edit">
                                    <i class="fas fa-edit fa-sm"></i></a>
                                &nbsp;
                                <a
                                    href="{{url('utilities/tarif/delete',['keamananipk',$data->id])}}"
                                    title="Hapus">
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
<!-- End Rincian Tagihan -->
@endsection

@section('js')
<script>
     $(document).ready(function () {
        var table = $(
            '#tableTest'
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
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Tarif Keamanan IPK',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            responsive: true
        });
        new $.fn.dataTable.FixedHeader(table);
    });
</script>
@endsection