<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $fillable = ['user_id', 'barang_id', 'jumlah', 'status', 'tgl_pinjam', 'tgl_kembali'];

    public function user(): BelongsTo 
    { 
        return $this->belongsTo(User::class); 
    }

    public function barang(): BelongsTo 
    { 
        return $this->belongsTo(Barang::class); 
    }
}