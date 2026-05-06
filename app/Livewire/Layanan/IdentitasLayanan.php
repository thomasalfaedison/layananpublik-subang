<?php

namespace App\Livewire\Layanan;

use App\Livewire\Concerns\WithToast;
use App\Livewire\Form\IdentitasLayananForm;
use App\Models\Layanan;
use App\Services\LayananService;
use App\Services\RefLayananPenerimaManfaatService;
use App\Services\RefLayananProdukService;
use Livewire\Component;
use Throwable;

class IdentitasLayanan extends Component
{
    use WithToast;

    public Layanan $model;

    public IdentitasLayananForm $form;

    public string $modalTitle = '';

    public bool $showModal = false;

    protected LayananService $layananService;
    protected RefLayananProdukService $refLayananProdukService;
    protected RefLayananPenerimaManfaatService $refLayananPenerimaManfaatService;

    public function boot(
        LayananService $layananService,
        RefLayananProdukService $refLayananProdukService,
        RefLayananPenerimaManfaatService $refLayananPenerimaManfaatService,
    ): void {
        $this->layananService = $layananService;
        $this->refLayananProdukService = $refLayananProdukService;
        $this->refLayananPenerimaManfaatService = $refLayananPenerimaManfaatService;
    }

    public function showModal()
    {
        $this->showModal = true;
        $this->dispatch('modal-open');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->dispatch('modal-close');
    }

    public function openEditModal(): void
    {
        $this->modalTitle = 'Ubah Identitas Layanan';
        $this->form->setModel($this->model);
        $this->resetValidation();
        $this->showModal();
    }

    public function save(): void
    {
        $this->validate();

        $model = $this->layananService->findById($this->model->id);

        if (!$model) {
            $this->toastError('Layanan tidak ditemukan');
            return;
        }

        try {
            $this->layananService->update($model, $this->form->toModelData());
        } catch (Throwable $e) {
            $this->toastError('Gagal menyimpan data: ' . $e->getMessage());
            return;
        }

        $this->model = $model->fresh([
            'instansi',
            'layananPenerimaManfaat',
            'layananProduk',
        ]);

        $this->form->setModel($this->model);
        $this->closeModal();
        $this->toastSuccess('Data berhasil diupdate');
    }

    public function render()
    {
        $listRefLayananProduk = $this->refLayananProdukService->getList();
        $listRefLayananPenerimaManfaat = $this->refLayananPenerimaManfaatService->getList();

        return view('livewire.layanan.identitas-layanan', [
            'listRefLayananProduk' => $listRefLayananProduk,
            'listRefLayananPenerimaManfaat' => $listRefLayananPenerimaManfaat,
        ]);
    }
}
