@php
    /**
     * @var \App\Models\Layanan $model
     */
@endphp

<table class="table table-bordered mb-4">
    <tr>
        <th style="width: 200px">Perangkat Daerah</th>
        <td>{{ $model->instansi?->nama }}</td>
    </tr>
    <tr>
        <th>Nama Layanan</th>
        <td>{{ $model->nama }}</td>
    </tr>
    <tr>
        <th>Deskripsi Layanan</th>
        <td>{{ $model->deskripsi }}</td>
    </tr>
</table>