<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dompet;

class DompetIndex extends Component
{
    use WithPagination;

    public $nama_dompet, $keterangan, $dompet_id;
    public $isModalOpen = false;

    protected $rules = [
        'nama_dompet' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
    ];

    public function render()
    {
        return view('livewire.dompet-index', [
            'dompets' => Dompet::latest()->paginate(10),
        ]);
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['nama_dompet', 'keterangan', 'dompet_id']);
    }

    public function store()
    {
        $this->validate();

        Dompet::updateOrCreate(
            ['id' => $this->dompet_id],
            [
                'nama_dompet' => $this->nama_dompet,
                'keterangan' => $this->keterangan,
            ]
        );

        session()->flash('success', $this->dompet_id ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $dompet = Dompet::findOrFail($id);
        $this->dompet_id = $id;
        $this->nama_dompet = $dompet->nama_dompet;
        $this->keterangan = $dompet->keterangan;
        $this->openModal();
    }

    public function delete($id)
    {
        Dompet::findOrFail($id)->delete();
        session()->flash('success', 'Data berhasil dihapus.');
    }
}
