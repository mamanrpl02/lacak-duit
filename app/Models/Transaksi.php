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
        'status',
        'kategori_id',
        'dompet_id',
        'user_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function dompet()
    {
        return $this->belongsTo(Dompet::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class);
    }
}
