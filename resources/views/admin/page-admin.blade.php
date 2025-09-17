@extends('app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <!-- Hero Card -->
            <div class="card mb-4 bg-light">
                <div class="row g-0 align-items-center">
                    <!-- Ilustrasi -->
                    <div class="col-md-4 text-center p-3">
                        <img src="{{ asset('assets/img/logo/admin.png') }}" 
                             class="img-fluid rounded animate__animated animate__bounce" 
                             alt="Selamat Datang Admin">
                    </div>

                    <!-- Konten Sapaan -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title text-success fw-bold">Selamat Datang, Admin!</h2>
                            <p class="card-text text-muted mb-4">
                                Semoga hari Anda menyenangkan 🌿 <br>
                                Semua data desa tersedia di sini, mudah diakses dan dikelola.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                {{-- <a href="{{ route('arsip.index') }}" class="btn btn-success btn-lg shadow">
                                    Lihat Arsip Desa
                                </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Hero Card -->
        </div>
    </div>
</div>

<!-- Optional: Animasi Confetti ringan saat halaman dibuka -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        confetti({
            particleCount: 50,
            spread: 70,
            origin: { y: 0.6 }
        });
    });
</script>
@endsection
