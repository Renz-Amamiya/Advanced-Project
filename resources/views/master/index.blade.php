<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Master Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Web Presentation App</a>
            <div class="d-flex">
                <span class="text-light me-3 mt-2">{{ session('user_email') }}</span>
                <a href="{{ route('logout') }}" class="btn btn-danger btn-sm mt-1">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Master Tutorial</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#tambahModal">
                    + Tambah Tutorial
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table id="tabelTutorial" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kode MK</th>
                                <th>Creator</th>
                                <th>URL Presentation</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorials as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kode_mk }}</td>
                                <td>{{ $item->creator_email }}</td>
                                <td>
                                    <a href="/{{ $item->url_presentation }}" target="_blank" class="btn btn-info btn-sm">Lihat Web</a>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="/{{ $item->url_presentation }}" target="_blank" class="btn btn-info btn-sm text-white">View Web</a>
                                    <a href="{{ route('detail.index', $item->id) }}" class="btn btn-warning btn-sm">Kelola Detail</a>
                                    <form action="{{ route('master.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('master.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Master Tutorial</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Judul Tutorial</label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Hello World dengan PHP">
                        </div>
                        <div class="mb-3">
                            <label>Mata Kuliah (Dari API)</label>
                            <select name="kode_mk" class="form-select" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                @foreach($makuls as $mk)
                                    <option value="{{ $mk['kdmk'] }}">{{ $mk['kdmk'] }} - {{ $mk['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info" style="font-size: 13px;">
                            Email Creator, URL Presentation, dan URL Finished akan di-generate otomatis oleh sistem.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
            // Inisialisasi DataTable
            $('#tabelTutorial').DataTable();
        });
    </script>
</body>
</html>