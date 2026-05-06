<?php

namespace App\Livewire\Layanan;

use App\Livewire\Concerns\WithToast;
use App\Livewire\Form\LayananSkmForm;
use App\Models\Layanan;
use App\Services\LayananService;
use Livewire\Component;
use Throwable;

class SurveiKepuasanMasyarat extends Component
{
    use WithToast;

    public Layanan $model;

    public LayananSkmForm $form;

    public string $modalTitle = '';

    public bool $showModal = false;

    protected LayananService $layananService;

    public function boot(
        LayananService $layananService,
    ): void {
        $this->layananService = $layananService;
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
        $this->modalTitle = 'Ubah Survei Kepuasan Masyarakat (SKM)';
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

        $this->model = $model->refresh();

        $this->form->setModel($this->model);
        $this->closeModal();
        $this->toastSuccess('Data berhasil diupdate');
    }
    
    public function render()
    {
        return view('livewire.layanan.survei-kepuasan-masyarat');
    }
}
