@extends('app')

@section('content')
    <div class="container py-5">
        <!-- Heading dengan Gradient -->
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold"
                style="background: linear-gradient(90deg,#4b6cb7,#182848);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                About</h1>
            <p class="text-muted">Informasi pembuat aplikasi</p>
        </div>

        <!-- Card Biodata KTP -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card shadow-lg border-0" style="overflow:hidden; transition: transform 0.3s;"
                    onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="row g-0 align-items-center">
                        <!-- Foto di kiri -->
                        <div class="col-md-4">
                            <img src="{{ asset('profil/2141720264.jpg') }}" alt="Foto Profil" class="img-fluid h-100"
                                style="object-fit:cover;">
                        </div>

                        <!-- Info Biodata di kanan -->
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Aplikasi ini dibuat oleh</h5>

                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="bx bx-user me-2 text-primary"></i><strong>Nama:</strong>
                                        Rizqi Rohmatul Huda</li>
                                    <li class="mb-2"><i
                                            class="bx bx-bookmark me-2 text-primary"></i><strong>Prodi:</strong> D-IV Teknik
                                        Informatika</li>
                                    <li class="mb-2"><i class="bx bx-id-card me-2 text-primary"></i><strong>NIM:</strong>
                                        2141720264</li>
                                    <li class="mb-2"><i
                                            class="bx bx-calendar me-2 text-primary"></i><strong>Tanggal:</strong> 15
                                        September 2025</li>
                                </ul>

                                <div class="mt-3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Animasi fade-in card
        const card = document.querySelector('.card');
        card.style.opacity = 0;
        window.addEventListener('load', () => {
            card.style.transition = "opacity 1s";
            card.style.opacity = 1;
        });
    </script>
@endpush
