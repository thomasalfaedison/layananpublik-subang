@php
    use App\Components\Html;
    use App\Constants\InstansiKontakConstant;
@endphp

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Daftar Kontak Person</h3>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <?= Html::a('<i class="fa fa-plus"></i> Tambah Kontak Person', route(InstansiKontakConstant::RouteCreate, [
                'id_instansi' => $model->id,
            ]), [
                'class' => 'btn btn-success',
            ]) ?>
        </div>

        <div style="overflow: auto">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width:60px; text-align:center">No</th>
                        <th style="width:300px;">Perangkat Daerah</th>
                        <th>Nama</th>
                        <th style="width: 150px;">No HP</th>
                        <th style="width: 250px;">Email</th>
                        <th style="width:80px; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listInstansiKontak as $kontak)
                        <tr>
                            <td style="text-align: center;">
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ optional($kontak->instansi)->nama }}</td>
                            <td>{{ $kontak->nama }}</td>
                            <td>{{ $kontak->no_hp }}</td>
                            <td>{{ $kontak->email }}</td>
                            <td class="text-center">
                                <?= Html::a('<i class="fa fa-eye"></i>',  route(InstansiKontakConstant::RouteRead, ['id' => $kontak->id]), [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Lihat',
                                ]) ?>

                                <?= Html::a('<i class="fa fa-pencil-alt"></i>',  route(InstansiKontakConstant::RouteUpdate, ['id' => $kontak->id]), [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Ubah',
                                ]) ?>

                                <?= Html::a('<i class="fa fa-trash"></i>',  route(InstansiKontakConstant::RouteDelete, ['id' => $kontak->id]), [
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Hapus',
                                    'data-method' => 'POST',
                                    'data-confirm' => 'Yakin ingin menghapus data?',
                                ]) ?>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Data Kontak Person tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>