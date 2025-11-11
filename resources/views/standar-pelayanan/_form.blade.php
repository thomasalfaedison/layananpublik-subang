@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\StandarPelayananController;

    /* @var $model \App\Models\StandarPelayanan */
    /* @var $referrer string */
    /* @var $action string */
    /* @var $listInstansi array */
@endphp

<form action="{{ $action }}" method="POST">
    @csrf

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Standar Pelayanan</h3>
        </div>

        <div class="card-body">
            <div class="row">
                @if (Session::isAdmin())
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('id_instansi', 'Perangkat Daerah', ['required' => true]) ?>
                            <?= Form::select('id_instansi', $listInstansi, old('id_instansi', $model->id_instansi), [
                                'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                                'placeholder' => '- Pilih Perangkat Daerah -',
                            ]) ?>
                            @error('id_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @else
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Form::label('instansi_label', 'Perangkat Daerah') ?>
                            <input type="text" class="form-control" value="{{ optional($model->instansi)->nama ?? optional(auth()->user())->instansi->nama }}" disabled>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('nomor', 'Nomor Keputusan') ?>
                        <?= Form::text('nomor', old('nomor', $model->nomor), [
                            'class' => 'form-control' . ($errors->has('nomor') ? ' is-invalid' : ''),
                            'placeholder' => 'Contoh: 188.4/1234/KPTS-B/2025',
                        ]) ?>
                        @error('nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('alamat', 'Alamat Kantor') ?>
                        <?= Form::textarea('alamat', old('alamat', $model->alamat), [
                            'class' => 'form-control' . ($errors->has('alamat') ? ' is-invalid' : ''),
                            'rows' => 3,
                            'placeholder' => 'Alamat yang akan ditampilkan',
                        ]) ?>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('jabatan_ttd', 'Jabatan Penandatangan') ?>
                        <?= Form::text('jabatan_ttd', old('jabatan_ttd', $model->jabatan_ttd), [
                            'class' => 'form-control' . ($errors->has('jabatan_ttd') ? ' is-invalid' : ''),
                            'placeholder' => 'Contoh: Kepala Dinas ...',
                        ]) ?>
                        @error('jabatan_ttd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('nama_ttd', 'Nama Penandatangan') ?>
                        <?= Form::text('nama_ttd', old('nama_ttd', $model->nama_ttd), [
                            'class' => 'form-control' . ($errors->has('nama_ttd') ? ' is-invalid' : ''),
                            'placeholder' => 'Nama lengkap sesuai jabatan',
                        ]) ?>
                        @error('nama_ttd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <?= Form::label('nip_ttd', 'NIP Penandatangan') ?>
                        <?= Form::text('nip_ttd', old('nip_ttd', $model->nip_ttd), [
                            'class' => 'form-control' . ($errors->has('nip_ttd') ? ' is-invalid' : ''),
                            'placeholder' => 'Cth: 197001011990011001',
                        ]) ?>
                        @error('nip_ttd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <?= Form::hidden('referrer', old('referrer', $referrer)) ?>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-check"></i> Simpan', [
                'class' => 'btn btn-success',
            ]) ?>
        </div>
    </div>
</form>
