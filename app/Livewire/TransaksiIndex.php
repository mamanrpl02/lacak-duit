<?php

namespace App\Livewire;

use App\Models\Dompet;
use App\Models\Kategori;
use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class TransaksiIndex extends Component
{
    use WithPagination;

    public $keterangan, $nominal, $tanggal, $status, $kategori_id, $dompet_asal_id, $dompet_tujuan_id;
    public $isModalOpen = false, $isEdit = false, $transaksiId = null;
    public $filteredKategoris = [];

    // Filter & Search
    public $filterKategori = '';
    public $filterStatus = '';
    public $filterTanggalAwal = '';
    public $filterTanggalAkhir = '';
    public $search = '';

    public function mount()
    {
        $this->filteredKategoris = Kategori::all();
    }

    public function render()
    {
        $query = Transaksi::with(['kategori', 'dompetAsal', 'dompetTujuan'])
            ->where('user_id', Auth::id());

        // Filter kategori
        if ($this->filterKategori) {
            $query->where('kategori_id', $this->filterKategori);
        }

        // Filter status
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Filter tanggal
        if ($this->filterTanggalAwal && $this->filterTanggalAkhir) {
            $query->whereBetween('tanggal', [$this->filterTanggalAwal, $this->filterTanggalAkhir]);
        }

        // Search
        if ($this->search) {
            $search = '%' . $this->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', $search)
                    ->orWhere('nominal', 'like', $search);
            });
        }

        $transaksis = $query->latest()->paginate(10);

        return view('livewire.transaksi-index', [
            'transaksis' => $transaksis,
            'dompets' => Dompet::all(),
            'kategoris' => Kategori::all(),
        ]);
    }

    // Reset pagination saat filter/search berubah
    public function updated($field)
    {
        if (in_array($field, [
            'filterKategori',
            'filterStatus',
            'filterTanggalAwal',
            'filterTanggalAkhir',
            'search'
        ])) {
            $this->resetPage();
        }
    }

    // Modal
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
        $this->filteredKategoris = $value
            ? Kategori::where('type', $value)->get()
            : Kategori::all();

        if (!$this->isEdit) {
            $this->kategori_id = '';
        }
    }

    // Store / Update
    public function store()
    {
        $this->validate([
            'keterangan' => 'required',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'status' => 'required',
            'kategori_id' => 'required',
            'dompet_asal_id' => 'required',
        ]);

        Transaksi::updateOrCreate(
            ['id' => $this->isEdit ? $this->transaksiId : null],
            [
                'keterangan' => $this->keterangan,
                'nominal' => $this->nominal,
                'tanggal' => $this->tanggal,
                'status' => $this->status,
                'kategori_id' => $this->kategori_id,
                'dompet_asal_id' => $this->dompet_asal_id,
                'dompet_tujuan_id' => $this->status === 'Withdraw' ? $this->dompet_tujuan_id : null,
            ]
        );

        $msg = $this->isEdit ? 'Data berhasil diperbarui!' : 'Data berhasil disimpan!';
        $this->resetInput();
        $this->closeModal();
        $this->resetPage();

        // ✅ Trigger SweetAlert
        $this->dispatch('successAlert', message: $msg);
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $this->transaksiId = $id;
        $this->keterangan = $transaksi->keterangan;
        $this->nominal = $transaksi->nominal;
        $this->tanggal = $transaksi->tanggal ? date('Y-m-d', strtotime($transaksi->tanggal)) : null;
        $this->status = $transaksi->status;
        $this->kategori_id = $transaksi->kategori_id;
        $this->dompet_asal_id = $transaksi->dompet_asal_id;
        $this->dompet_tujuan_id = $transaksi->dompet_tujuan_id;

        $this->filteredKategoris = $transaksi->status
            ? Kategori::where('type', $transaksi->status)->get()
            : Kategori::all();

        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        // ✅ Trigger SweetAlert
        $this->dispatch('successAlert', message: 'Data berhasil dihapus!');
    }


    private function resetInput()
    {
        $this->keterangan = '';
        $this->nominal = '';
        $this->tanggal = '';
        $this->status = '';
        $this->kategori_id = '';
        $this->dompet_asal_id = '';
        $this->dompet_tujuan_id = '';
        $this->transaksiId = null;
        $this->filteredKategoris = Kategori::all();
    }
}
