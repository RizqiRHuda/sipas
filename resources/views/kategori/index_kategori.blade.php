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
                <h4 class="fw-bold text-primary mb-1"> 📄 Kategori Surat</h4>
                <p class="text-muted mb-0">
                    Berikut ini adalah kategori surat yang bisa digunakan untuk melabeli surat.
                    Klik <span class="badge bg-info text-dark">Tambah</span> untuk menambahkan kategori baru.
                </p>
            </div>
            <a href="{{ route('kategori-surat.create') }}" class="btn btn-success btn-sm shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
            </a>
        </div>

        <!-- Search Bar -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('kategori-surat.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="🔍 Cari kategori...">

                            @if (request('search'))
                                <!-- Tombol Reset -->
                                <a href="{{ route('kategori-surat.index') }}" class="btn btn-outline-secondary"
                                    title="Reset">
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
                            <th scope="col">ID Kategori</th>
                            <th scope="col">Nama Kategori</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kategori)
                            <tr>
                                <td>{{ $kategori->id }}</td>
                                <td>{{ $kategori->nama }}</td>
                                <td style="max-width: 300px; white-space: normal; word-wrap: break-word;">
                                    {{ $kategori->keterangan }}
                                </td>

                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kategori-surat.edit', $kategori->id) }}"
                                        class="btn btn-sm btn-warning me-1">
                                     <i class="bx bx-edit"></i> Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kategori-surat.destroy', $kategori->id) }}" method="POST"
                                        class="d-inline form-hapus"> {{-- ✅ tambahkan class --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada data kategori surat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination (opsional, kalau pakai paginate()) -->
                <div class="mt-3">
                    @if (method_exists($kategoris, 'links'))
                        {{ $kategoris->links('pagination::bootstrap-5') }}
                    @endif
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
