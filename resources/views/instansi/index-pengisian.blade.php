@php
    use App\Components\Html;
    use App\Components\Helper;
    use App\Constants\EvaluasiConstant;

    $breadcrumbs[] = "Pengisian Perangkat Daerah";
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', "Pengisian Perangkat Daerah")

@section('content')

    @include('instansi._card-filter-pengisian')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Perangkat Daerah</h3>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <?= Html::a('<i class="fa fa-file-excel"></i> Export Excel' , request()->fullUrlWithQuery(['export-excel' => 1]), [
                    'class' => 'btn btn-success'
                ]) ?>
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Perangkat Daerah</th>
                            <th style="width:100px; text-align:right;">Progres</th>
                            <th style="width:140px; text-align:center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $allInstansi->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    {!! Html::a($instansi->nama, route(EvaluasiConstant::RoutePengisianInstansi,[
                                        'id_instansi' => $instansi->id,
                                    ])) !!}
                                </td>
                                <td style="text-align: right;">
                                    {{ Helper::rp($instansi->kuesionerResponden?->persen_pengisian, 0, 2) }}%
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-edit"></i> Lihat Pengisian',  route(EvaluasiConstant::RoutePengisianInstansi,[
                                        'id_instansi' => $instansi->id,
                                    ]), [
                                        'class' => 'btn btn-success btn-xs',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data perangkat daerah tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allInstansi->links() }}
            </div>

        </div>
    </div>

@endsection