<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::latest()->paginate(10);  
        return view('kategori', compact('kategoris'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_kategori' => 'required|string|max:255',
    //         'type' => 'required|in:Masuk,Keluar,Withdraw',
    //         'keterangan' => 'nullable|string',
    //         'gambar_icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    //     ]);

    //     $data = $request->only(['nama_kategori', 'type', 'keterangan']);

    //     if ($request->hasFile('gambar_icon')) {
    //         $data['gambar_icon'] = $request->file('gambar_icon')->store('kategori_icons', 'public');
    //     }

    //     Kategori::create($data);

    //     return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    // }

    // public function update(Request $request, Kategori $kategori)
    // {
    //     $request->validate([
    //         'nama_kategori' => 'required|string|max:255',
    //         'type' => 'required|in:Masuk,Keluar,Withdraw',
    //         'keterangan' => 'nullable|string',
    //         'gambar_icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    //     ]);

    //     $data = $request->only(['nama_kategori', 'type', 'keterangan']);

    //     if ($request->hasFile('gambar_icon')) {
    //         if ($kategori->gambar_icon && Storage::disk('public')->exists($kategori->gambar_icon)) {
    //             Storage::disk('public')->delete($kategori->gambar_icon);
    //         }
    //         $data['gambar_icon'] = $request->file('gambar_icon')->store('kategori_icons', 'public');
    //     }

    //     $kategori->update($data);

    //     return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    // }

    // public function destroy(Kategori $kategori)
    // {
    //     if ($kategori->gambar_icon && Storage::disk('public')->exists($kategori->gambar_icon)) {
    //         Storage::disk('public')->delete($kategori->gambar_icon);
    //     }

    //     $kategori->delete();

    //     return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    // }
}
