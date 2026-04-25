<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Detail - {{ $master->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('master.index') }}">⬅ Kembali ke Master</a>
            <span class="text-light">Detail: {{ $master->judul }}</span>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Tambah Langkah Baru</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('detail.store', $master->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Urutan (Order)</label>
                                <input type="number" name="order" class="form-control" required value="1">
                            </div>
                            <div class="mb-3">
                                <label>Teks Penjelasan</label>
                                <textarea name="text" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Code Snippet</label>
                                <textarea name="code" class="form-control text-monospace" rows="4" placeholder="Misal: <?php echo 'Hello'; ?>"></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label>URL Referensi</label>
                                <input type="url" name="url" class="form-control" placeholder="http://...">
                            </div>
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="show">Show</option>
                                    <option value="hide">Hide</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan Langkah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Daftar Langkah Tutorial</h6>
                    </div>
                    <div class="card-body">
                        @forelse($details as $detail)
                            <div class="border rounded p-3 mb-3 bg-white position-relative">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <strong>Langkah {{ $detail->order }}</strong>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('detail.updateStatus', $detail->id) }}" method="POST">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm {{ $detail->status == 'show' ? 'bg-success text-white' : 'bg-secondary text-white' }}" onchange="this.form.submit()">
                                                <option value="show" {{ $detail->status == 'show' ? 'selected' : '' }}>Show</option>
                                                <option value="hide" {{ $detail->status == 'hide' ? 'selected' : '' }}>Hide</option>
                                            </select>
                                        </form>
                                        
                                        <form action="{{ route('detail.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Hapus langkah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                                
                                @if($detail->text) <p>{{ $detail->text }}</p> @endif
                                
                                @if($detail->gambar) 
                                    <img src="{{ asset('storage/' . $detail->gambar) }}" class="img-fluid rounded mb-2" style="max-height: 200px;"> 
                                @endif
                                
                                @if($detail->code) 
                                    <pre><code class="language-php">{{ $detail->code }}</code></pre> 
                                @endif
                                
                                @if($detail->url) 
                                    <a href="{{ $detail->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Buka Link Referensi</a> 
                                @endif
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada detail langkah untuk tutorial ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>
</html>