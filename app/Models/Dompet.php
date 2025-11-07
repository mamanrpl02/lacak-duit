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
        return $this->hasMany(Transaksi::class, 'dompet_id');
    }


    public function transaksiAsal()
    {
        return $this->hasMany(Transaksi::class, 'dompet_asal_id');
    }
    public function transaksiTujuan()
    {
        return $this->hasMany(Transaksi::class, 'dompet_tujuan_id');
    }

    public function getSaldoAttribute()
    {
        // Saldo masuk
        $masuk = $this->transaksiAsal()->where('status', 'Masuk')->sum('nominal');
        // Saldo keluar
        $keluar = $this->transaksiAsal()->where('status', 'Keluar')->sum('nominal');
        // Withdraw keluar
        $withdrawKeluar = $this->transaksiAsal()->where('status', 'Withdraw')->sum('nominal');
        // Withdraw masuk
        $withdrawMasuk = $this->transaksiTujuan()->where('status', 'Withdraw')->sum('nominal');

        return $masuk - $keluar - $withdrawKeluar + $withdrawMasuk;
    }
}
