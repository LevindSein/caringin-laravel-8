<div class="table-responsive">
    <table 
        class="table table-bordered" 
        id="trf_airkotor"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Tarif (Rp.)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i= 1; ?>
            @foreach($airkotor as $data)
            <tr>
                <td class="text-center">{{$i}}</td>
                <td>{{number_format($data->tarif)}}</td>
                <td class="text-center">
                    <form action="{{url('utilities/tarif/update',['airkotor',$data->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit fa-sm"></i></button>
                    </form>
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
            '#trf_airkotor'
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
                    title: 'Tarif Air Kotor',
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ]
        });
    });
</script>