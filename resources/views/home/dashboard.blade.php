@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Hero Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4 bg-white rounded-3">
                <div class="row g-0 align-items-center">
                    
                    <!-- Ilustrasi -->
                    <div class="col-md-4 text-center p-4 border-end d-none d-md-block">
                        <img src="{{ asset('assets/img/logo/admin.png') }}" 
                             class="img-fluid rounded-3 animate__animated animate__fadeInLeft" 
                             alt="Selamat Datang Admin"
                             style="max-height: 220px; object-fit: contain;">
                    </div>

                    <!-- Konten Sapaan -->
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h2 class="card-title text-success fw-bold mb-2">
                                👋 Selamat Datang, Admin Desa
                            </h2>
                            <p class="card-text text-secondary mb-4 fs-6">
                                Semua data desa tersedia di sini. <br>
                                Kelola arsip, kategori, dan informasi dengan mudah serta cepat.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('arsip.create') }}" class="btn btn-success shadow-sm px-4">
                                    <i class="bx bx-folder-open me-1"></i> Lihat Arsip
                                </a>
                                <a href="{{ route('kategori-surat.index') }}" class="btn btn-outline-success shadow-sm px-4">
                                    <i class="bx bx-category me-1"></i> Kelola Kategori
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Cepat --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0 text-center bg-light-green rounded-3">
                <h6 class="text-muted">Total User</h6>
                <p class="fs-3 fw-bold text-success">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0 text-center bg-light rounded-3">
                <h6 class="text-muted">Total Kategori</h6>
                <p class="fs-3 fw-bold text-primary">{{ $totalKategori }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 shadow-sm border-0 text-center bg-light rounded-3">
                <h6 class="text-muted">Total Dokumen</h6>
                <p class="fs-3 fw-bold text-dark">{{ $totalDokumen }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik Jumlah Dokumen per Kategori --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">📊 Jumlah Dokumen per Kategori</h5>
            <canvas id="barKategori"></canvas>
        </div>
    </div>

    {{-- Grafik Jumlah Dokumen per Kategori per Bulan (Stacked Bar) --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">📅 Jumlah Dokumen per Kategori per Bulan ({{ $year }})</h5>

            <form method="GET" class="mb-3">
                <label for="year" class="me-2">Pilih Tahun:</label>
                <select name="year" id="year" class="form-select form-select-sm w-auto d-inline" onchange="this.form.submit()">
                    @foreach(range(date('Y'), date('Y')-5) as $thn)
                        <option value="{{ $thn }}" {{ $year == $thn ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </form>

            <canvas id="stackedBar"></canvas>
        </div>
    </div>
</div>

{{-- Confetti Animasi --}}
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            confetti({
                particleCount: 40,
                spread: 70,
                origin: { y: 0.6 }
            });
        }, 500);
    });
</script>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Bar Chart
    const ctxBar = document.getElementById('barKategori').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dokumenPerKategori->pluck('nama')) !!},
            datasets: [{
                label: 'Jumlah Dokumen',
                data: {!! json_encode($dokumenPerKategori->pluck('arsip_count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Data Stacked Bar
    const ctxStacked = document.getElementById('stackedBar').getContext('2d');
    new Chart(ctxStacked, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_map(fn($m) => date("M", mktime(0, 0, 0, $m, 1)), range(1, 12))) !!},
            datasets: [
                @foreach($kategoriList as $nama)
                {
                    label: "{{ $nama }}",
                    data: {!! json_encode(array_column($dataStacked, $nama)) !!},
                    backgroundColor: 'rgba({{ rand(50,200) }}, {{ rand(50,200) }}, {{ rand(50,200) }}, 0.7)',
                    borderRadius: 4
                },
                @endforeach
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
</script>
@endsection
