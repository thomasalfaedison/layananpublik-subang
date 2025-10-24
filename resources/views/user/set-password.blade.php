@php
    use App\Components\Html;
    use App\Constants\UserConstant;

    $breadcrumbs[] = ['label' => 'User', 'url' => route(UserConstant::RouteIndex,['id_role' => $model->id_role])];
    $breadcrumbs[] = 'Atur Ulang Password';
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Atur Ulang Password')
    
@section('content')

<form action="{{ route(UserConstant::RouteSetPasswordProcess,['id' => $model->id]) }}" method="POST">
    @csrf
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form Reset Password</h3>
        </div>

        <div class="card-body">

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

            <div class="form-group col-sm-6">
                <?= Form::label('password_confirmation', 'Konfirmasi Password', ['required' => true]) ?>
                <?= Form::password('password_confirmation', [
                    'class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : ''),
                    'placeholder' => 'Konfirmasi password'
                ]) ?>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="referrer" value="{{ old('referrer', $referrer) }}">

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