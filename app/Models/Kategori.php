<?php

namespace App\Models;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'type',
        'keterangan',
        'gambar_icon',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
