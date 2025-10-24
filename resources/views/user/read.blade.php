@php
    use App\Models\User;
    use App\Constants\UserConstant;
    use App\Components\Html;

    $breadcrumbs[] = ['label' => 'User', 'url' => route(UserConstant::RouteIndex,['id_role' => $model->id_role])];
    $breadcrumbs[] = 'Detail User';

    /**
     * @var User $model
     **/
@endphp

@extends(LayoutConstant::MAIN_LAYOUT)

@section('title', 'Detail User')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Detail User
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px">Role</th>
                    <td>{{ $listUserRole[$model->id_role] }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $model->username }}</td>
                </tr>
                @if ($model->id_role == UserConstant::ROLE_INSTANSI)
                    <tr>
                        <th>Perangkat Daerah</th>
                        <td>{{ @$model->instansi->nama }}</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <?= Html::a('<i class="fa fa-pencil-alt"></i> Ubah User', route(UserConstant::RouteUpdate,['id' => $model->id]), [
                'class' => 'btn btn-success'
            ]) ?>

            <?= Html::a('<i class="fa fa-list"></i> Daftar User', route(UserConstant::RouteIndex, ['id_role' => $model->id_role]), [
                'class' => 'btn btn-warning'
            ]) ?>
        </div>
    </div>

@endsection