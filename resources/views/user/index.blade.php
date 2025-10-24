@php
    use App\Constants\UserConstant;
    use App\Components\Html;

    $breadcrumbs[] = 'Daftar User '.$namaRole;

    $colspan = 4;
    if ($id_role == UserConstant::ROLE_INSTANSI) { $colspan++; }
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Daftar User '.$namaRole)

@section('content')

    @include('user._filter')

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar User {{ $namaRole }}</h3>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <?= Html::a('<i class="fa fa-plus"></i> Tambah User',  route(UserConstant::RouteCreate,['id_role' => $id_role]), [
                    'class' => 'btn btn-success',
                ]) ?>

                <?= Html::a('<i class="fa fa-file-excel"></i> Cetak Excel User', route(UserConstant::RouteExportExcel,request()->query()), [
                    'class' => 'btn btn-success',
                ]) ?>

                @if ($id_role == UserConstant::ROLE_INSTANSI)
                    <?= Html::a('<i class="fa fa-sync"></i> Reset Password Default', route(UserConstant::RouteResetPasswordDefaultAll), [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Semua password perangkat daerah akan direset ke: subangkab2025. Lanjutkan?',
                        'data-method' => 'post'
                    ]) ?>
                @endif
            </div>

            <div style="overflow: auto">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:60px; text-align:center">No</th>
                            <th style="text-align:center">Username</th>
                            @if ($id_role == UserConstant::ROLE_INSTANSI)
                                <th style="width:300px; text-align:center">Nama Instansi</th>
                            @endif
                            <th style="width:50px; text-align:center"></th>
                            <th style="width:80px; text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allUser as $user)
                            <tr>
                                <td class="text-center">{{ $allUser->firstItem() + $loop->index }}</td>
                                <td>{{ $user->username }}</td>
                                @if ($id_role == UserConstant::ROLE_INSTANSI)
                                    <td>{{ optional($user->instansi)->nama }}</td>
                                @endif
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-lock"></i>',  route(UserConstant::RouteSetPassword,['id' => $user->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Set Password',
                                    ]) ?>
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-eye"></i>',  route(UserConstant::RouteRead,['id' => $user->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Lihat',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-pencil-alt"></i>',  route(UserConstant::RouteUpdate,['id' => $user->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Ubah',
                                    ]) ?>

                                    <?= Html::a('<i class="fa fa-trash"></i>',  route(UserConstant::RouteDelete,['id' => $user->id]), [
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Hapus',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Yakin ingin menghapus data?'
                                    ]) ?>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspan }}" class="text-center">
                                    Data User tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                {{ $allUser->links() }}
            </div>

        </div>
    </div>

@endsection
