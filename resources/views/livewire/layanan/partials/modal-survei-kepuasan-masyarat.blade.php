@php
    /**
     * @var \App\Livewire\Form\LayananSkmForm $form
     * @var \App\Models\Layanan $model
     */

    $listStatusSkm = [
        1 => 'Ya',
        0 => 'Tidak',
    ];
@endphp

@if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="close" wire:click="closeModal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    @include('livewire.layanan.partials._info-tabel-layanan', [
                        'model' => $model,
                    ])

                    <hr/>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="status_skm">Status SKM</label>
                                <select
                                    id="status_skm"
                                    wire:model="form.status_skm"
                                    class="form-control @error('form.status_skm') is-invalid @enderror"
                                >
                                    <option value="">- Pilih Status SKM -</option>
                                    @foreach ($listStatusSkm as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.status_skm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nilai_skm">Nilai SKM Terakhir</label>
                                <input
                                    id="nilai_skm"
                                    type="number"
                                    min="0"
                                    step="0.01"
                                    wire:model="form.nilai_skm"
                                    class="form-control @error('form.nilai_skm') is-invalid @enderror"
                                    placeholder="Misal: 4,5"
                                />
                                @error('form.nilai_skm')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="save">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
