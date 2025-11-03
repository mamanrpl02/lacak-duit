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
        'keterangan',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
