
<div class="text-right my-auto">
    <a 
        href="#" 
        data-toggle="modal"
        data-target="#modalTahunan" 
        type="submit" 
        class="btn btn-sm btn-info">
        <i class="fas fa-search fa-sm text-white-50"></i> by Range</a>
</div>
<br>
<div class="table-responsive ">
    <table
        class="table"
        id="tahunan"
        width="100%"
        cellspacing="0"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th>Tanggal</th>
                <th>Realisasi</th>
                <th>Selisih</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            <tr>
                <td class="text-center"></td>
                <td></td>
                <td></td>
                <td class="text-center">
                    <a
                        href="{{url('rekap/pendapatan/details',['tahunan','id'])}}"
                        type="submit" 
                        class="btn btn-sm btn-primary">Details</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(
            '#tahunan'
        ).DataTable({
            "processing": true,
            "bProcessing": true,
            "language": {
                'loadingRecords': '&nbsp;',
                'processing': '<i class="fas fa-spinner"></i>'
            },
            "dom": "r<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'" +
                    "row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "buttons": [
                {
                    text: '<i class="fas fa-file-excel fa-lg"></i>',
                    extend: 'excel',
                    className: 'btn btn-success bg-gradient-success',
                    title: 'Pendapatan Tahunan {{$sekarang}}',
                    exportOptions: {
                        columns: [0,1,2]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "scrollX": true,
            "scrollCollapse": true,
            "deferRender": true,
        });
    });
</script>