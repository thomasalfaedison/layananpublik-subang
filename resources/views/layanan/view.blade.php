@php

    use App\Components\Html;
    use App\Constants\LayananConstant;
    use App\Http\Controllers\LayananController;
    use App\Models\Layanan;

    /**
     * @var Layanan $model
     */

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Layanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail Layanan')

@section('content')

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
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah Layanan', route(LayananConstant::RouteUpdate, ['id' => $model->id]), [
                'class' => 'btn btn-primary'
            ]) ?>

            <?= Html::a('<i class="fa fa-file-pdf"></i> Export PDF', route(LayananConstant::RouteExportPdf, ['id' => $model->id]), [
                'class' => 'btn btn-danger',
                'target' => '_blank',
            ]) ?>

            <?= Html::a('<i class="fa fa-list"></i> Daftar Layanan', route(LayananConstant::RouteIndex), [
                'class' => 'btn btn-warning'
            ]) ?>
        </div>
    </div>

    @livewire('layanan.identitas-layanan', [
        'model' => $model,
    ])

    @livewire('layanan.standar-pelayanan', [
        'model' => $model,
    ])

    @livewire('layanan.survei-kepuasan-masyarat', [
        'model' => $model,
    ])

    @livewire('layanan.digitalisasi-inovasi', [
        'model' => $model,
    ])

@endsection
