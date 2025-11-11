@php
    use App\Components\Html;
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = 'Daftar Perangkat Daerah';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Perangkat Daerah')

@section('content')

    @include('instansi._filter')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Perangkat Daerah</h3>
        </div>

        <div class="card-body">

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Perangkat Daerah</th>
                            <th style="width:70px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $allInstansi->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $instansi->nama }}</td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-edit"></i>',  route(StandarPelayananController::ROUTE_VIEW,[
                                        'id' => @$standarPelayanan->id,
                                ]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
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