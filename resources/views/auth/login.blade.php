@extends(LayoutConstant::AUTH_LAYOUT)

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <br>
        <div class="login-logo" style="margin-bottom: 30px">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kabupaten Subang" style="height: 100px; width: auto;">
            <p style="color: white; font-size: 24px; margin: 5px 0">
                <b>Layanan Publik<br/>Kabupaten Subang</b>
            </p>
        </div>

        <div class="login-card-body">
            <p class="login-box-msg">Masukkan Username Dan Password</p>

            <form action="{{ url('/login') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" placeholder="Username" name="username" value="{{ old('username') }}" autocomplete="username" autofocus />
                    @if ($errors->has('username'))
                        <div class="invalid-feedback">
                            {{ $errors->first('username') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password" name="password" autocomplete="current-password" />
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif

                    @if (session('danger'))
                        <small class="text-danger d-block mt-1">{{ session('danger') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <input type="number" class="form-control {{ $errors->has('tahun') ? 'is-invalid' : '' }}" placeholder="Tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" />
                    @if ($errors->has('tahun'))
                        <div class="invalid-feedback">
                            {{ $errors->first('tahun') }}
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-12" style="padding-left: 10px">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-lock"></i> Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection