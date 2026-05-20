@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\StandarPelayananController;

    $breadcrumbs[] = 'Daftar Maklumat Pelayanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar Maklumat Pelayanan')

@section('content')

    @if (Session::isAdmin())
        @include('instansi._filter')
    @endif

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
                            <th>Nomor SK</th>
                            <th style="width:120px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $allInstansi->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $instansi->nama }}</td>
                                <td>{{ $instansi->standarPelayanan->nomor ?? '-' }}</td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-file-word"></i> Export Word', route(StandarPelayananController::ROUTE_EXPORT_WORD_MAKLUMAT_PELAYANAN, [
                                        'id_instansi' => $instansi->id,
                                    ]), [
                                        'class' => 'btn btn-primary btn-xs',
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
