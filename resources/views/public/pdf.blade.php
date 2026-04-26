<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Materi Lengkap - {{ $master->judul ?? 'Tutorial' }}</title>
    
    <!-- Highlight.js Syntax Highlighter (Light theme for PDF) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
    
    <style>
        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar dokumen formal */
            color: #000;
            margin: 0;
            padding: 30px;
            background: #e9ecef; 
        }

        .document-container {
            max-width: 800px; /* Ukuran mendekati A4 */
            margin: 0 auto;
            background: white;
            padding: 50px 60px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* --- Header Dokumen --- */
        .doc-header {
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 30px;
            text-align: center;
        }
        .doc-header h1 {
            font-size: 24px;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        .doc-header p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        /* --- Konten --- */
        .step-section {
            margin-bottom: 30px;
        }
        .step-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        p { 
            font-size: 16px; 
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        pre {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        img {
            max-width: 100%;
            border: 1px solid #ccc;
            margin-top: 10px;
        }
        
        .url-link {
            display: inline-block;
            margin-top: 10px;
            color: #0d6efd;
            text-decoration: underline;
            font-size: 14px;
        }

        /* --- Tombol Aksi Layar --- */
        .btn-print {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            margin: 0 auto 30px auto;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-print:hover {
            background: #0b5ed7;
        }

        /* --- ATURAN KHUSUS UNTUK CETAK PDF --- */
        @media print {
            @page { margin: 2cm; }
            body { background: white; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .document-container { box-shadow: none; padding: 0; max-width: 100%; }
            .btn-print { display: none; } 
        }
    </style>
</head>
<body> 

    <button class="btn-print" onclick="window.print()">Cetak sebagai PDF</button>

    <div class="document-container">
        <div class="doc-header">
            <h1>{{ $master->judul ?? 'Judul Tutorial' }}</h1>
            <p>Kode Mata Kuliah: {{ $master->kode_mk ?? '-' }} | Disusun oleh: {{ $master->creator_email ?? '-' }}</p>
        </div>

        @if(isset($details) && $details->count() > 0)
            @foreach($details as $detail)
            <div class="step-section">
                <div class="step-title">Langkah {{ $detail->order }}</div>
                
                @if(!empty($detail->text))
                    <p>{{ $detail->text }}</p>
                @endif

                @if(!empty($detail->code))
                    <pre><code>{{ $detail->code }}</code></pre>
                @endif

                @if(!empty($detail->image))
                    <div>
                        <img src="{{ asset('storage/' . $detail->image) }}" alt="Gambar Langkah {{ $detail->order }}">
                    </div>
                @endif

                @if(!empty($detail->url))
                    <div>
                        <a href="{{ $detail->url }}" class="url-link" target="_blank">Tautan Referensi: {{ $detail->url }}</a>
                    </div>
                @endif
            </div>
            @endforeach
        @else
            <p class="text-center">Materi tidak ditemukan atau belum ditambahkan.</p>
        @endif
    </div>

    <!-- Highlight.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
        // Beri jeda 0.5 detik agar Highlight.js selesai mewarnai sebelum dialog print muncul otomatis
        setTimeout(function() {
            window.print();
        }, 500);
    </script>
</body>
</html>