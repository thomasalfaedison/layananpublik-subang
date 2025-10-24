@php
    use App\Components\Html;
    use App\Constants\InstansiConstant;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-sm-5">
                    <?= Form::text('nama', request()->query('nama'), [
                        'class' => 'form-control',
                        'placeholder' => 'Nama Perangkat Daerah'
                    ]) ?>
                </div>

                <div class="col-sm">
                    <?= Html::submit('<i class="fa fa-search"></i> Filter', [
                        'class' => 'btn btn-success',
                    ]) ?>

                    <?= Html::tag('button', '<i class="fa fa-sync"></i> Reset', [
                        'type' => 'reset',
                        'id' => 'btnReset',
                        'class' => 'btn btn-warning',
                    ]) ?>
                </div>
            </div>
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
