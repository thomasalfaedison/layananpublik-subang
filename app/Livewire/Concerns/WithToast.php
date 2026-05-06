<?php

namespace App\Livewire\Concerns;

/**
 * @mixin \Livewire\Component
 */
trait WithToast
{
    protected function toast(string $message, string $type = 'success'): void
    {
        $this->dispatch('notify', type: $type, message: $message);
    }

    protected function toastSuccess(string $message): void
    {
        $this->toast($message, 'success');
    }

    protected function toastError(string $message): void
    {
        $this->toast($message, 'error');
    }

    protected function toastWarning(string $message): void
    {
        $this->toast($message, 'warning');
    }

    protected function toastInfo(string $message): void
    {
        $this->toast($message, 'info');
    }
}