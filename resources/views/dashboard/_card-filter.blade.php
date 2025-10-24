@php
    use App\Components\Html;
    use App\Components\Session;
@endphp

<form action="{{ request()->url() }}" method="GET">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-sm-3">
                    <?= Form::number('tahun', request()->query('tahun', Session::getTahun()), [
                        'class' => 'form-control',
                        'placeholder' => 'Tahun'
                    ]) ?>
                </div>

                <div class="col-sm">
                    <?= Html::submit('<i class="fa fa-search"></i> Filter', [
                        'class' => 'btn btn-success',
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
