<div class="table-responsive">
    <table 
        class="table" 
        id="tunggakan"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th>No.</th>
                <th>Bulan</th>
                <th>Pengguna</th>
                <th class="listrik">Listrik</th>
                <th class="air">Air Bersih</th>
                <th class="keamanan">Keamanan & IPK</th>
                <th class="kebersihan">Kebersihan</th>
                <th style="background-color:rgba(50, 255, 255, 0.2);">Air Kotor</th>
                <th style="background-color:rgba(255, 50, 255, 0.2);">Lain - Lain</th>
                <th style="background-color:rgba(255, 212, 71, 0.2);">Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            <?php $i= 1; ?>
            @foreach($tunggakan as $data)
            <tr>
                <td class="text-center">{{$i}}</td>
                <td class="text-center">{{indoBln($data->bln_tagihan)}}</td>
                <td class="text-center">{{$data->pengguna}}</td>
                <td>{{number_format($data->sel_listrik)}}</td>
                <td>{{number_format($data->sel_airbersih)}}</td>
                <td>{{number_format($data->sel_keamananipk)}}</td>
                <td>{{number_format($data->sel_kebersihan)}}</td>
                <td>{{number_format($data->sel_airkotor)}}</td>
                <td>{{number_format($data->sel_lain)}}</td>
                <td>{{number_format($data->sel_tagihan)}}</td>
                <td class="text-center">
                    <a
                        href="{{url('data/details',['tunggakan',$data->bln_tagihan])}}"
                        type="submit" 
                        class="btn btn-sm btn-primary">Details</a>
                </td>
            </tr>
            <?php $i++; ?>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(
            '#tunggakan'
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
                    title: 'Data Tunggakan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 2,
            },
            "scrollX": true,
            "deferRender": true,
            "pageLength": 8,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [10] }
            ],
        });
    });
</script>