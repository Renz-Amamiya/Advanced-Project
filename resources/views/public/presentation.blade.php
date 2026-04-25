<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $master->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    
    <script>
        setTimeout(function() {
            location.reload();
        }, 10000); 
    </script>
</head>
<body class="bg-light pb-5">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="mb-1">{{ $master->judul }}</h3>
                <p class="text-muted border-bottom pb-3">
                    Kode MK: {{ $master->kode_mk }} | Dibuat oleh: {{ $master->creator_email }}
                    <br><small class="text-info">Halaman ini auto-refresh untuk memuat langkah terbaru.</small>
                </p>

                <div class="mt-4">
                    @forelse($details as $detail)
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-white fw-bold">
                                Langkah {{ $detail->order }}
                            </div>
                            <div class="card-body">
                                @if($detail->text) 
                                    <p>{{ $detail->text }}</p> 
                                @endif
                                
                                @if($detail->gambar) 
                                    <img src="{{ asset('storage/' . $detail->gambar) }}" class="img-fluid rounded mb-3"> 
                                @endif
                                
                                @if($detail->code) 
                                    <pre><code class="language-php">{{ $detail->code }}</code></pre> 
                                @endif
                                
                                @if($detail->url) 
                                    <a href="{{ $detail->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Link Referensi</a> 
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">Belum ada langkah yang ditampilkan oleh dosen.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>
</html>