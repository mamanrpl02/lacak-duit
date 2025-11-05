<?php

namespace App\Livewire;

use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TransaksiIndex extends Component
{
    use WithPagination;

    public $keterangan, $nominal, $status, $kategori_id, $dompet_asal_id, $dompet_tujuan_id;
    public $isModalOpen = false, $isEdit = false, $transaksiId = null;
    public $filteredKategoris = [];

    protected $listeners = ['deleteConfirmed' => 'deleteConfirmed'];

    // reset halaman pagination tiap update
    protected $updatesQueryString = ['page'];

    public function mount()
    {
        // Set kategori awal agar tidak null di Blade
        $this->filteredKategoris = Kategori::all();
    }

    public function render()
    {
        $transaksis = Transaksi::with(['kategori', 'dompetAsal', 'dompetTujuan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.transaksi-index', [
            'transaksis' => $transaksis,
            'kategoris' => Kategori::all(),
            'dompets' => Dompet::all(),
        ]);
    }

    public function openModal()
    {
        $this->resetInput();
        $this->isModalOpen = true;
        $this->isEdit = false;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function updatedStatus($value)
    {
        // Filter kategori sesuai type/status
        if (in_array($value, ['Masuk', 'Keluar'])) {
            $this->filteredKategoris = Kategori::where('type', $value)->get();
        } else {
            $this->filteredKategoris = Kategori::all();
        }
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required',
            'nominal' => 'required|numeric',
            'status' => 'required',
            'kategori_id' => 'required',
        ]);

        if ($this->status === 'Withdraw') {
            $this->validate([
                'dompet_asal_id' => 'required',
                'dompet_tujuan_id' => 'required|different:dompet_asal_id',
            ]);
        } else {
            $this->validate([
                'dompet_asal_id' => 'required',
            ]);
        }

        Transaksi::updateOrCreate(
            ['id' => $this->transaksiId],
            [
                'keterangan' => $this->keterangan,
                'nominal' => $this->nominal,
                'status' => $this->status,
                'kategori_id' => $this->kategori_id,
                'dompet_asal_id' => $this->dompet_asal_id,
                'dompet_tujuan_id' => $this->status === 'Withdraw' ? $this->dompet_tujuan_id : null,
                'user_id' => Auth::id(),
            ]
        );

        $msg = $this->isEdit ? 'Data berhasil diupdate!' : 'Data berhasil disimpan!';
        $this->dispatch('swal:success', message: $msg);
        $this->closeModal();
        $this->resetInput();
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $this->transaksiId = $id;
        $this->keterangan = $transaksi->keterangan;
        $this->nominal = $transaksi->nominal;
        $this->status = $transaksi->status;
        $this->kategori_id = $transaksi->kategori_id;
        $this->dompet_asal_id = $transaksi->dompet_asal_id;
        $this->dompet_tujuan_id = $transaksi->dompet_tujuan_id;

        $this->filteredKategoris = in_array($this->status, ['Masuk', 'Keluar'])
            ? Kategori::where('type', $this->status)->get()
            : Kategori::all();

        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirmDelete', id: $id);
    }

    public function deleteConfirmed($id)
    {
        if ($transaksi = Transaksi::find($id)) {
            $transaksi->delete();
            $this->dispatch('swal:success', message: 'Data berhasil dihapus!');
        }
    }

    private function resetInput()
    {
        $this->keterangan = '';
        $this->nominal = '';
        $this->status = '';
        $this->kategori_id = '';
        $this->dompet_asal_id = '';
        $this->dompet_tujuan_id = '';
        $this->transaksiId = null;
        $this->filteredKategoris = Kategori::all();
    }
}
