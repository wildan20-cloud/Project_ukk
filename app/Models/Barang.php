<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $fillable = ['kategori_id', 'nama_barang', 'stok'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    // TAMBAHKAN INI: Barang bisa ada di banyak catatan peminjaman
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}   