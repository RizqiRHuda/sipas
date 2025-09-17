<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class PageUserController extends Controller
{
    public function index(Request $request)
    {
        // Tahun dinamis (default = tahun sekarang)
        $year = $request->input('year', now()->year);

        // --- Grafik 1: Jumlah Dokumen per Kategori ---
        $kategoriData = KategoriSurat::withCount('arsip')->get();
        $kategoriLabels = $kategoriData->pluck('nama');
        $kategoriCounts = $kategoriData->pluck('arsip_count');

        // --- Grafik 2: Jumlah Dokumen per Kategori per Bulan (Stacked) ---
        $stackedData = ArsipSurat::selectRaw('kategori_id, MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('kategori_id', 'bulan')
            ->get();

        $kategoriList = KategoriSurat::all();
        $months = range(1, 12);
        $stackedChart = [];

        foreach ($kategoriList as $kategori) {
            $dataPerMonth = [];
            foreach ($months as $m) {
                $found = $stackedData->first(fn($row) => $row->kategori_id == $kategori->id && $row->bulan == $m);
                $dataPerMonth[] = $found ? $found->total : 0;
            }
            $stackedChart[] = [
                'label' => $kategori->nama,
                'data' => $dataPerMonth,
            ];
        }

        return view('user.page-user', compact(
            'kategoriLabels',
            'kategoriCounts',
            'stackedChart',
            'year'
        ));
    }
}
