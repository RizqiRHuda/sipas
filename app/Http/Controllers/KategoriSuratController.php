<?php
namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kategoris = KategoriSurat::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->appends(['search' => $search]);

        return view('kategori.index_kategori', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('kategori.form_kategori');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        KategoriSurat::create([
            'nama'       => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = KategoriSurat::findOrFail($id);
        return view('kategori.form_kategori', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kategori = KategoriSurat::findOrFail($id);
        $kategori->update([
            'nama'       => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = KategoriSurat::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori-surat.index')->with('success', 'Kategori berhasil dihapus');
    }
}
