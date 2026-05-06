<?php

namespace App\Livewire\Form;

use App\Models\Layanan;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LayananSkmForm extends Form
{
    #[Locked]
    public ?int $id = null;

    #[Locked]
    public ?int $id_instansi = null;

    #[Locked]
    public string $nama = '';

    #[Validate('nullable|integer|min:0')]
    public ?int $status_skm = null;

    #[Validate('nullable|numeric|min:0')]
    public ?float $nilai_skm = null;

    public function setModel(Layanan $model): void
    {
        $this->id = $model->id;
        $this->id_instansi = $model->id_instansi;
        $this->nama = $model->nama;
        $this->status_skm = $model->status_skm;
        $this->nilai_skm = $model->nilai_skm;
    }

    public function toModelData(): array
    {
        return [
            'id_instansi' => $this->id_instansi,
            'nama' => $this->nama,
            'status_skm' => $this->emptyToNull($this->status_skm),
            'nilai_skm' => $this->emptyToNull($this->nilai_skm),
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
