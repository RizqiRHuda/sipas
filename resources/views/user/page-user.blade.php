@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hero Card -->
    <div class="card mb-4 bg-light shadow-sm rounded-3 border-0">
        <div class="row g-0 align-items-center">
            <div class="col-md-4 text-center p-4">
                <img src="{{ asset('assets/img/logo/team.png') }}"
                    class="img-fluid rounded animate__animated animate__fadeIn"
                    alt="Selamat Datang User">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title text-primary fw-bold">Halo, Selamat Datang!</h2>
                    <p class="card-text text-muted mb-4">
                        Senang melihat Anda kembali 🌟 <br>
                        Silakan gunakan menu di dashboard untuk melihat informasi dan dokumen desa.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- /Hero Card -->

    <div class="row g-4">
        <!-- Grafik Jumlah Dokumen per Kategori -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">Jumlah Dokumen per Kategori</div>
                <div class="card-body">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Stacked Bar Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <span class="fw-bold">Jumlah Dokumen per Kategori per Bulan ({{ $year }})</span>
                    <form method="GET" action="{{ route('dashboard-user.index') }}">
                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                            @for($y = now()->year; $y >= now()->year - 5; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <canvas id="stackedBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart (Jumlah Dokumen per Kategori)
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: @json($kategoriLabels),
            datasets: [{
                label: 'Jumlah Dokumen',
                data: @json($kategoriCounts),
                backgroundColor: '#4e73df',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Stacked Bar Chart (Jumlah Dokumen per Kategori per Bulan)
    new Chart(document.getElementById('stackedBarChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: @json($stackedChart).map((item, i) => ({
                label: item.label,
                data: item.data,
                backgroundColor: `hsl(${i * 60}, 70%, 60%)`
            }))
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { x: { stacked: true }, y: { stacked: true } }
        }
    });
</script>
@endsection
