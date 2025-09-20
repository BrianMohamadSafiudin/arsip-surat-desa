<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArsipSurat;
use App\Models\KategoriSurat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArsipSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ArsipSurat::with('kategori');

        // Jika ada parameter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('judul_surat', 'like', '%' . $request->search . '%');
        }

        $arsipSurat = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('arsip-surat.index', compact('arsipSurat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriSurat = KategoriSurat::all();
        return view('arsip-surat.create', compact('kategoriSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'tanggal_surat' => 'required|date',
            'file' => 'required|file|mimes:pdf|max:10240', // max 10MB
            'keterangan' => 'nullable|string',
        ]);

        // Upload file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat', $fileName, 'public');

            ArsipSurat::create([
                'nomor_surat' => $request->nomor_surat,
                'judul_surat' => $request->judul_surat,
                'kategori_id' => $request->kategori_id,
                'tanggal_surat' => $request->tanggal_surat,
                'file_path' => $filePath,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('arsip-surat.index')
                           ->with('success', 'Data berhasil disimpan');
        }

        return back()->with('error', 'File gagal diupload');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $arsipSurat = ArsipSurat::with('kategori')->findOrFail($id);
        return view('arsip-surat.show', compact('arsipSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $arsipSurat = ArsipSurat::findOrFail($id);
        $kategoriSurat = KategoriSurat::all();
        return view('arsip-surat.edit', compact('arsipSurat', 'kategoriSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $arsipSurat = ArsipSurat::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'tanggal_surat' => 'required|date',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
            'tanggal_surat' => $request->tanggal_surat,
            'keterangan' => $request->keterangan,
        ];

        // Jika ada file baru
        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($arsipSurat->file_path && Storage::disk('public')->exists($arsipSurat->file_path)) {
                Storage::disk('public')->delete($arsipSurat->file_path);
            }

            // Upload file baru
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat', $fileName, 'public');
            $data['file_path'] = $filePath;
        }

        $arsipSurat->update($data);

        return redirect()->route('arsip-surat.index')
                       ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $arsipSurat = ArsipSurat::findOrFail($id);

        // Hapus file
        if ($arsipSurat->file_path && Storage::disk('public')->exists($arsipSurat->file_path)) {
            Storage::disk('public')->delete($arsipSurat->file_path);
        }

        $arsipSurat->delete();

        return redirect()->route('arsip-surat.index')
                       ->with('success', 'Data berhasil dihapus');
    }

    /**
     * Download file
     */
    public function download(string $id)
    {
        $arsipSurat = ArsipSurat::findOrFail($id);

        $filePath = storage_path('app/public/' . $arsipSurat->file_path);

        if (File::exists($filePath)) {
            // Buat nama file yang lebih deskriptif
            $fileName = $arsipSurat->nomor_surat . ' - ' . $arsipSurat->judul_surat . '.pdf';

            // Bersihkan nama file dari karakter yang tidak valid
            $fileName = preg_replace('/[^a-zA-Z0-9\-_\. ]/', '', $fileName);

            // Headers untuk force download
            $headers = [
                'Content-Type' => 'application/force-download',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ];

            return response()->download($filePath, $fileName, $headers);
        }

        return back()->with('error', 'File tidak ditemukan');
    }

    /**
     * Search functionality
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
}
