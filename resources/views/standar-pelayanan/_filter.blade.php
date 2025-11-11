@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Http\Controllers\StandarPelayananController;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= Form::label('keyword', 'Kata Kunci') ?>
                    <?= Form::text('keyword', request()->query('keyword'), [
                        'class' => 'form-control',
                        'placeholder' => 'Nomor SK / Pejabat Penandatangan',
                    ]) ?>
                </div>
                @if (Session::isAdmin())
                    <div class="col-sm-4">
                        <?= Form::label('id_instansi', 'Perangkat Daerah') ?>
                        <?= Form::select('id_instansi', $listInstansi, request()->query('id_instansi'), [
                            'class' => 'form-control select2-field',
                            'placeholder' => '- Pilih Perangkat Daerah -',
                        ]) ?>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-search"></i> Filter Data', [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::a('<i class="fa fa-sync"></i> Reset', route(StandarPelayananController::ROUTE_INDEX), [
                'class' => 'btn btn-warning ml-2',
            ]) ?>
        </div>
    </div>
</form>
