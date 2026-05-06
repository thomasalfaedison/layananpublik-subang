@php
    /**
     * @see \App\Livewire\Layanan\SurveiKepuasanMasyarat::render()
     * @see \App\Http\Controllers\LayananController::viewV2()
     * @var \App\Models\Layanan $model
     * @var \App\Livewire\Form\LayananSkmForm $form
     */
@endphp

<div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Survei Kepuasan Masyarakat (SKM)
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Dilakukan SKM?</th>
                    <td>
                        <?= $model->status_skm === 1 ? "Ya" : "" ?>
                        <?= $model->status_skm === 0 ? "Tidak" : "" ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Nilai SKM Terakhir</th>
                    <td>
                        <?= @$model->nilai_skm; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" wire:click="openEditModal">
                <i class="fa fa-pencil-alt"></i> Ubah
            </button>
        </div>
    </div>

    @include('livewire.layanan.partials.modal-survei-kepuasan-masyarat')
</div>
