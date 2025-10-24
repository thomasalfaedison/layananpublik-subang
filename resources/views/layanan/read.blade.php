@php
    use App\Components\Html;
    use App\Constants\LayananConstant;
    use App\Models\Layanan;

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Layanan';

    /** @var Layanan $model */
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail Layanan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            Detail Layanan
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:220px;">Perangkat Daerah</th>
                <td>{{ optional($model->instansi)->nama }}</td>
            </tr>
            <tr>
                <th>Nama Layanan</th>
                <td>{{ $model->nama }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{!! $model->deskripsi !!}</td>
            </tr>
            <tr>
                <th>Pemicu Layanan</th>
                <td>{{ optional($model->layananPemicu)->nama }}</td>
            </tr>
            <tr>
                <th>Teknis Layanan</th>
                <td>{{ optional($model->layananTeknis)->nama }}</td>
            </tr>
            <tr>
                <th>Penerima Manfaat</th>
                <td>{{ optional($model->layananPenerimaManfaat)->nama }}</td>
            </tr>
            <tr>
                <th>Produk Layanan</th>
                <td>{{ optional($model->layananProduk)->nama }}</td>
            </tr>
            <tr>
                <th>Status Persyaratan</th>
                <td>{{ $model->status_atribut_persyaratan ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <th>Status Prosedur</th>
                <td>{{ $model->status_atribut_prosedur ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <th>Biaya Layanan</th>
                <td>{{ optional($model->atributBiaya)->nama }}</td>
            </tr>
            <tr>
                <th>Kategori Atribut</th>
                <td>{{ $model->atribut_kategori }}</td>
            </tr>
            <tr>
                <th>SOP Layanan</th>
                <td>{{ optional($model->atributSop)->nama }}</td>
            </tr>
            <tr>
                <th>Siklus Layanan</th>
                <td>{{ optional($model->atributSiklusLayanan)->nama }}</td>
            </tr>
            <tr>
                <th>Atribut SKM</th>
                <td>{{ optional($model->atributSkm)->nama }}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah Layanan', route(LayananConstant::RouteUpdate, ['id' => $model->id]), [
            'class' => 'btn btn-success'
        ]) ?>

        <?= Html::a('<i class="fa fa-list"></i> Daftar Layanan', route(LayananConstant::RouteIndex), [
            'class' => 'btn btn-warning'
        ]) ?>
    </div>
</div>
@endsection

