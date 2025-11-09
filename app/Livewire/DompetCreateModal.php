<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dompet;
use Illuminate\Support\Facades\Auth;

class DompetCreateModal extends Component
{
    public $showModal = false; // <- ini WAJIB
    public $nama_dompet;

    protected $listeners = ['openDompetModal' => 'open'];

    protected $rules = [
        'nama_dompet' => 'required|string|max:255',
    ];

    public function open()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        Dompet::create([
            'nama_dompet' => $this->nama_dompet,
            'user_id' => Auth::id(),
        ]);

        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => 'Dompet berhasil dibuat!'
        ]);

        $this->close();
        $this->emit('refreshDashboard');
    }

    private function resetInput()
    {
        $this->nama_dompet = '';
    }

    public function render()
    {
        return view('livewire.dompet-create-modal');
    }
}
