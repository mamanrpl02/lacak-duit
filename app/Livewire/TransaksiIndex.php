<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\Kategori;
use App\Models\Dompet;
use Livewire\WithPagination;

class TransaksiIndex extends Component
{
    use WithPagination;

    public $keterangan, $nominal, $status, $kategori_id, $dompet_id;
    public $filteredKategoris = [];
    public $dompets;
    public $isModalOpen = false;
    public $isEdit = false;
    public $transaksiId;

    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    public function mount()
    {
        $this->dompets = Dompet::all();
        $this->filteredKategoris = collect();
    }

    public function updatedStatus($value)
    {
        if ($value) {
            $this->filteredKategoris = Kategori::whereRaw('LOWER(type) = ?', [strtolower($value)])->get();
        } else {
            $this->filteredKategoris = collect();
        }
        $this->kategori_id = '';
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->keterangan = '';
        $this->nominal = '';
        $this->status = '';
        $this->kategori_id = '';
        $this->dompet_id = '';
        $this->filteredKategoris = collect();
        $this->isEdit = false;
        $this->transaksiId = null;
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required',
            'nominal' => 'required|numeric',
            'status' => 'required',
            'kategori_id' => 'required',
            'dompet_id' => 'required',
        ]);

        Transaksi::updateOrCreate(
            ['id' => $this->transaksiId],
            [
                'keterangan' => $this->keterangan,
                'nominal' => $this->nominal,
                'status' => $this->status,
                'kategori_id' => $this->kategori_id,
                'dompet_id' => $this->dompet_id,
                'user_id' => auth()->id() ?? 1,
            ]
        );

        $this->closeModal();
        $this->dispatch('save-success', $this->isEdit ? 'Data berhasil diupdate!' : 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $this->transaksiId = $id;
        $this->keterangan = $transaksi->keterangan;
        $this->nominal = $transaksi->nominal;
        $this->status = $transaksi->status;
        $this->kategori_id = $transaksi->kategori_id;
        $this->dompet_id = $transaksi->dompet_id;

        $this->filteredKategoris = Kategori::whereRaw('LOWER(type) = ?', [strtolower($transaksi->status)])->get();

        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-alert', id: $id);
    }

    public function deleteConfirmed($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->delete();
            $this->dispatch('delete-success');
        }
    }

    public function render()
    {
        return view('livewire.transaksi-index', [
            'transaksis' => Transaksi::with('kategori', 'dompet')->latest()->paginate(5),
        ]);
    }
}
