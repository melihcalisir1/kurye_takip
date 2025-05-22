<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurye Takip | Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            position: relative;
            overflow-x: hidden;
        }
        .wave-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 260px; z-index: 0;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .login-card {
            border: none;
            border-radius: 22px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
            background: #fff;
            padding: 2.5rem 2rem 2rem 2rem;
            width: 100%;
            max-width: 370px;
            position: relative;
        }
        .login-anim-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -60px auto 18px auto;
            box-shadow: 0 4px 16px 0 rgba(0,122,255,0.10);
            animation: bounce 1.8s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0);}
            50% { transform: translateY(-12px);}
        }
        .login-anim-icon svg {
            color: #fff;
            font-size: 2.7rem;
        }
        .login-title {
            font-weight: 700;
            color: #222B45;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 6px;
            font-size: 2rem;
        }
        .login-subtitle {
            color: #8F9BB3;
            text-align: center;
            font-size: 1.08rem;
            margin-bottom: 24px;
        }
        .form-label {
            font-weight: 600;
            color: #222B45;
        }
        .form-control {
            border-radius: 10px;
            font-size: 1.08rem;
            padding-left: 40px;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #007AFF;
            font-size: 1.2rem;
        }
        .input-group {
            position: relative;
        }
        .form-control:focus {
            border-color: #007AFF;
            box-shadow: 0 0 0 2px #007aff22;
        }
        .btn-primary {
            background: linear-gradient(90deg, #007AFF 0%, #00C6FB 100%);
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border-radius: 10px;
            box-shadow: 0 2px 8px 0 rgba(0,122,255,0.10);
            transition: background 0.2s;
        }
        .btn-primary:hover, .btn-primary:focus {
            background: #007AFF !important;
        }
        .login-footer {
            color: #8F9BB3;
            font-size: 0.95rem;
            margin-top: 18px;
            text-align: center;
        }
        .forgot-link {
            display: block;
            text-align: right;
            margin-top: 6px;
            color: #007AFF;
            font-size: 0.98rem;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover {
            color: #005bb5;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Dalga SVG arka plan -->
    <div class="wave-bg">
        <svg viewBox="0 0 1440 260" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="#007AFF" fill-opacity="0.13" d="M0,160 C480,260 960,60 1440,160 L1440,0 L0,0 Z"></path>
            <path fill="#007AFF" fill-opacity="0.22" d="M0,120 C480,220 960,20 1440,120 L1440,0 L0,0 Z"></path>
        </svg>
    </div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-anim-icon mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1h10a.5.5 0 0 1 .5.5V3h1.293a1 1 0 0 1 .707.293l2.207 2.207A1 1 0 0 1 15.5 6V13a1 1 0 0 1-1 1H14a2 2 0 1 1-4 0H6a2 2 0 1 1-4 0H1a1 1 0 0 1-1-1V1.5zm1 .5v11a.5.5 0 0 0 .5.5h.5a2 2 0 1 1 4 0h4a2 2 0 1 1 4 0h.5a.5.5 0 0 0 .5-.5V6.414a.5.5 0 0 0-.146-.354l-2.207-2.207A.5.5 0 0 0 12.293 3H11V2H1.5a.5.5 0 0 0-.5.5z"/>
                </svg>
            </div>
            <div class="login-title">Kurye Takip</div>
            <div class="login-subtitle">Hesabınıza giriş yapın</div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 input-group">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.383V5.383zm-.034 7.434-5.482-3.29-5.482 3.29A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.183zM1 5.383v6l4.708-3.175L1 5.383z"/>
                        </svg>
                    </span>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="E-posta">
                </div>
                <div class="mb-3 input-group">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                            <path d="M8 1a3 3 0 0 0-3 3v3H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2h-1V4a3 3 0 0 0-3-3zm-2 3a2 2 0 1 1 4 0v3H6V4zm-2 5a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9z"/>
                        </svg>
                    </span>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Şifre">
                </div>
                <a href="#" class="forgot-link">Şifremi unuttum</a>
                <button type="submit" class="btn btn-primary w-100 py-2 mt-3">Giriş Yap</button>
            </form>
            <div class="login-footer mt-3">
                © 2025 Kurye Takip
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 