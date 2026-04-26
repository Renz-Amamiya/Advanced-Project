<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi | Panel Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.08); }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,.05); border-radius: 8px; }
        .step-item { border-left: 4px solid #0d6efd; background-color: #fff; padding: 20px; margin-bottom: 20px; border-radius: 0 8px 8px 0; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .step-header { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        pre { background-color: #f1f3f5; padding: 15px; border-radius: 5px; font-size: 14px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container px-4 px-lg-5">
            <a href="{{ route('master.index') }}" class="btn btn-light btn-sm fw-bold me-3">⬅ Kembali</a>
            <span class="navbar-brand mb-0 h1 fs-6">Target: {{ $master->judul ?? 'Detail Tutorial' }}</span>
        </div>
    </nav>

    <div class="container px-4 px-lg-5 pb-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Panel Tambah Langkah -->
            <div class="col-md-4 mb-4">
                <div class="card p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">+ Tambah Langkah</h5>

                    <form action="{{ route('detail.store', $master->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Urutan (Order)</label>
                            <input type="number" name="order" class="form-control" required value="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Teks Penjelasan</label>
                            <textarea name="text" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Code Snippet</label>
                            <textarea name="code" class="form-control text-monospace" rows="4" placeholder="Masukkan kode program"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Upload Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">URL Referensi</label>
                            <input type="url" name="url" class="form-control" placeholder="https://...">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Materi</button>
                    </form>
                </div>
            </div>

            <!-- Panel Daftar Langkah -->
            <div class="col-md-8">
                <div class="card p-4 bg-transparent shadow-none">
                    <h5 class="fw-bold mb-3">Daftar Langkah Tutorial</h5>

                    @if($details->count() == 0)
                        <div class="alert alert-secondary">Belum ada langkah materi yang ditambahkan.</div>
                    @endif

                    @foreach($details as $detail)
                    <div class="step-item">
                        <div class="step-header">
                            <h5 class="m-0 fw-bold text-primary">Langkah {{ $detail->order }}</h5>
                            
                            <div class="d-flex gap-2">
                                <form action="{{ route('detail.updateStatus', $detail->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm {{ $detail->status == 'show' ? 'bg-success text-white border-success' : 'bg-secondary text-white border-secondary' }}" onchange="this.form.submit()">
                                        <option value="show" {{ $detail->status == 'show' ? 'selected' : '' }} class="bg-white text-dark">Show</option>
                                        <option value="hide" {{ $detail->status == 'hide' ? 'selected' : '' }} class="bg-white text-dark">Hide</option>
                                    </select>
                                </form>

                                <form action="{{ route('detail.destroy', $detail->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus langkah ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </div>

                        <div class="step-body mt-3">
                            @if(!empty($detail->text))
                                <p class="mb-3">{{ $detail->text }}</p>
                            @endif

                            @if(!empty($detail->code))
                                <pre><code>{{ $detail->code }}</code></pre>
                            @endif

                            @if(!empty($detail->image))
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $detail->image) }}" alt="Gambar Langkah" class="img-fluid rounded border" style="max-height: 400px;">
                                </div>
                            @endif

                            @if(!empty($detail->url))
                                <a href="{{ $detail->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Buka Link Referensi</a>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>