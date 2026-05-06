@php
    /**
     * @var \App\Livewire\Form\LayananKomponenForm $form
     * @var \App\Models\Layanan $model
     */
    $isEdit = $form->isEdit();
@endphp

@if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog {{ $isEdit ? 'modal-lg' : 'modal-xl' }}">
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
                        {{-- FORM UTAMA --}}
                        <div class="{{ $isEdit ? 'col-sm-12' : 'col-sm-6' }}">
                            <div class="form-group">
                                <label>Uraian Persyaratan <span class="text-danger">*</span></label>
                                <textarea
                                    wire:model="form.uraian"
                                    class="form-control @error('form.uraian') is-invalid @enderror"
                                    rows="8"
                                    placeholder="Tuliskan Uraian Persyaratan"
                                ></textarea>
                                @error('form.uraian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                                
                        </div>

                        {{-- ALERT (hanya saat create) --}}
                        @if (!$isEdit)
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="alert alert-info">
                                        Untuk memasukan lebih dari 1 data secara langsung silahkan gunakan
                                        titik koma (;) pada akhir uraian, sebagai contoh:<br/>
                                        Uraian 1;<br/>
                                        Uraian 2;<br/>
                                        Uraian 3
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="{{ $isEdit ? 'col-sm-12' : 'col-sm-6' }}">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input
                                    type="number"
                                    wire:model="form.urutan"
                                    class="form-control @error('form.urutan') is-invalid @enderror"
                                />
                                @error('form.urutan')
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