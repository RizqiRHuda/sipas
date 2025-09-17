@extends('app')

@section('content')
<div class="container py-4">

    <!-- Heading -->
    <div class="mb-4">
        <h4 class="fw-bold">Kategori Surat &raquo; Tambah</h4>
        <p class="text-muted mb-0">Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa klik tombol <span class="badge bg-success">Simpan</span>.</p>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ isset($kategori) ? route('kategori-surat.update', $kategori->id) : route('kategori-surat.store') }}" method="POST">
                @csrf
                @if(isset($kategori))
                    @method('PUT')
                @endif

                <!-- ID (Readonly) -->
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">ID Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $kategori->id ?? 'Auto Generate' }}" readonly>
                    </div>
                </div>

                <!-- Nama Kategori -->
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama kategori" value="{{ old('nama', $kategori->nama ?? '') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-3 row">
                    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Masukkan keterangan">{{ old('keterangan', $kategori->keterangan ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="text-end">
                    <a href="{{ route('kategori-surat.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('js')
<script>
    // Tambahan interaktivitas jika perlu
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            // Bisa ditambahkan loader atau disable tombol simpan
        });
    });
</script>
@endpush
@endsection
