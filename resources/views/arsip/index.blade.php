@extends('app')

@section('content')
    <div class="container my-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Judul Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-primary mb-1">📂 Arsip Surat</h4>
                <p class="text-muted mb-0">
                    Berikut adalah surat-surat yang telah terbit dan diarsipkan.
                    Klik <span class="badge bg-info text-dark">Lihat</span> pada kolom aksi untuk menampilkan surat.
                </p>
            </div>
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('arsip.create') }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Arsipkan Surat
                </a>
            @endif
        </div>

        <!-- Search Bar -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('arsip.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="🔍 Cari surat berdasarkan judul, nomor surat, atau kategori...">
                            @if (request('search'))
                                <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary" title="reset">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- Tabel Arsip -->
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nomor Surat</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Waktu Pengerjaan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arsip as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration + ($arsip->currentPage() - 1) * $arsip->perPage() }}</td>
                                <td>{{ $item->nomor_surat }}</td>
                                <td>{{ $item->kategori->nama ?? '-' }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-center">
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('arsip.show', $item->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bx bx-show"></i> Lihat
                                    </a>

                                    <!-- Tombol Unduh -->
                                    <a href="{{ route('arsip.download', $item->id) }}" class="btn btn-sm btn-success"
                                        title="Unduh">
                                        <i class="bx bx-download"></i> Unduh
                                    </a>
                                    @if (auth()->user()->role == 'admin')
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('arsip.destroy', $item->id) }}" method="POST"
                                            class="d-inline form-hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada arsip surat</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-3">
                    {{ $arsip->links() }}
                </div>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // cegah submit langsung

                    Swal.fire({
                        title: 'Yakin ingin menghapus surat ini?',
                        text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // jalankan submit kalau user setuju
                        }
                    })
                });
            });
        </script>
    @endpush
@endsection
