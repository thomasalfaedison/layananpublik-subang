@php
    /**
     * @var \App\Livewire\Form\IdentitasLayananForm $form
     * @var \App\Models\Layanan $model
     */
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
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th style="width: 200px">Perangkat Daerah</th>
                            <td>{{ $model->instansi?->nama }}</td>
                        </tr>
                        <tr>
                            <th>Nama Layanan</th>
                            <td>{{ $model->nama }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Layanan</th>
                            <td>{{ $model->deskripsi }}</td>
                        </tr>
                    </table>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="id_ref_layanan_produk">Jenis Layanan</label>
                                <select
                                    id="id_ref_layanan_produk"
                                    wire:model="form.id_ref_layanan_produk"
                                    class="form-control @error('form.id_ref_layanan_produk') is-invalid @enderror"
                                >
                                    <option value="">- Pilih Produk Layanan -</option>
                                    @foreach ($listRefLayananProduk as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.id_ref_layanan_produk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="id_ref_layanan_penerima_manfaat">Pengguna Layanan</label>
                                <select
                                    id="id_ref_layanan_penerima_manfaat"
                                    wire:model="form.id_ref_layanan_penerima_manfaat"
                                    class="form-control @error('form.id_ref_layanan_penerima_manfaat') is-invalid @enderror"
                                >
                                    <option value="">- Pilih Penerima Manfaat -</option>
                                    @foreach ($listRefLayananPenerimaManfaat as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('form.id_ref_layanan_penerima_manfaat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="jumlah_pengguna">Jumlah Pengguna (Per Tahun)</label>
                                <input
                                    id="jumlah_pengguna"
                                    type="number"
                                    min="0"
                                    step="1"
                                    wire:model="form.jumlah_pengguna"
                                    class="form-control @error('form.jumlah_pengguna') is-invalid @enderror"
                                    placeholder="Masukkan Jumlah Pengguna"
                                />
                                @error('form.jumlah_pengguna')
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
