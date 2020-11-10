<div class="table-responsive">
    <table 
        class="table" 
        id="bongkaran"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead class="table-bordered">
            <tr>
                <th rowspan="2">Kontrol</th>
                <th colspan="4">Denda</th>
                <th rowspan="2">Tunggakan</th>
                <th rowspan="2">Bongkar</th>
            </tr>
            <tr>
                <th>Ke - 1</th>
                <th>Ke - 2</th>
                <th>Ke - 3</th>
                <th>Ke - 4</th>
            </tr>
        </thead>
        <tbody class="table-bordered">
            @foreach($bongkaran as $data)
            <tr>
                <td class="text-center">{{$data[0]}}</td>
                <td class="text-center">
                @if($data[1] != NULL)
                <i class="fas fa-check" style="color:green;"></i>
                @endif
                </td>
                <td>
                @if($data[2] != NULL)
                <i class="fas fa-check" style="color:green;"></i>
                @endif
                </td>
                <td>
                @if($data[3] != NULL)
                <i class="fas fa-check" style="color:green;"></i>
                @endif
                </td>
                <td>
                @if($data[4] != NULL)
                <i class="fas fa-check" style="color:green;"></i>
                @endif</td>
                <td>{{number_format($data[5])}}</td>
                <td class="text-center">
                    @if($data[3] != NULL)
                    <a
                        href="{{url('data/details',['peringatan','kontrol'])}}"
                        title="Print Peringatan">
                        <i class="fas fa-exclamation-circle" style="color:orange;"></i></a>
                    &nbsp;
                    @endif
                    @if($data[4] != NULL)
                    <a
                        href="{{url('data/details',['bongkaran','kontrol'])}}"
                        title="Bongkar Alat">
                        <i class="fas fa-gavel" style="color:#e74a3b;"></i></a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $(
            '#bongkaran'
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
                    title: 'Data Bongkaran',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 1,
                "rightColumns": 2,
            },
            "scrollX": true,
            "deferRender": true,
            "pageLength": 8,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [6] }
            ],
        });
    });
</script>