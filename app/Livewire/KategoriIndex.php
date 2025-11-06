<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KategoriIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $nama_kategori, $type, $keterangan, $gambar_icon;
    public $kategori_id = null;
    public $isModalOpen = false;
    public $isEdit = false;

    protected $listeners = ['deleteKategori' => 'delete'];

    protected $rules = [
        'nama_kategori' => 'required|string|max:255',
        'type' => 'required|string|in:Masuk,Keluar,Withdraw',
        'keterangan' => 'nullable|string',
        'gambar_icon' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        return view('livewire.kategori-index', [
            // ✅ hanya tampilkan kategori milik user login
            'kategoris' => Kategori::where('user_id', Auth::id())
                ->latest()
                ->paginate(10),
        ]);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $kategori = Kategori::where('user_id', Auth::id())->findOrFail($id);

        $this->kategori_id = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->type = $kategori->type;
        $this->keterangan = $kategori->keterangan;
        $this->gambar_icon = null;
        $this->isEdit = true;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['nama_kategori', 'type', 'keterangan', 'gambar_icon', 'kategori_id', 'isEdit']);
    }

    public function store()
    {
        $this->validate();

        $path = $this->gambar_icon ? $this->gambar_icon->store('kategori_icons', 'public') : null;

        Kategori::create([
            'nama_kategori' => $this->nama_kategori,
            'type' => $this->type,
            'keterangan' => $this->keterangan,
            'gambar_icon' => $path,
            'user_id' => Auth::id(), // ✅ simpan user id
        ]);

        $this->closeModal();
        $this->dispatch('successAlert', 'Kategori berhasil ditambahkan.');
    }

    public function update()
    {
        $this->validate();

        if (!$this->kategori_id) {
            $this->dispatch('successAlert', 'Kategori tidak ditemukan.');
            return;
        }

        $kategori = Kategori::where('user_id', Auth::id())->findOrFail($this->kategori_id);

        if ($this->gambar_icon) {
            if ($kategori->gambar_icon && Storage::disk('public')->exists($kategori->gambar_icon)) {
                Storage::disk('public')->delete($kategori->gambar_icon);
            }
            $path = $this->gambar_icon->store('kategori_icons', 'public');
        } else {
            $path = $kategori->gambar_icon;
        }

        $kategori->update([
            'nama_kategori' => $this->nama_kategori,
            'type' => $this->type,
            'keterangan' => $this->keterangan,
            'gambar_icon' => $path,
        ]);

        $this->closeModal();
        $this->dispatch('successAlert', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $kategori = Kategori::where('user_id', Auth::id())->findOrFail($id);

        if ($kategori->gambar_icon && Storage::disk('public')->exists($kategori->gambar_icon)) {
            Storage::disk('public')->delete($kategori->gambar_icon);
        }

        $kategori->delete();

        $this->dispatch('successAlert', 'Kategori berhasil dihapus.');
    }
}
