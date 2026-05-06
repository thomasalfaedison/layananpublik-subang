<?php

namespace App\Livewire\Form;

use App\Models\LayananKomponen;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LayananKomponenForm extends Form
{
    #[Locked]
    public ?int $id = null;

    #[Locked]
    public ?int $id_layanan = null;

    #[Locked]
    public ?int $id_ref_layanan_komponen = null;

    #[Validate('required|string')]
    public string $uraian = '';

    #[Validate('nullable|integer|min:0')]
    public ?int $urutan = null;

    public function setModel(LayananKomponen $model): void
    {
        $this->id = $model->id;
        $this->id_layanan = $model->id_layanan;
        $this->id_ref_layanan_komponen = $model->id_ref_layanan_komponen;
        $this->uraian = $model->uraian;
        $this->urutan = $model->urutan;
    }

    public function toModelData(): array
    {
        return [
            'id_layanan' => $this->id_layanan,
            'id_ref_layanan_komponen' => $this->id_ref_layanan_komponen,
            'uraian' => $this->uraian,
            'urutan' => $this->urutan,
        ];
    }

    public function resetForm(): void
    {
        $this->reset();
    }

    public function isEdit(): bool
    {
        return (bool) $this->id;
    }
}