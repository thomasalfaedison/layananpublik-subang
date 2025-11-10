@php
    use App\Components\Html;
    use App\Constants\LayananKomponenConstant;
    use Illuminate\Support\Str;

    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\LayananKomponen> $allLayananKomponen
     */

    $breadcrumbs[] = 'Komponen Layanan';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Komponen Layanan')

@section('content')
    @include('layanan-komponen._filter')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Komponen Layanan</h3>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Komponen', route(LayananKomponenConstant::RouteCreate), [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th style="width:220px;">Layanan</th>
                            <th style="width:220px;">Komponen</th>
                            <th style="width:80px; text-align:center">Urutan</th>
                            <th>Uraian</th>
                            <th style="width:90px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allLayananKomponen as $komponen)
                            <tr>
                                <td class="text-center">
                                    {{ $allLayananKomponen->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $komponen->layanan?->nama }}</td>
                                <td>{{ $komponen->refLayananKomponen?->nama }}</td>
                                <td class="text-center">{{ $komponen->urutan }}</td>
                                <td>{{ Str::limit(strip_tags($komponen->uraian), 120) }}</td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>', route(LayananKomponenConstant::RouteView, ['id' => $komponen->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>', route(LayananKomponenConstant::RouteUpdate, ['id' => $komponen->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah',
                                        'class' => 'ml-1',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-trash"></i>', route(LayananKomponenConstant::RouteDelete, ['id' => $komponen->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?',
                                        'class' => 'ml-1 text-danger',
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data komponen layanan tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allLayananKomponen->links() }}
            </div>
        </div>
    </div>
@endsection

