@php
    use App\Components\Html;
    use App\Constants\LayananKomponenConstant;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= Form::label('id_layanan', 'Layanan') ?>
                    <?= Form::select('id_layanan', $listLayanan, request()->query('id_layanan'), [
                        'class' => 'form-control select2-field',
                        'placeholder' => '- Pilih Layanan -',
                    ]) ?>
                </div>
                <div class="col-sm-4">
                    <?= Form::label('id_ref_layanan_komponen', 'Komponen') ?>
                    <?= Form::select('id_ref_layanan_komponen', $listRefLayananKomponen, request()->query('id_ref_layanan_komponen'), [
                        'class' => 'form-control select2-field',
                        'placeholder' => '- Pilih Komponen -',
                    ]) ?>
                </div>
                <div class="col-sm-4">
                    <?= Form::label('keyword', 'Kata Kunci Uraian') ?>
                    <?= Form::text('keyword', request()->query('keyword'), [
                        'class' => 'form-control',
                        'placeholder' => 'Cari uraian',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-search"></i> Filter Data', [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::a('<i class="fa fa-sync"></i> Reset', route(LayananKomponenConstant::RouteIndex), [
                'class' => 'btn btn-warning ml-2',
            ]) ?>
        </div>
    </div>
</form>

