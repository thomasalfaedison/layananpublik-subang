@php
    use App\Components\Html;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= Form::label('nama', 'Perangkat Daerah') ?>
                    <?= Form::text('nama', request()->query('nama'), [
                        'class' => 'form-control',
                        'placeholder' => 'Nama Perangkat Daerah'
                    ]) ?>
                </div>
                @if (isset($tahun))
                    <div class="col-sm-2">
                        <?= Form::label('tahun', 'Tahun Dokumen') ?>
                        <?= Form::number('tahun', $tahun, [
                            'class' => 'form-control',
                            'min' => 1901,
                            'max' => 2155,
                        ]) ?>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <?= Html::submit('<i class="fa fa-search"></i> Filter Data', [
                'class' => 'btn btn-success',
            ]) ?>

            <?= Html::tag('button', '<i class="fa fa-sync"></i> Reset', [
                'type' => 'reset',
                'id' => 'btnReset',
                'class' => 'btn btn-warning',
            ]) ?>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resetBtn = document.getElementById('btnReset');
        resetBtn.addEventListener('click', function () {
            const form = this.closest('form');
            // form.reset();

            window.location.href = window.location.pathname;
        });
    });
</script>
