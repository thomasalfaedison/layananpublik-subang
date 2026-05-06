<?php

namespace App\Livewire\Layanan;

use App\Livewire\Concerns\WithToast;
use App\Livewire\Form\LayananKomponenForm;
use App\Models\Layanan;
use App\Models\RefLayananKomponen;
use App\Services\LayananKomponenService;
use App\Services\RefLayananKomponenService;
use Livewire\Component;
use Throwable;

class StandarPelayanan extends Component
{
    use WithToast;

    public Layanan $model;

    public LayananKomponenForm $form;

    public string $modalTitle = '';

    public bool $showModal = false;

    protected LayananKomponenService $layananKomponenService;
    protected RefLayananKomponenService $refLayananKomponenService;

    public function boot(
        LayananKomponenService $layananKomponenService,
        RefLayananKomponenService $refLayananKomponenService,
    ): void {
        $this->layananKomponenService    = $layananKomponenService;
        $this->refLayananKomponenService = $refLayananKomponenService;
    }

    public function showModal() {
        $this->showModal = true;
        $this->dispatch('modal-open');
    }

    public function closeModal() {
        $this->showModal = false;
        $this->dispatch('modal-close');
    }

    private function lastUrutan(int $id_ref_layanan_komponen)
    {
        return $this->layananKomponenService->getLastUrutan([
            'id_layanan' => $this->model->id,
            'id_ref_layanan_komponen' => $id_ref_layanan_komponen,
        ]);
    }

    public function openCreateModal(int $id_ref_layanan_komponen): void
    {
        $this->modalTitle = 'Tambah Komponen Layanan';
        $this->form->resetForm();
        $this->form->id_layanan = $this->model->id;
        $this->form->id_ref_layanan_komponen = $id_ref_layanan_komponen;
        $this->form->urutan = $this->lastUrutan($id_ref_layanan_komponen) + 1;
        $this->resetValidation();
        $this->showModal();
    }

    public function openEditModal(int $id): void
    {
        $model = $this->layananKomponenService->findById($id);

        if (!$model) {
            $this->toastError('Komponen Layanan tidak ditemukan');
            return;
        }

        $this->modalTitle = 'Edit Komponen Layanan';
        $this->form->setModel($model);
        $this->resetValidation();
        $this->showModal();
    }

    public function save(): void
    {
        $this->validate();

        $isUpdate = $this->form->isEdit();

        try {
            if ($isUpdate) {
                $model = $this->layananKomponenService->findById($this->form->id);

                if (!$model) {
                    throw new \RuntimeException('Komponen Layanan tidak ditemukan');
                }

                $this->layananKomponenService->update($model, $this->form->toModelData());
            } else {
                $this->layananKomponenService->create($this->form->toModelData());
            }
        } catch (Throwable $e) {
            $this->toastError('Gagal menyimpan data: ' . $e->getMessage());
            return;
        }

        $this->toastSuccess('Data berhasil ' . ($isUpdate ? 'diupdate' : 'disimpan'));

        $this->form->resetForm();
        $this->closeModal();
        $this->dispatch('refreshTable');
    }

    public function delete(int $id)
    {
        $model = $this->layananKomponenService->findById($id);

        if (!$model) {
            $this->toastError('Komponen Layanan tidak ditemukan');
            return;
        }

        try {
            $this->layananKomponenService->delete($model);
            $this->toastSuccess('Data berhasil dihapus');
        } catch (Throwable $e) {
            $this->toastError('Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $allRefLayananKomponen = $this->refLayananKomponenService->findAll();

        $allLayananKomponen = $this->layananKomponenService->findAll([
            'id_layanan' => $this->model->id,
        ]);

        $groupLabels = RefLayananKomponen::getListGrup();

        return view('livewire.layanan.standar-pelayanan', [
            'groupLabels' => $groupLabels,
            'allRefLayananKomponen' => $allRefLayananKomponen,
            'allLayananKomponen' => $allLayananKomponen,
        ]);
    }
}