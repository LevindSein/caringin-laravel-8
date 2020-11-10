<div class="table-responsive">
    <table 
        class="table" 
        id="tagihan"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Bulan</th>
                <th colspan="3" class="listrik">Listrik</th>
                <th colspan="3" class="air">Air Bersih</th>
                <th colspan="3" class="keamanan">Keamanan & IPK</th>
                <th colspan="3" class="kebersihan">Kebersihan</th>
                <th colspan="3" style="background-color:rgba(50, 255, 255, 0.2);">Air Kotor</th>
                <th colspan="3" style="background-color:rgba(255, 50, 255, 0.2);">Lain - Lain</th>
                <th colspan="3" style="background-color:rgba(255, 212, 71, 0.2);">Total</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th class="listrik">Tagihan</th>
                <th class="listrik">Realisasi</th>
                <th class="listrik">Selisih</th>
                <th class="air">Tagihan</th>
                <th class="air">Realisasi</th>
                <th class="air">Selisih</th>
                <th class="keamanan">Tagihan</th>
                <th class="keamanan">Realisasi</th>
                <th class="keamanan">Selisih</th>
                <th class="kebersihan">Tagihan</th>
                <th class="kebersihan">Realisasi</th>
                <th class="kebersihan">Selisih</th>
                <th style="background-color:rgba(50, 255, 255, 0.2);">Tagihan</th>
                <th style="background-color:rgba(50, 255, 255, 0.2);">Realisasi</th>
                <th style="background-color:rgba(50, 255, 255, 0.2);">Selisih</th>
                <th style="background-color:rgba(255, 50, 255, 0.2);">Tagihan</th>
                <th style="background-color:rgba(255, 50, 255, 0.2);">Realisasi</th>
                <th style="background-color:rgba(255, 50, 255, 0.2);">Selisih</th>
                <th style="background-color:rgba(255, 212, 71, 0.2);">Tagihan</th>
                <th style="background-color:rgba(255, 212, 71, 0.2);">Realisasi</th>
                <th style="background-color:rgba(255, 212, 71, 0.2);">Selisih</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            <?php $i= 1; ?>
            @foreach($tagihan as $data)
            <tr>
                <td class="text-center">{{$i}}</td>
                <td class="text-center">{{indoBln($data->bln_tagihan)}}</td>
                <td>{{number_format($data->ttl_listrik)}}</td>
                <td>{{number_format($data->rea_listrik)}}</td>
                <td>{{number_format($data->sel_listrik)}}</td>
                <td>{{number_format($data->ttl_airbersih)}}</td>
                <td>{{number_format($data->rea_airbersih)}}</td>
                <td>{{number_format($data->sel_airbersih)}}</td>
                <td>{{number_format($data->ttl_keamananipk)}}</td>
                <td>{{number_format($data->rea_keamananipk)}}</td>
                <td>{{number_format($data->sel_keamananipk)}}</td>
                <td>{{number_format($data->ttl_kebersihan)}}</td>
                <td>{{number_format($data->rea_kebersihan)}}</td>
                <td>{{number_format($data->sel_kebersihan)}}</td>
                <td>{{number_format($data->ttl_airkotor)}}</td>
                <td>{{number_format($data->rea_airkotor)}}</td>
                <td>{{number_format($data->sel_airkotor)}}</td>
                <td>{{number_format($data->ttl_lain)}}</td>
                <td>{{number_format($data->rea_lain)}}</td>
                <td>{{number_format($data->sel_lain)}}</td>
                <td>{{number_format($data->ttl_tagihan)}}</td>
                <td>{{number_format($data->rea_tagihan)}}</td>
                <td>{{number_format($data->sel_tagihan)}}</td>
                <td class="text-center">
                    <a
                        href="{{url('data/details',['tagihan',$data->bln_tagihan])}}"
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
            '#tagihan'
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
                    title: 'Data Tagihan',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 2,
                "rightColumns": 1,
            },
            "pageLength": 8,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [23] }
            ],
        });
    });
</script>
