@php

    use App\Components\Html;
    use App\Constants\LayananConstant;
    use App\Http\Controllers\LayananController;use App\Models\Layanan;
    use App\Models\StandarLayanan;

    /**
     * @var Layanan $model
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var \Illuminate\Support\Collection<\App\Models\RefLayananKomponen> $allRefLayananKomponen
     * @var \Illuminate\Support\Collection<StandarLayanan> $allStandarLayanan
     * @var array<int,string> $groupLabels
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

            <?= Html::a('<i class="fa fa-list"></i> Daftar Layanan', route(LayananConstant::RouteIndex), [
                'class' => 'btn btn-warning'
            ]) ?>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Identitas Layanan
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Jenis Layanan</th>
                    <td>
                        <?= @$model->layananProduk?->nama; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Pengguna Layanan</th>
                    <td>
                        <?= @$model->layananPenerimaManfaat?->nama; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Jumlah Pengguna</th>
                    <td>
                        <?= @$model->jumlah_pengguna; ?> Pengguna Per Tahun
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah', route(LayananController::ROUTE_UPDATE_IDENTITAS, ['id' => $model->id]), [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Standar Pelayanan
            </h3>
        </div>
        <div class="card-body">
            @foreach ($groupLabels as $grupValue => $groupLabel)
                @php
                    $allRefLayananKomponenByGroup = $allRefLayananKomponen
                        ->where('grup', $grupValue)
                        ->sortBy('urutan');
                @endphp

                <h6 class="font-weight-bold">{{ $groupLabel }}</h6>

                @include('layanan._table-layanan-komponen', [
                    'model' => $model,
                    'allRefLayananKomponen' => $allRefLayananKomponenByGroup,
                    'allLayananKomponen' => $allLayananKomponen,
                ])

                @if (!$loop->last)
                    <br/>
                @endif
            @endforeach
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Survei Kepuasan Masyarakat (SKM)
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Dilakukan SKM?</th>
                    <td>
                        <?= $model->status_skm === 1 ? "Ya" : "" ?>
                        <?= $model->status_skm === 0 ? "Tidak" : "" ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Nilai SKM Terakhir</th>
                    <td>
                        <?= @$model->nilai_skm; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah', route(LayananController::ROUTE_UPDATE_SKM, ['id' => $model->id]), [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Digitalisasi dan Inovasi
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Status Digitalisasi</th>
                    <td>
                        <?= $model->status_digitalisasi == 1 ? "Manual" : "" ?>
                        <?= $model->status_digitalisasi == 2 ? "Semi Digital" : "" ?>
                        <?= $model->status_digitalisasi == 3 ? "Full Online" : "" ?>

                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Nama Aplikasi</th>
                    <td>
                        <?= @$model->nama_aplikasi; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Link Aplikasi</th>
                    <td>
                        <?= @$model->link_aplikasi; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Apakah Ada Inovasi?</th>
                    <td>
                        <?= $model->status_inovasi === 1 ? "Ada" : "" ?>
                        <?= $model->status_inovasi === 0 ? "Tidak Ada" : "" ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Deskripsi Inovasi</th>
                    <td>
                        <?= $model->deskripsi_inovasi ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah', route(LayananController::ROUTE_UPDATE_DIGITALISASI_INOVASI, ['id' => $model->id]), [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>
    </div>

@endsection