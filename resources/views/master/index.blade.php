<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Tutorial | Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.08); }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05); border-radius: 8px; }
        .table-responsive { margin-top: 15px; }
        .table thead th { background-color: #f1f3f5; color: #495057; font-weight: 600; text-transform: uppercase; font-size: 13px; }
        .btn-action { padding: 4px 10px; font-size: 13px; border-radius: 4px; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">WebTutorial Admin</a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3">{{ session('user_email') }}</span>
                <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0 fw-bold text-dark">Daftar Master Tutorial</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    + Tambah Tutorial
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table id="tabelTutorial" class="table table-hover align-middle border">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul</th>
                            <th width="15%">Kode MK</th>
                            <th width="20%">Creator</th>
                            <th width="30%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutorials as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="fw-semibold">{{ $item->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kode_mk }}</span></td>
                            <td class="text-muted small">{{ $item->creator_email }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="/{{ $item->url_presentation }}" target="_blank" class="btn-action btn btn-info text-white">Lihat Presentasi</a>
                                    <a href="/{{ $item->url_finished }}" target="_blank" class="btn-action btn btn-success">Cetak PDF</a>
                                    <a href="{{ route('detail.index', $item->id) }}" class="btn-action btn btn-warning">Kelola Materi</a>
                                    <form action="{{ route('master.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tutorial ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn btn-danger border-0">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('master.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold">Tambah Tutorial Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-0">
                        <div class="mb-3">
                            <label class="form-label text-muted">Judul Tutorial</label>
                            <input type="text" name="judul" class="form-control" placeholder="Contoh: Belajar API Laravel" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Mata Kuliah</label>
                            <select name="kode_mk" class="form-select" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                @if(!empty($makuls) && is_array($makuls))
                                    @foreach($makuls as $mk)
                                        @php 
                                            $kode = $mk['kdmk'] ?? $mk['kode_mk'] ?? $mk['id_mk'] ?? $mk['kode'] ?? ''; 
                                            $nama = $mk['nama'] ?? $mk['nama_mk'] ?? $mk['nama_matkul'] ?? 'Mata Kuliah';
                                        @endphp
                                        @if($kode != '')
                                            <option value="{{ $kode }}">{{ $kode }} - {{ $nama }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="" disabled class="text-danger">Gagal memuat mata kuliah. Silakan login ulang.</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() { 
            $('#tabelTutorial').DataTable({ 
                "pageLength": 10,
                "language": { "search": "Cari:" } 
            }); 
        });
    </script>
</body>
</html>