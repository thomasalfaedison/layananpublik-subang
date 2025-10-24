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

<div class="row">
    <div class="col-lg-6 col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fa fa-info-circle"></i> Identitas Layanan
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th style="width:200px;">Perangkat Daerah</th>
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
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fa fa-tags"></i> Ciri Layanan
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th style="width:200px;">Pemicu Layanan</th>
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
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-12">
        <div class="card card-default">
            <div class="card-header d-flex flex-column flex-md-row align-items-md-center">
                <h3 class="card-title mb-0">
                    <i class="fa fa-list-alt"></i> Atribut Layanan
                </h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th style="width:220px;">Persyaratan</th>
                        <td>
                            <span class="badge badge-{{ $model->status_atribut_persyaratan ? 'success' : 'secondary' }}">
                                {{ $model->status_atribut_persyaratan ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Prosedur</th>
                        <td>
                            <span class="badge badge-{{ $model->status_atribut_prosedur ? 'success' : 'secondary' }}">
                                {{ $model->status_atribut_prosedur ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Biaya Layanan</th>
                        <td>{{ optional($model->atributBiaya)->nama }}</td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
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
                        <th>SKM</th>
                        <td>{{ optional($model->atributSkm)->nama }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
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
