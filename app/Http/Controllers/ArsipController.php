<?php
namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use Illuminate\Http\Request;
use App\Models\KategoriSurat;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{

    public function index(Request $request)
    {
        $query = ArsipSurat::query();
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($sub) use ($search) {
                        $sub->where('nama', 'like', "%{$search}%"); 
                    });
            });

        }

        $arsip = $query->latest()->paginate(5);
        return view('arsip.index', compact('arsip'));
    }

    public function create()
    {
         $kategori = KategoriSurat::all();
    return view('arsip.form', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'judul'       => 'required|string|max:255',
            'file_surat'  => 'required|mimes:pdf|max:2048',
        ]);

        $fileName = time() . '_' . $request->file('file_surat')->getClientOriginalName();
        $request->file('file_surat')->storeAs('arsip', $fileName, 'public');

        ArsipSurat::create([
            'nomor_surat' => $request->nomor_surat,
            'kategori_id' => $request->kategori_id,
            'judul'       => $request->judul,
            'file_surat'  => $fileName, // HANYA NAMA FILE
        ]);

        return redirect()->route('arsip.index')->with('success', 'Data berhasil disimpan');
    }

    public function download($id)
    {
        $arsip    = ArsipSurat::findOrFail($id);
        $filePath = storage_path('app/public/arsip/' . $arsip->file_surat);

        if (! file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($filePath);
    }

   public function show($id)
{
    $arsip = ArsipSurat::with('kategori')->findOrFail($id);
    $kategoriList = KategoriSurat::all();
    return view('arsip.detail', compact('arsip', 'kategoriList'));
}

    public function update(Request $request, $id)
    {
       
        $arsip = ArsipSurat::findOrFail($id);

        $request->validate([
            'nomor_surat' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori_surat,id',
            'judul'       => 'required|string|max:255',
            'file_surat'  => 'nullable|mimes:pdf|',
        ]);

        $arsip->nomor_surat = $request->nomor_surat;
        $arsip->kategori_id = $request->kategori_id;
        $arsip->judul       = $request->judul;

        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if (Storage::exists('public/arsip/' . $arsip->file_surat)) {
                Storage::delete('public/arsip/' . $arsip->file_surat);
            }

            // Simpan file baru
            $fileName = time() . '_' . $request->file('file_surat')->getClientOriginalName();
            $request->file('file_surat')->storeAs('arsip', $fileName, 'public');

            // Simpan HANYA nama file di database
            $arsip->file_surat = $fileName;
        }

        $arsip->save();

        return redirect()->back()->with('success', 'Arsip berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $arsip = ArsipSurat::findOrFail($id);
        if (Storage::exists('public/arsip/' . $arsip->file_surat)) {
            Storage::delete('public/arsip/' . $arsip->file_surat);
        }

        $arsip->delete();
        $arsip->delete();
        return redirect()->route('arsip.index')
            ->with('success', 'Surat berhasil dihapus!');
    }

}
