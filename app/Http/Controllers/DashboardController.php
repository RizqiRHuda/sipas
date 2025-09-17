<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ArsipSurat;
use App\Models\KategoriSurat;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        
        // Statistik cepat
        $totalUsers    = User::count();
        // dd($totalUsers);
        $totalKategori = KategoriSurat::count();
        $totalDokumen  = ArsipSurat::count();

        // Jumlah dokumen per kategori (untuk bar chart)
        $dokumenPerKategori = KategoriSurat::withCount('arsip')->get();

        // Tahun dinamis untuk stacked bar (default tahun sekarang)
        $year = $request->get('year', date('Y'));

        // Query jumlah per kategori per bulan untuk tahun yg dipilih
        $dokumenKategoriBulanan = ArsipSurat::select(
                DB::raw('MONTH(created_at) as bulan'),
                'kategori_id',
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy('bulan', 'kategori_id')
            ->get();

        // List kategori (id => nama) untuk membuat dataset stacked
        $kategoriList = KategoriSurat::pluck('nama', 'id')->toArray();

        // Format data stacked: array of 12 rows, tiap row { bulan, kategori1: n, kategori2: m, ... }
        $dataStacked = [];
        foreach (range(1, 12) as $b) {
            $row = ['bulan' => $b];
            foreach ($kategoriList as $id => $nama) {
                $row[$nama] = $dokumenKategoriBulanan
                    ->where('bulan', $b)
                    ->where('kategori_id', $id)
                    ->sum('total');
            }
            $dataStacked[] = $row;
        }

        // Kirim ke view
        return view('home.dashboard', compact(
            'totalUsers',
            'totalKategori',
            'totalDokumen',
            'dokumenPerKategori',
            'dataStacked',
            'kategoriList',
            'year'
        ));
    }
}
