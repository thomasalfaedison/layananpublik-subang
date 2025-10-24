@php
    use App\Components\Html;
    use App\Constants\UserConstant;
    use App\Services\InstansiService;
@endphp

<form action="{{ $action }}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form User</h3>
        </div>

        <div class="card-body">

            <div class="form-group col-sm-6">
                <?= Form::label('id_role', 'Role') ?>
                <?= Form::select('id_role', $listUserRole,  old('id_role', $model->id_role), [
                    'class' => 'form-control' . ($errors->has('id_role') ? ' is-invalid' : ''),
                    'placeholder' => '- Pilih Jenis -',
                    'disabled' => true,
                ]) ?>
                @error('id_role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($model->id_role == UserConstant::ROLE_INSTANSI)
                <div class="form-group col-sm-6">
                    <?= Form::label('id_instansi', 'Perangkat Daerah', ['required' => true]) ?>
                    <?= Form::select('id_instansi', $listInstansi,  old('id_instansi', $model->id_instansi), [
                        'class' => 'form-control select2-field' . ($errors->has('id_instansi') ? ' is-invalid' : ''),
                        'placeholder' => '- Pilih Perangkat Daerah -'
                    ]) ?>
                    @error('id_instansi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="form-group col-sm-6">
                <?= Form::label('username', 'Username', ['required' => true]) ?>
                <?= Form::text('username', old('username', $model->username), [
                    'class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''),
                    'placeholder' => 'Username'
                ]) ?>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if (!$model->exists)    
                <div class="form-group col-sm-6">
                    <?= Form::label('password', 'Password', ['required' => true]) ?>
                    <?= Form::password('password', [
                        'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                        'placeholder' => 'Password'
                    ]) ?>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            
            <?= Form::hidden('referrer', old('referrer', $referrer)) ?>

        </div>

        <div class="card-footer">
            <div class="col-sm-offset-2 col-sm-3">
                <?= Html::submit('<i class="fa fa-check"></i> Simpan', [
                    'class' => 'btn btn-success'
                ]) ?>
            </div>
        </div>

    </div>
</form>