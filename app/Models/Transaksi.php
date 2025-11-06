<?php

namespace App\Models;

use App\Models\Dompet;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'keterangan',
        'nominal',
        'tanggal',
        'status',
        'kategori_id',
        'dompet_asal_id',
        'dompet_tujuan_id',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($transaksi) {
            if (empty($transaksi->tanggal)) {
                $transaksi->tanggal = now();
            }
        });
    }


    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function dompetAsal()
    {
        return $this->belongsTo(Dompet::class, 'dompet_asal_id');
    }

    public function dompetTujuan()
    {
        return $this->belongsTo(Dompet::class, 'dompet_tujuan_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
