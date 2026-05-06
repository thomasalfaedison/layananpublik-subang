@php
    /**
     * @see \App\Livewire\Layanan\DigitalisasiInovasi::render()
     * @see \App\Http\Controllers\LayananController::viewV2()
     * @var \App\Models\Layanan $model
     * @var \App\Livewire\Form\LayananDigitalisasiInovasiForm $form
     */
@endphp

<div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Digitalisasi dan Inovasi
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px;">Status Digitalisasi</th>
                    <td>
                        @if ($model->status_digitalisasi === 1)
                            Manual
                        @elseif ($model->status_digitalisasi === 2)
                            Semi Digital
                        @elseif ($model->status_digitalisasi === 3)
                            Full Online
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Nama Aplikasi</th>
                    <td>{{ $model->nama_aplikasi }}</td>
                </tr>
                <tr>
                    <th style="width:200px;">Link Aplikasi</th>
                    <td>{{ $model->link_aplikasi }}</td>
                </tr>
                <tr>
                    <th style="width:200px;">Apakah Ada Inovasi?</th>
                    <td>
                        @if ($model->status_inovasi === 1)
                            Ada
                        @elseif ($model->status_inovasi === 0)
                            Tidak Ada
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width:200px;">Deskripsi Inovasi</th>
                    <td>{{ $model->deskripsi_inovasi }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-primary" wire:click="openEditModal">
                <i class="fa fa-pencil-alt"></i> Ubah
            </button>
        </div>
    </div>

    @include('livewire.layanan.partials.modal-digitalisasi-inovasi')
</div>
