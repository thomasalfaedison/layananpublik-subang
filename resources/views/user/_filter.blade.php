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

                <div class="col-sm-6">
                    <?= Form::label('username', 'Username') ?>
                    <?= Form::text('username', request()->query('username'), [
                        'class' => 'form-control',
                        'placeholder' => 'Username'
                    ]) ?>
                </div>

                <?= Form::hidden('id_role', request()->query('id_role'), [
                    'id' => 'id_role',
                ]) ?>

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
            // Reset semua input di form
            const form = this.closest('form');
            form.reset();

            // Hapus query string dari URL
            const id_role = form.querySelector('#id_role').value;
            const baseUrl = window.location.origin + window.location.pathname;
            const newUrl = baseUrl + '?id_role=' + id_role;
            window.location.href = newUrl;
        });
    });
</script>