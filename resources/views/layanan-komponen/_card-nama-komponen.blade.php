@php
    /**
     * @var \App\Models\LayananKomponen $model
     **/
@endphp

<div class="card card-default">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Perangkat Daerah</th>
                <td>{{ @$model->layanan?->instansi?->nama }}</td>
            </tr>
            <tr>
                <th style="width:200px;">Nama Layanan</th>
                <td>{{ @$model->layanan?->nama }}</td>
            </tr>
            <tr>
                <th style="width:200px;">Deskripsi Layanan</th>
                <td>{{ $model->layanan?->deskripsi }}</td>
            </tr>
        </table>
    </div>
</div>