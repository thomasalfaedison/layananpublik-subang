@php
    use App\Components\Html;
    use App\Constants\UserConstant;

    $breadcrumbs[] = 'Ganti Password';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Ganti Password')
    
@section('content')

<form action="{{ route(UserConstant::RouteChangePasswordProcess) }}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Ganti Password</h3>
        </div>

        <div class="card-body">

            <div class="form-group col-sm-6">
                <?= Form::label('password_lama', 'Password Lama', ['required' => true]) ?>
                <?= Form::password('password_lama', [
                    'class' => 'form-control' . ($errors->has('password_lama') ? ' is-invalid' : ''),
                    'placeholder' => 'Password Lama'
                ]) ?>
                @error('password_lama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <?= Form::label('password_baru', 'Password Baru', ['required' => true]) ?>
                <?= Form::password('password_baru', [
                    'class' => 'form-control' . ($errors->has('password_baru') ? ' is-invalid' : ''),
                    'placeholder' => 'Password Baru'
                ]) ?>
                @error('password_baru')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-sm-6">
                <?= Form::label('password_baru_confirmation', 'Konfirmasi Password Baru') ?>
                <?= Form::password('password_baru_confirmation', [
                    'class' => 'form-control' . ($errors->has('password_baru_confirmation') ? ' is-invalid' : ''),
                    'placeholder' => 'Konfirmasi Password Baru'
                ]) ?>
                @error('password_baru_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

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

@endsection