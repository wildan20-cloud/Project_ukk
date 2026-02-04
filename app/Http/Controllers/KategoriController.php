<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function store(Request $request) {
        Kategori::create($request->validate(['nama_kategori' => 'required']));
        return back()->with('success', 'Kategori berhasil ditambah!');
    }

    public function destroy($id) {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori dihapus!');
    }
}