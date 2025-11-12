<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Nama Layanan
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Perangkat Daerah</th>
                <td>{{ $model->instansi?->nama }}</td>
            </tr>
            <tr>
                <th style="width:200px;">Nama Layanan</th>
                <td>{{ $model->nama }}</td>
            </tr>
            <tr>
                <th style="width:200px;">Deskripsi Layanan</th>
                <td>{{ $model->deskripsi }}</td>
            </tr>
            <tr>
                <th style="width:200px;">Persen Pengisian</th>
                <td>{{ $model->persen_komponen }}%</td>
            </tr>

        </table>
    </div>
</div>