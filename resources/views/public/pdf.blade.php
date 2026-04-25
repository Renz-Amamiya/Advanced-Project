<!DOCTYPE html>
<html>
<head>
    <title>Tutorial: {{ $master->judul }}</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .step-container { margin-bottom: 25px; border: 1px solid #ccc; padding: 15px; border-radius: 5px; }
        .step-title { font-weight: bold; font-size: 18px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;}
        pre { background-color: #f4f4f4; padding: 10px; border-radius: 4px; font-size: 12px; }
        img { max-width: 100%; height: auto; margin-bottom: 10px; }
        .link { color: blue; text-decoration: underline; }
    </style>
</head>
<body>

    <div class="header">
        <h2>{{ $master->judul }}</h2>
        <p>Mata Kuliah: {{ $master->kode_mk }} | Dosen: {{ $master->creator_email }}</p>
    </div>

    @foreach($details as $detail)
    <div class="step-container">
        <div class="step-title">Langkah {{ $detail->order }}</div>
        
        @if($detail->text)
            <p>{{ $detail->text }}</p>
        @endif

        @if($detail->gambar)
            <img src="{{ public_path('storage/' . $detail->gambar) }}" alt="Gambar Langkah {{ $detail->order }}">
        @endif

        @if($detail->code)
            <pre>{{ $detail->code }}</pre>
        @endif

        @if($detail->url)
            <p>Referensi: <a class="link" href="{{ $detail->url }}">{{ $detail->url }}</a></p>
        @endif
    </div>
    @endforeach

</body>
</html>