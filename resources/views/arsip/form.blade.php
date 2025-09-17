@extends('app')

@section('content')
    <div class="container mt-4">

        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('arsip.index') }}">Arsip Surat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Unggah</li>
            </ol>
        </nav>

        {{-- Heading --}}
        <div class="card shadow-sm rounded-3">
            <div class="card-body">
                <h4 class="mb-2">Unggah Surat</h4>
                <p class="text-muted">
                    Unggah surat yang telah terbit pada form ini untuk diarsipkan. <br>
                    <small class="text-danger">Catatan: gunakan file dengan format <strong>PDF</strong>.</small>
                </p>

                {{-- Form --}}
                <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        {{-- Nomor Surat --}}
                        <div class="col-md-6">
                            <label for="nomor_surat" class="form-label">Nomor Surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                                placeholder="Contoh: 001/UND/IX/2025" required>
                        </div>

                        {{-- Kategori --}}
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Judul Surat --}}
                        <div class="col-12">
                            <label for="judul" class="form-label">Judul Surat</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                placeholder="Masukkan judul surat" required>
                        </div>

                        {{-- File Surat --}}
                        <div class="col-12">
                            <label for="file_surat" class="form-label">File Surat (PDF)</label>
                            <input type="file" class="form-control" id="file_surat" name="file_surat"
                                accept="application/pdf" required>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('arsip.index') }}" class="btn btn-secondary">&laquo; Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
