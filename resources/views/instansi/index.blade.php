@php
    use App\Components\Html;
    use App\Constants\InstansiConstant;

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

            <div class="mb-3">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah Perangkat Daerah', route(InstansiConstant::RouteCreate), [
                    'class' => 'btn btn-success',
                ]) ?>
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th>Perangkat Daerah</th>
                            <th style="text-align: center;">Singkatan</th>
                            <th style="width:200px; text-align: center;">Jenis</th>
                            <th style="width:120px; text-align: center;">Tahun Awal</th>
                            <th style="width:120px; text-align: center;">Tahun Akhir</th>
                            <th style="width:80px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allInstansi as $instansi)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $allInstansi->firstItem() + $loop->index }}
                                </td>
                                <td>{{ $instansi->nama }}</td>
                                <td style="text-align: center;">{{ $instansi->singkatan }}</td>
                                <td style="text-align: center;">
                                    {{ optional($instansi->instansiJenis)->nama }}
                                </td>
                                <td style="text-align: center;">{{ $instansi->tahun_awal }}</td>
                                <td style="text-align: center;">{{ $instansi->tahun_akhir }}</td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>',  route(InstansiConstant::RouteRead,['id' => $instansi->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>',  route(InstansiConstant::RouteUpdate,['id' => $instansi->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-trash"></i>',  route(InstansiConstant::RouteDelete,['id' => $instansi->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?'
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