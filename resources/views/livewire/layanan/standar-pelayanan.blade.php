@php
    /**
     * @see \App\Livewire\Layanan\StandarPelayanan::render()
     * @see \App\Http\Controllers\LayananController::viewV2()
     * @var \Illuminate\Support\Collection<\App\Models\RefLayananKomponen> $allRefLayananKomponen
     * @var \Illuminate\Support\Collection<\App\Models\LayananKomponen> $allLayananKomponen
     * @var array<int,string> $groupLabels
     * @var \App\Livewire\Form\LayananKomponenForm $form
     * @var \App\Models\Layanan $model
     */
@endphp

<div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">
                Standar Pelayanan
            </h3>
        </div>
        <div class="card-body">
            @foreach ($groupLabels as $grupValue => $groupLabel)
                @php
                    $allRefLayananKomponenByGroup = $allRefLayananKomponen
                        ->where('grup', $grupValue)
                        ->sortBy('urutan');
                @endphp

                <h6 class="font-weight-bold">{{ $groupLabel }}</h6>

                <table class="table table-bordered">
                    <tr>
                        <th style="text-align: center; width: 60px;">No</th>
                        <th style="width: 300px;">Komponen</th>
                        <th>Uraian</th>
                    </tr>
                    @foreach ($allRefLayananKomponenByGroup as $refLayananKomponen)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $refLayananKomponen->nama }}
                                <a href="#" wire:click.prevent="openCreateModal({{ $refLayananKomponen->id }})" data-toggle="tooltip" data-title="Tambah Uraian">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </td>
                            <td>
                                @php
                                    $allLayananKomponenFiltered = $allLayananKomponen
                                        ->where('id_ref_layanan_komponen', $refLayananKomponen->id)
                                        ->sortBy('urutan');

                                    $jumlah = $allLayananKomponenFiltered->count();
                                @endphp
                                @if ($allLayananKomponenFiltered->isNotEmpty())
                                    @if($jumlah > 1) <ol style="padding-left:20px;margin-bottom:0"> @endif
                                        @foreach ($allLayananKomponenFiltered as $item)
                                            @if($jumlah > 1) <li> @endif
                                                <?= nl2br($item->uraian) ?>
                                                <a href="#" wire:click.prevent="openEditModal({{ $item->id }})" data-toggle="tooltip" data-title="Ubah">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>

                                                <a href="#" wire:click.prevent="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus data?" data-toggle="tooltip" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @if($jumlah > 1) </li> @endif
                                        @endforeach
                                    @if($jumlah > 1) </ol> @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                @if (!$loop->last)
                    <br/>
                @endif
            @endforeach
        </div>
    </div>

    @include('livewire.layanan.partials.modal-layanan-komponen')
</div>