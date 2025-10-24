@php
    use App\Components\Html;
    use App\Models\Instansi;
    use App\Constants\InstansiConstant;

    $breadcrumbs[] = ['label' => 'Perangkat Daerah', 'url' => route(InstansiConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Perangkat Daerah';

    /**
     * @var Instansi $model
     **/
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail Perangkat Daerah')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            Detail Perangkat Daerah
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px">Nama Perangkat Daerah</th>
                <td>{{ $model->nama }}</td>
            </tr>
            <tr>
                <th>Jenis</th>
                <td>{{ @$model->instansiJenis->nama }}</td>
            </tr>
            <tr>
                <th>Tahun Awal</th>
                <td>{{ $model->tahun_awal }}</td>
            </tr>
            <tr>
                <th>Tahun Akhir</th>
                <td>{{ $model->tahun_akhir }}</td>
            </tr>
            
        </table>
    </div>
    <div class="card-footer">
        <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah Perangkat Daerah', route(InstansiConstant::RouteUpdate,['id' => $model->id]), [
            'class' => 'btn btn-success'
        ]) ?>

        <?= Html::a('<i class="fa fa-list"></i> Daftar Perangkat Daerah', route(InstansiConstant::RouteIndex), [
            'class' => 'btn btn-warning'
        ]) ?>
    </div>
</div>

@include('instansi._card-instansi-kontak')
@endsection