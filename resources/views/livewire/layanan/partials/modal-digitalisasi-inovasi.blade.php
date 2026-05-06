@php
    /**
     * @var \App\Livewire\Form\LayananDigitalisasiInovasiForm $form
     * @var \App\Models\Layanan $model
     */

    $listStatusDigitalisasi = [
        1 => 'Manual',
        2 => 'Semi Digital',
        3 => 'Full Online',
    ];

    $listStatusInovasi = [
        1 => 'Ada',
        0 => 'Tidak Ada',
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
                                <label for="status_digitalisasi">Status Digitalisasi</label>
                                <select
                                    id="status_digitalisasi"
                                    wire:model="form.status_digitalisasi"
                                    class="form-control @error('form.status_digitalisasi') is-invalid @enderror"
                                >
                                    <option value="">- Pilih Status Digitalisasi -</option>
                                    @foreach ($listStatusDigitalisasi as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.status_digitalisasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nama_aplikasi">Nama Aplikasi</label>
                                <input
                                    id="nama_aplikasi"
                                    type="text"
                                    wire:model="form.nama_aplikasi"
                                    class="form-control @error('form.nama_aplikasi') is-invalid @enderror"
                                    placeholder="Masukkan Nama Aplikasi"
                                />
                                @error('form.nama_aplikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="link_aplikasi">Link Aplikasi</label>
                                <input
                                    id="link_aplikasi"
                                    type="text"
                                    wire:model="form.link_aplikasi"
                                    class="form-control @error('form.link_aplikasi') is-invalid @enderror"
                                    placeholder="Masukkan Link Aplikasi"
                                />
                                @error('form.link_aplikasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="status_inovasi">Ada Inovasi?</label>
                                <select
                                    id="status_inovasi"
                                    wire:model="form.status_inovasi"
                                    class="form-control @error('form.status_inovasi') is-invalid @enderror"
                                >
                                    <option value="">- Pilih Status Inovasi -</option>
                                    @foreach ($listStatusInovasi as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.status_inovasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="deskripsi_inovasi">Deskripsi Inovasi</label>
                                <textarea
                                    id="deskripsi_inovasi"
                                    wire:model="form.deskripsi_inovasi"
                                    class="form-control @error('form.deskripsi_inovasi') is-invalid @enderror"
                                    placeholder="Masukkan Deskripsi Inovasi"
                                    rows="3"
                                ></textarea>
                                @error('form.deskripsi_inovasi')
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
