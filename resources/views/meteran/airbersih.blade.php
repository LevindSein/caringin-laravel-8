<div class="table-responsive">
    <table 
        class="table table-bordered" 
        id="alat_air"
        cellspacing="0"
        width="100%"
        style="font-size:0.75rem;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nomor</th>
                <th>Stand</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i= 1; ?>
            @foreach($airbersih as $data)
            <?php 
            $kontrol = DB::table('tempat_usaha')
            ->where('tempat_usaha.id_meteran_air',$data->id)
            ->select('kd_kontrol')
            ->first();
            
            if($kontrol == NULL){
                $kontrol = 'idle';
            }
            else{
                $kontrol = $kontrol->kd_kontrol;
            }
            ?>
            <tr>
                <td class="text-center">{{$i}}</td>
                <td>{{$data->kode}}</td>
                <td>{{$data->nomor}}</td>
                <td>{{number_format($data->akhir)}}</td>
                <td class="text-center" style="{{ ($kontrol == 'idle') ? 'color:green;' : '' }}" >{{$kontrol}}</td>
                <td class="text-center">
                    <a
                        href="{{url('utilities/meteran/delete',['airbersih',$data->id])}}"
                        title="Hapus">
                        <i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>
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
            '#alat_air'
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
                    title: 'Daftar Alat Air Bersih',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    },
                    titleAttr: 'Download Excel'
                }
            ]
        });
    });
</script>