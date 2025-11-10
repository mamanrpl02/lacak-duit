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
    public $kategoris;
    public $dompets;

    // ✅ Ketika status berubah, filter kategori berdasarkan tipe
    public function updatedStatus($value)
    {
        if ($value) {
            $this->filteredKategoris = Kategori::where('user_id', Auth::id())
                ->where('type', $value)
                ->get();
        } else {
            $this->filteredKategoris = collect();
        }

        // Reset kategori & dompet ketika status berubah
        $this->kategori_id = null;
        $this->dompet_asal_id = null;
        $this->dompet_tujuan_id = null;
    }

    // ✅ Load data awal berdasarkan user login
    public function mount()
    {
        $userId = Auth::id();

        $this->kategoris = Kategori::where('user_id', $userId)->get();
        $this->dompets = Dompet::where('user_id', $userId)->get();
        $this->filteredKategoris = collect(); // kosong dulu
    }

    // ✅ Render halaman
    public function render()
    {
        $userId = Auth::id();

        $query = Transaksi::with(['kategori', 'dompetAsal', 'dompetTujuan'])
            ->where('user_id', $userId);

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

        // Pencarian
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
            'dompets' => $this->dompets,
            'kategoris' => $this->kategoris,
        ]);
    }

    // ✅ Reset pagination saat filter berubah
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

    // ✅ Modal open/close
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

    // ✅ Store / Update (berdasarkan user login)
    public function store()
    {
        $this->validate([
            'keterangan' => 'required|string',
            'nominal' => 'required|numeric',
            'tanggal' => 'required|date',
            'status' => 'required',
            'kategori_id' => 'required',
            'dompet_asal_id' => 'required',
        ]);

        $userId = Auth::id();

        Transaksi::updateOrCreate(
            ['id' => $this->isEdit ? $this->transaksiId : null],
            [
                'user_id' => $userId,
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

        $this->dispatch('successAlert', message: $msg);
    }

    // ✅ Edit data (hanya milik user login)
    public function edit($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);

        $this->transaksiId = $id;
        $this->keterangan = $transaksi->keterangan;
        $this->nominal = $transaksi->nominal;
        $this->tanggal = $transaksi->tanggal ? date('Y-m-d', strtotime($transaksi->tanggal)) : null;
        $this->status = $transaksi->status;
        $this->kategori_id = $transaksi->kategori_id;
        $this->dompet_asal_id = $transaksi->dompet_asal_id;
        $this->dompet_tujuan_id = $transaksi->dompet_tujuan_id;

        $this->filteredKategoris = $transaksi->status
            ? Kategori::where('user_id', Auth::id())->where('type', $transaksi->status)->get()
            : collect();

        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    // ✅ Hapus data (hanya milik user login)
    #[On('deleteConfirmed')]
    public function deleteConfirmed($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $transaksi->delete();

        $this->dispatch('successAlert', message: 'Data berhasil dihapus!');
    }

    // ✅ Reset field input
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
        $this->filteredKategoris = collect();
    }
}
