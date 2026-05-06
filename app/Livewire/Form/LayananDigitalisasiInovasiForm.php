<?php

namespace App\Livewire\Form;

use App\Models\Layanan;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LayananDigitalisasiInovasiForm extends Form
{
    #[Locked]
    public ?int $id = null;

    #[Locked]
    public ?int $id_instansi = null;

    #[Locked]
    public string $nama = '';

    #[Validate('nullable|integer')]
    public ?int $status_digitalisasi = null;

    #[Validate('nullable|string')]
    public ?string $nama_aplikasi = null;

    #[Validate('nullable|string')]
    public ?string $link_aplikasi = null;

    #[Validate('nullable|integer')]
    public ?int $status_inovasi = null;

    #[Validate('nullable|string')]
    public ?string $deskripsi_inovasi = null;

    public function setModel(Layanan $model): void
    {
        $this->id = $model->id;
        $this->id_instansi = $model->id_instansi;
        $this->nama = $model->nama;
        $this->status_digitalisasi = $model->status_digitalisasi;
        $this->nama_aplikasi = $model->nama_aplikasi;
        $this->link_aplikasi = $model->link_aplikasi;
        $this->status_inovasi = $model->status_inovasi;
        $this->deskripsi_inovasi = $model->deskripsi_inovasi;
    }

    public function toModelData(): array
    {
        return [
            'id_instansi' => $this->id_instansi,
            'nama' => $this->nama,
            'status_digitalisasi' => $this->emptyToNull($this->status_digitalisasi),
            'nama_aplikasi' => $this->emptyToNull($this->nama_aplikasi),
            'link_aplikasi' => $this->emptyToNull($this->link_aplikasi),
            'status_inovasi' => $this->emptyToNull($this->status_inovasi),
            'deskripsi_inovasi' => $this->emptyToNull($this->deskripsi_inovasi),
        ];
    }

    public function resetForm(): void
    {
        $this->reset();
    }

    private function emptyToNull($value)
    {
        return $value === '' ? null : $value;
    }
}
