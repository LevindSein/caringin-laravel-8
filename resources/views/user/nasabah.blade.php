<div class="table-responsive">
    <table 
        class="table table-bordered" 
        id="userNasabah"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Nama</th>
                <th>KTP</th>
                <th>HP</th>
                <th>Email</th>
                <th>Anggota</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i= 1; ?>
            @foreach($nasabah as $data)
            <tr>
                <td class="text-center">{{$i}}</td>
                <td class="text-center">{{$data->username}}</td>
                <td class="text-center">{{$data->nama}}</td>
                <td class="text-center">{{$data->ktp}}</td>
                <td class="text-center">{{$data->hp}}</td>
                <td class="text-center">{{$data->email}}</td>
                <td class="text-center">{{$data->anggota}}</td>
                <td class="text-center">
                    <a
                        href="{{url('user/reset',[$data->id])}}"
                        title="Reset Password">
                        <i class="fas fa-key fa-sm" style="color:orange;"></i></a>
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
            '#userNasabah'
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
                    title: 'Data Nasabah {{$sekarang}}',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    },
                    titleAttr: 'Download Excel'
                }
            ],
            "fixedColumns":   {
                "leftColumns": 3,
                "rightColumns": 1,
            },
        });
    });
</script>