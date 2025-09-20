<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriSurat;

class KategoriSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriSurat = KategoriSurat::withCount('arsipSurat')->orderBy('created_at', 'desc')->get();
        return view('kategori-surat.index', compact('kategoriSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surat,nama_kategori',
            'keterangan' => 'nullable|string',
        ]);

        KategoriSurat::create([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kategori-surat.index')
                       ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategoriSurat = KategoriSurat::with('arsipSurat')->findOrFail($id);
        return view('kategori-surat.show', compact('kategoriSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategoriSurat = KategoriSurat::findOrFail($id);
        return view('kategori-surat.edit', compact('kategoriSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategoriSurat = KategoriSurat::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surat,nama_kategori,' . $id,
            'keterangan' => 'nullable|string',
        ]);

        $kategoriSurat->update([
            'nama_kategori' => $request->nama_kategori,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kategori-surat.index')
                       ->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategoriSurat = KategoriSurat::findOrFail($id);

        // Cek apakah kategori masih digunakan
        if ($kategoriSurat->arsipSurat()->count() > 0) {
            return redirect()->route('kategori-surat.index')
                           ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh arsip surat');
        }

        $kategoriSurat->delete();

        return redirect()->route('kategori-surat.index')
                       ->with('success', 'Kategori berhasil dihapus');
    }
}
