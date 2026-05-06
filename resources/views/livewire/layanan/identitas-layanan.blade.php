@php
    /**
     * @var \App\Models\Layanan $model
     * @var \App\Livewire\Form\IdentitasLayananForm $form
     * @var array<int,string> $listRefLayananProduk
     * @var array<int,string> $listRefLayananPenerimaManfaat
     */
@endphp

<div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Identitas Layanan
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Jenis Layanan</th>
                    <td>
                        <?= @$model->layananProduk?->nama; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Pengguna Layanan</th>
                    <td>
                        <?= @$model->layananPenerimaManfaat?->nama; ?>
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Jumlah Pengguna</th>
                    <td>
                        <?= @$model->jumlah_pengguna ?? 0; ?> Pengguna Per Tahun
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

    @include('livewire.layanan.partials.modal-identitas-layanan')
</div>
