<?php

namespace App\Livewire\Form;

use App\Models\Layanan;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LayananIdentitasForm extends Form
{
    #[Locked]
    public ?int $id = null;

    #[Locked]
    public ?int $id_instansi = null;

    #[Locked]
    public string $nama = '';

    #[Validate('nullable|integer')]
    public ?int $id_ref_layanan_produk = null;

    #[Validate('nullable|integer')]
    public ?int $id_ref_layanan_penerima_manfaat = null;

    #[Validate('nullable|integer|min:0')]
    public ?int $jumlah_pengguna = null;

    public function setModel(Layanan $model): void
    {
        $this->id = $model->id;
        $this->id_instansi = $model->id_instansi;
        $this->nama = $model->nama;
        $this->id_ref_layanan_produk = $model->id_ref_layanan_produk;
        $this->id_ref_layanan_penerima_manfaat = $model->id_ref_layanan_penerima_manfaat;
        $this->jumlah_pengguna = $model->jumlah_pengguna;
    }

    public function toModelData(): array
    {
        return [
            'id_instansi' => $this->id_instansi,
            'nama' => $this->nama,
            'id_ref_layanan_produk' => $this->emptyToNull($this->id_ref_layanan_produk),
            'id_ref_layanan_penerima_manfaat' => $this->emptyToNull($this->id_ref_layanan_penerima_manfaat),
            'jumlah_pengguna' => $this->emptyToNull($this->jumlah_pengguna),
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
