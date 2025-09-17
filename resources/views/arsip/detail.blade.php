@extends('app')

@section('content')
    <div class="container mt-4">

        <!-- Breadcrumbs -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('arsip.index') }}">Arsip Surat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lihat</li>
            </ol>
        </nav>

        <!-- Heading -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">Detail Arsip Surat</h4>
        </div>

        <!-- Card Detail -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold">Nomor Surat</div>
                    <div class="col-md-9">{{ $arsip->nomor_surat }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold">Kategori</div>
                    <div class="col-md-9">{{ $arsip->kategori->nama ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 fw-bold">Judul</div>
                    <div class="col-md-9">{{ $arsip->judul }}</div>
                </div>
                <div class="row">
                    <div class="col-md-3 fw-bold">Waktu Pengerjaan</div>
                    <div class="col-md-9">{{ $arsip->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- PDF Viewer -->
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">File Surat</h6>
                <div class="ratio ratio-16x9 border">
                    <iframe src="{{ asset('storage/arsip/' . $arsip->file_surat) }}" width="100%" height="500"></iframe>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('arsip.index') }}" class="btn btn-secondary">
                << Kembali </a>
                    <div>
                        <a href="{{ route('arsip.download', $arsip->id) }}" target="_blank" class="btn btn-success">
                            <i class="bx bx-download"></i> Unduh
                        </a>
                        @if (auth()->user()->role == 'admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editArsipModal{{ $arsip->id }}">
                                <i class="bx bx-edit"></i> Edit / Ganti File
                            </button>
                        @endif
                    </div>
        </div>
    </div>

    @if (auth()->user()->role == 'admin')
        <!-- Modal -->
        <div class="modal fade" id="editArsipModal{{ $arsip->id }}" tabindex="-1"
            aria-labelledby="editArsipModalLabel{{ $arsip->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('arsip.update-file', $arsip->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="editArsipModalLabel{{ $arsip->id }}">Edit Arsip Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control"
                                    value="{{ $arsip->nomor_surat }}" required>
                            </div>
                           <div class="mb-3">
    <label for="kategori_id" class="form-label">Kategori</label>
    <select name="kategori_id" id="kategori_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($kategoriList as $kategori)
            <option value="{{ $kategori->id }}" 
                {{ $arsip->kategori_id == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>

                            <div class="mb-3">
                                <label>Judul</label>
                                <input type="text" name="judul" class="form-control" value="{{ $arsip->judul }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label>File Surat (PDF)</label>
                                <input type="file" name="file_surat" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @push('js')
    @endpush
@endsection
