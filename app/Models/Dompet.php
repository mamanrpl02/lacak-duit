<?php

namespace App\Models;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dompet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_dompet',
        'user_id',
        'keterangan',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function transaksiAsal()
    {
        return $this->hasMany(Transaksi::class, 'dompet_asal_id');
    }
    public function transaksiTujuan()
    {
        return $this->hasMany(Transaksi::class, 'dompet_tujuan_id');
    }
}
