@php
    use App\Components\Html;
    use App\Constants\LayananConstant;
    use App\Models\Layanan;

    $breadcrumbs[] = ['label' => 'Layanan', 'url' => route(LayananConstant::RouteIndex)];
    $breadcrumbs[] = 'Detail Layanan';

    /** 
     * @var Layanan $model
     * @var array $listGrup
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var \Illuminate\Support\Collection<\App\Models\RefLayananKomponen> $allRefLayananKomponen
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

@foreach ($listGrup as $data)
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                {{ $data['nama'] }}
            </h3>
        </div>
        <div class="card-body">
            @foreach ($data['sub'] as $subGrup => $judul)
                @php
                    $allRefLayananKomponen1 = $allRefLayananKomponen
                        ->where('grup', $subGrup)
                        ->sortBy('urutan');
                @endphp
            
                {{ $judul }}

                @include('layanan._table-layanan-komponen', [
                    'model' => $model,
                    'allRefLayananKomponen' => $allRefLayananKomponen1,
                    'allLayananKomponen' => $allLayananKomponen
                ])

                <br/>
            @endforeach  
        </div>
    </div>
@endforeach

@endsection
