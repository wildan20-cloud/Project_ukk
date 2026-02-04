<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\ActivityLog;

class BarangController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_barang' => 'required',
            'stok'        => 'required|numeric',
        ]);

        // 2. Simpan data (Pastikan kategori_id ikut masuk)
        Barang::create([
            'kategori_id' => $request->kategori_id,
            'nama_barang' => $request->nama_barang,
            'stok'        => $request->stok,
        ]);

        // 3. Catat Aktivitas ke Log
        ActivityLog::create([
            'user_id'  => auth()->id(),
            'role'     => auth()->user()->role,
            'activity' => 'Menambahkan barang baru: ' . $request->nama_barang
        ]);

        return back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $nama = $barang->nama_barang;
        
        ActivityLog::create([
            'user_id'  => auth()->id(),
            'role'     => auth()->user()->role,
            'activity' => 'Menghapus barang: ' . $nama
        ]);

        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus!');
    }
}