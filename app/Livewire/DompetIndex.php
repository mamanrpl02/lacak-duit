<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Dompet;
use Illuminate\Support\Facades\Auth;

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
            // ✅ hanya tampilkan dompet milik user yang sedang login
            'dompets' => Dompet::where('user_id', Auth::id())
                ->latest()
                ->paginate(10),
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
                'user_id' => Auth::id(), // ✅ simpan user id
            ]
        );

        session()->flash('success', $this->dompet_id ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $dompet = Dompet::where('user_id', Auth::id())->findOrFail($id);

        $this->dompet_id = $dompet->id;
        $this->nama_dompet = $dompet->nama_dompet;
        $this->keterangan = $dompet->keterangan;

        $this->openModal();
    }

    public function delete($id)
    {
        $dompet = Dompet::where('user_id', Auth::id())->findOrFail($id);
        $dompet->delete();

        session()->flash('success', 'Data berhasil dihapus.');
    }
}
