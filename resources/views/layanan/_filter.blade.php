@php
    use App\Components\Html;
    use App\Components\Session;
    use App\Constants\LayananConstant;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= Form::label('nama', 'Nama Layanan') ?>
                    <?= Form::text('nama', request()->query('nama'), [
                        'class' => 'form-control',
                        'placeholder' => 'Nama layanan',
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
                <div class="col-sm-4">
                    <?= Form::label('urutan_persen_kelengkapan', 'Urutan Kelengkapan') ?>
                    <?= Form::select(
                        'urutan_persen_kelengkapan',
                        [
                            'desc' => 'Tertinggi ke Terendah',
                            'asc' => 'Terendah ke Tertinggi',
                        ],
                        request()->query('urutan_persen_kelengkapan'),
                        [
                            'class' => 'form-control',
                            'placeholder' => '- Pilih Urutan -',
                        ]
                    ) ?>
                </div>

                @if (request()->has('latex'))
                    <?= Form::hidden('latex', request()->query('latex')) ?>
                @endif
            </div>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-search"></i> Filter Data', [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::a('<i class="fa fa-sync"></i> Reset', route(LayananConstant::RouteIndex), [
                'class' => 'btn btn-warning ml-2',
            ]) ?>
        </div>
    </div>
</form>
