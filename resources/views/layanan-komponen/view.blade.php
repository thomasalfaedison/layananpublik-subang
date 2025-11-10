@php
    use App\Components\Html;
    use App\Constants\LayananKomponenConstant;
    use App\Models\LayananKomponen;

    $breadcrumbs[] = ['label' => 'Komponen Layanan', 'url' => route(LayananKomponenConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Komponen';

    /** @var LayananKomponen $model */
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail Komponen Layanan')

@section('content')
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Detail Komponen</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <tr>
                <th style="width:220px;">Layanan</th>
                <td>{{ $model->layanan?->nama }}</td>
            </tr>
            <tr>
                <th>Komponen</th>
                <td>{{ $model->refLayananKomponen?->nama }}</td>
            </tr>
            <tr>
                <th>Urutan</th>
                <td>{{ $model->urutan }}</td>
            </tr>
            <tr>
                <th>Uraian</th>
                <td>{!! nl2br(e($model->uraian)) !!}</td>
            </tr>
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah Komponen', route(LayananKomponenConstant::RouteUpdate, ['id' => $model->id]), [
            'class' => 'btn btn-success',
        ]) ?>

        <?= Html::a('<i class="fa fa-list"></i> Daftar Komponen', route(LayananKomponenConstant::RouteIndex), [
            'class' => 'btn btn-warning ml-2',
        ]) ?>
    </div>
</div>
@endsection

