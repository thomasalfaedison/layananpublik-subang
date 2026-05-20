@php
    use App\Components\Html;
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = 'Standar Pelayanan';

    /** 
     * @var \App\Models\StandarPelayanan $model
     */
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Standar Pelayanan')

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Standar Pelayanan
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px;">Perangkat Daerah</th>
                <td>{{ $model->instansi?->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Keputusan</th>
                <td>{{ $model->nomor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat Kantor</th>
                <td>
                    @if ($model->alamat)
                        {!! nl2br(e($model->alamat)) !!}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jabatan Penandatangan</th>
                <td>{{ $model->jabatan_ttd ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Penandatangan</th>
                <td>{{ $model->nama_ttd ?? '-' }}</td>
            </tr>
            <tr>
                <th>NIP Penandatangan</th>
                <td>{{ $model->nip_ttd ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah', route(StandarPelayananController::ROUTE_UPDATE, ['id' => $model->id]), [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('<i class="fa fa-file-pdf"></i> Cek PDF SK', route(StandarPelayananController::ROUTE_EXPORT_PDF, [
            'id_instansi' => $model->id_instansi,
        ]), [
            'class' => 'btn btn-danger ml-2',
            'target' => '_blank',
        ]) ?>
    </div>
</div>

@endsection
