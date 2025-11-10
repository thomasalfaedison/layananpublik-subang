@php
    use App\Components\Html;
    use App\Constants\LayananConstant;
    use App\Models\Layanan;
    use App\Models\StandarLayanan;

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Layanan';

    /** 
     * @var Layanan $model
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var \Illuminate\Support\Collection<\App\Models\RefLayananKomponen> $allRefLayananKomponen
     * @var \Illuminate\Support\Collection<StandarLayanan> $allStandarLayanan
     * @var array<int,string> $groupLabels
     */
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail Layanan')

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">
            Detail Layanan
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width:200px;">Nama Layanan</th>
                <td>{{ $model->nama }}</td>
            </tr>
            <tr>
                <th>Perangkat Daerah</th>
                <td>{{ $model->instansi?->nama }}</td>
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

@forelse ($allStandarLayanan as $standarLayanan)
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{ $standarLayanan->nama }}
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
                    'id_standar_layanan' => $standarLayanan->id,
                ])

                @if (!$loop->last)
                    <br/>
                @endif
            @endforeach
        </div>
    </div>
@empty
    <div class="alert alert-info">
        Data standar layanan belum tersedia.
    </div>
@endforelse

@endsection
