<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10">
    <title>{{ $master->judul ?? 'Tutorial Presentation' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Highlight.js Syntax Highlighter (Light theme for clean look) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
            padding: 40px 0;
        }

        .header-container {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 10px;
        }

        .meta-info {
            background: #fff;
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            color: #6c757d;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 15px;
        }

        .refresh-indicator {
            font-size: 12px;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .dot {
            height: 8px; width: 8px;
            background-color: #198754;
            border-radius: 50%;
            display: inline-block;
            animation: blink 1.5s infinite;
        }

        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

        .step-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 40px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .step-header {
            background: #0d6efd;
            color: white;
            padding: 15px 25px;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .step-body {
            padding: 30px;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        pre {
            background: #f1f3f5 !important;
            padding: 20px !important;
            border-radius: 8px !important;
            border: 1px solid #dee2e6 !important;
            font-size: 14px;
        }

        .btn-finish {
            background: #198754;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.2s;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
        }

        .btn-finish:hover {
            background: #146c43;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(25, 135, 84, 0.3);
        }

        .btn-disabled {
            background: #e9ecef;
            color: #adb5bd;
            padding: 15px 40px;
            font-size: 1.2rem;
            border-radius: 50px;
            border: none;
            font-weight: bold;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-container">
            <h1 class="page-title">{{ $master->judul ?? 'Judul Tutorial' }}</h1>
            <div class="meta-info">
                <strong>Kode MK:</strong> {{ $master->kode_mk ?? 'A11.XXXXX' }} &nbsp;|&nbsp; 
                <strong>Creator:</strong> {{ $master->creator_email ?? 'admin@mail.com' }}
            </div>  
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                @if(isset($details) && $details->count() > 0)
                    @foreach($details as $index => $detail)
                    <div class="step-card">
                        <div class="step-header">
                            Langkah {{ $index + 1 }}
                        </div>
                        
                        <div class="step-body">
                            @if(!empty($detail->text))
                                <p class="mb-4">{{ $detail->text }}</p>
                            @endif

                            @if(!empty($detail->code))
                                <pre><code>{{ $detail->code }}</code></pre>
                            @endif
                            
                            @if(!empty($detail->image))
                                <div class="mt-4 text-center">
                                    <img src="{{ asset('storage/' . $detail->image) }}" class="img-fluid rounded border" alt="Ilustrasi langkah">
                                </div>
                            @endif
                            
                            @if(!empty($detail->url))
                                <div class="mt-4">
                                    <a href="{{ $detail->url }}" target="_blank" class="btn btn-outline-primary btn-sm">Pelajari Lebih Lanjut (Referensi)</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted my-5 py-5">
                        <h4>Materi Belum Tersedia</h4>
                        <p>Dosen belum menambahkan atau menampilkan materi presentasi untuk sesi ini.</p>
                    </div>
                @endif

                <!-- Tombol Finish Conditional -->
                <div class="text-center mt-5 mb-5">
                    @if(isset($canFinish) && $canFinish)
                        <a href="{{ url($master->url_finished ?? '#') }}" class="btn-finish">Buka Versi Lengkap (PDF)</a>
                    @else
                        <button class="btn-disabled" disabled>Tutorial Belum Selesai</button>
                        <p class="text-muted mt-2 small">Menunggu dosen menyelesaikan seluruh materi presentasi...</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll(); 
        
        // Auto refresh
        setTimeout(function() {
            window.location.reload();
        }, 10000);
    </script>
</body>
</html>