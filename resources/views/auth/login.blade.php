<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Web Presentation App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .login-header {
            background-color: #0d6efd;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .login-header h4 {
            margin: 0;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="login-header">
            <h4>Sistem Presentasi</h4>
            <small>Silakan masuk ke akun Anda</small>
        </div>
        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>