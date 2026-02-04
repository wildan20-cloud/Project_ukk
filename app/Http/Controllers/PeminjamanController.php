<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'users'       => User::all(),
            'kategoris'   => Kategori::all(),
            'barangs'     => Barang::with('kategori')->get(),
            'peminjamans' => Peminjaman::with(['user', 'barang'])->latest()->get(),
            'logs'        => ActivityLog::with('user')->latest()->take(10)->get(),
        ]);
    }

    // Fungsi Update Status (Setuju / Kembali)
    public function updateStatus($id, $status)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = $peminjaman->barang;
        $statusU = strtoupper($status);

        // SAAT DISETUJUI: Stok Berkurang
        if ($statusU == 'APPROVED' && strtoupper($peminjaman->status) == 'PENDING') {
            if ($barang->stok < $peminjaman->jumlah) {
                return back()->with('success', 'Gagal: Stok barang saat ini tidak mencukupi.');
            }
            $barang->stok -= $peminjaman->jumlah;
            $barang->save();
        }

        // SAAT DIKEMBALIKAN: Stok Bertambah
        if ($statusU == 'RETURNED' && strtoupper($peminjaman->status) == 'APPROVED') {
            $barang->stok += $peminjaman->jumlah;
            $barang->save();
        }

        $peminjaman->status = $statusU;
        $peminjaman->save();

        return back()->with('success', 'Status Berhasil Diperbarui.');
    }

    // Fungsi Admin Input Manual (Stok Otomatis Berkurang)
    public function adminStore(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()->with('success', 'Gagal: Stok tidak cukup (Tersedia: '.$barang->stok.').');
        }

        Peminjaman::create([
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'status' => 'APPROVED' // Admin input dianggap sudah serah terima barang
        ]);

        $barang->stok -= $request->jumlah;
        $barang->save();

        return back()->with('success', 'Admin berhasil menginput pinjaman manual.');
    }

    // Fungsi Siswa Mengajukan (Validasi Stok di Sini)
    public function store(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()->with('success', 'Gagal: Jumlah pinjam melebihi stok tersedia.');
        }

        Peminjaman::create([
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'status' => 'PENDING'
        ]);

        return back()->with('success', 'Permintaan pinjam berhasil dikirim.');
    }

    public function destroy($id)
    {
        Peminjaman::findOrFail($id)->delete();
        return back()->with('success', 'Data transaksi dihapus.');
    }
}