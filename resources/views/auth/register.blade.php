{{-- File: resources\views\auth\register.blade.php --}}
{{-- Halaman pendaftaran (registrasi) aplikasi Edutrack - Redesigned --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Edutrack</title>

    <link rel="shortcut icon" href="http://127.0.0.1:8000/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:    #FAF8F5;
            --white:    #FFFFFF;
            --ink:      #1A1A2E;
            --ink-soft: #4A4A6A;
            --accent:   #3B82C4;
            --accent-2: #E8F0FB;
            --border:   #E4E1DB;
            --gold:     #C9A84C;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            overflow: hidden;
        }

        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(201,168,76,0.09) 0%, transparent 70%);
            top: -100px; left: -100px;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(59,130,196,0.10) 0%, transparent 70%);
            bottom: -80px; right: -80px;
        }

        /* Main card */
        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 980px;
            background: var(--white);
            border-radius: 28px;
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.04),
                0 20px 60px rgba(0,0,0,0.08),
                0 4px 12px rgba(0,0,0,0.04);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            animation: revealCard 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes revealCard {
            from { opacity: 0; transform: translateY(28px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* --- LEFT PANEL --- */
        .panel-left {
            position: relative;
            background: var(--ink);
            overflow: hidden;
            min-height: 620px;
        }

        .panel-left img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.45;
            mix-blend-mode: luminosity;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(150deg, rgba(201,168,76,0.20) 0%, transparent 50%),
                linear-gradient(to top, rgba(10,10,30,0.85) 0%, transparent 60%);
            z-index: 1;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            top: 28px; right: 28px;
            width: 60px; height: 60px;
            border-top: 2px solid rgba(201,168,76,0.6);
            border-right: 2px solid rgba(201,168,76,0.6);
            border-radius: 0 8px 0 0;
            z-index: 2;
        }

        /* Extra corner bottom-left */
        .corner-bl {
            position: absolute;
            bottom: 28px; left: 28px;
            width: 40px; height: 40px;
            border-bottom: 2px solid rgba(255,255,255,0.12);
            border-left: 2px solid rgba(255,255,255,0.12);
            border-radius: 0 0 0 8px;
            z-index: 2;
        }

        .panel-left-content {
            position: relative;
            z-index: 3;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.10);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            padding: 6px 14px 6px 8px;
            width: fit-content;
        }

        .brand-badge .material-symbols-outlined {
            font-size: 18px;
            color: var(--gold);
        }

        .brand-badge span.label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.85);
        }

        .panel-left-bottom .tagline {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            line-height: 1.15;
            color: #FFFFFF;
            margin-bottom: 14px;
        }

        .panel-left-bottom .tagline em {
            font-style: italic;
            color: var(--gold);
        }

        .panel-left-bottom p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
            max-width: 240px;
        }

        /* Steps / benefit list */
        .benefit-list {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.10);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .benefit-item .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
        }

        .benefit-item span {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.65);
        }

        /* --- RIGHT PANEL --- */
        .panel-right {
            padding: 44px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: revealRight 0.8s 0.15s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes revealRight {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .form-heading {
            margin-bottom: 24px;
        }

        .form-heading .eyebrow {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--accent);
            background: var(--accent-2);
            padding: 4px 10px;
            border-radius: 100px;
            margin-bottom: 12px;
        }

        .form-heading h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .form-heading p {
            font-size: 0.875rem;
            color: var(--ink-soft);
            margin-top: 6px;
        }

        /* Two column grid for name + email */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--ink-soft);
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px !important;
            color: #BDBDCE;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 40px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .form-control::placeholder { color: #B0AFBA; }

        .form-control:focus {
            border-color: var(--accent);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(59,130,196,0.10);
        }

        .field-wrap:focus-within .field-icon {
            color: var(--accent);
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #BDBDCE;
            display: flex;
            align-items: center;
            transition: color 0.2s;
            padding: 2px;
        }
        .pw-toggle:hover { color: var(--accent); }
        .pw-toggle .material-symbols-outlined { font-size: 19px !important; }

        /* Strength indicator */
        .strength-wrap {
            margin-top: 6px;
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .strength-bar {
            height: 3px;
            flex: 1;
            border-radius: 4px;
            background: var(--border);
            transition: background 0.3s;
        }
        .strength-label {
            font-size: 0.7rem;
            color: #BDBDCE;
            min-width: 52px;
            text-align: right;
        }

        /* Error */
        .error-msg {
            margin-top: 4px;
            font-size: 0.76rem;
            color: #DC3545;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Terms text */
        .terms-text {
            font-size: 0.76rem;
            color: var(--ink-soft);
            margin-bottom: 16px;
            line-height: 1.5;
        }
        .terms-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }
        .terms-text a:hover { text-decoration: underline; }

        /* Submit button */
        .btn-primary {
            width: 100%;
            padding: 13px 20px;
            background: var(--ink);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            letter-spacing: 0.02em;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: #2c2c4a;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(26,26,46,0.22);
        }

        .btn-primary:active { transform: translateY(0); }
        .btn-primary .material-symbols-outlined { font-size: 18px !important; }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 0.75rem;
            color: #BDBDCE;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* Google button */
        .btn-google {
            width: 100%;
            padding: 11px 20px;
            background: var(--white);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: border-color 0.2s, background 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-google:hover {
            border-color: #BDBDCE;
            background: var(--cream);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        }

        /* Login link */
        .login-row {
            text-align: center;
            margin-top: 16px;
            font-size: 0.82rem;
            color: var(--ink-soft);
        }

        .login-row a {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-row a:hover { color: #2a6aad; text-decoration: underline; }

        /* Responsive */
        @media (max-width: 720px) {
            .card { grid-template-columns: 1fr; }
            .panel-left { min-height: 220px; }
            .panel-left-content { padding: 28px; flex-direction: row; align-items: flex-end; }
            .brand-badge { display: none; }
            .panel-left-bottom .tagline { font-size: 1.6rem; }
            .benefit-list { display: none; }
            .panel-right { padding: 32px 24px; }
            .form-grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="card">

    {{-- LEFT PANEL --}}
    <div class="panel-left">
        <img src="{{ asset('images/register_edutrack.png') }}" alt="Register illustration">
        <div class="corner-bl"></div>
        <div class="panel-left-content">
            <div class="brand-badge">
                <span class="material-symbols-outlined">school</span>
                <span class="label">Edutrack</span>
            </div>
            <div class="panel-left-bottom">
                <h2 class="tagline">Bergabung<br>Bersama <em>Kami</em></h2>
                <p>Mulailah perjalanan belajar yang lebih terstruktur dan menyenangkan hari ini.</p>
                <div class="benefit-list">
                    <div class="benefit-item">
                        <div class="dot"></div>
                        <span>Akses ratusan kelas dari instruktur terbaik</span>
                    </div>
                    <div class="benefit-item">
                        <div class="dot"></div>
                        <span>Pantau progres belajar secara real-time</span>
                    </div>
                    <div class="benefit-item">
                        <div class="dot"></div>
                        <span>Sertifikat resmi setiap kali menyelesaikan kursus</span>
                    </div>
                    <div class="benefit-item">
                        <div class="dot"></div>
                        <span>Bergabung gratis, tanpa biaya pendaftaran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="panel-right">
        <div class="form-heading">
            <span class="eyebrow">Akun Baru</span>
            <h1>Buat Akun</h1>
            <p>Isi data diri Anda untuk memulai.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Name + Email in 2 columns --}}
            <div class="form-grid-2">
                <div class="form-group" style="margin-bottom:0">
                    <label for="name">Nama Lengkap</label>
                    <div class="field-wrap">
                        <input type="text" name="name" id="name" required
                               class="form-control"
                               placeholder="Budi Santoso"
                               value="{{ old('name') }}">
                        <span class="material-symbols-outlined field-icon">person</span>
                    </div>
                    @error('name')
                        <p class="error-msg"><span class="material-symbols-outlined" style="font-size:13px">error</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label for="email">Alamat Email</label>
                    <div class="field-wrap">
                        <input type="email" name="email" id="email" required
                               class="form-control"
                               placeholder="nama@contoh.com"
                               value="{{ old('email') }}">
                        <span class="material-symbols-outlined field-icon">mail</span>
                    </div>
                    @error('email')
                        <p class="error-msg"><span class="material-symbols-outlined" style="font-size:13px">error</span> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group" style="margin-top:14px">
                <label for="password">Kata Sandi</label>
                <div class="field-wrap">
                    <input type="password" name="password" id="password" required
                           class="form-control"
                           placeholder="Min. 8 karakter"
                           oninput="checkStrength(this.value)">
                    <span class="material-symbols-outlined field-icon">lock</span>
                    <button type="button" class="pw-toggle" onclick="togglePassword('password', this)">
                        <span class="material-symbols-outlined">visibility_off</span>
                    </button>
                </div>
                {{-- Password strength indicator --}}
                <div class="strength-wrap">
                    <div class="strength-bar" id="s1"></div>
                    <div class="strength-bar" id="s2"></div>
                    <div class="strength-bar" id="s3"></div>
                    <div class="strength-bar" id="s4"></div>
                    <span class="strength-label" id="strength-label"></span>
                </div>
                @error('password')
                    <p class="error-msg"><span class="material-symbols-outlined" style="font-size:13px">error</span> {{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <div class="field-wrap">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="form-control"
                           placeholder="Ulangi kata sandi">
                    <span class="material-symbols-outlined field-icon">lock_reset</span>
                    <button type="button" class="pw-toggle" onclick="togglePassword('password_confirmation', this)">
                        <span class="material-symbols-outlined">visibility_off</span>
                    </button>
                </div>
            </div>

            {{-- Terms --}}
            <p class="terms-text">
                Dengan mendaftar, Anda menyetujui
                <a href="#">Syarat dan Ketentuan</a> serta
                <a href="#">Kebijakan Privasi</a> kami.
            </p>

            {{-- Submit --}}
            <button type="submit" class="btn-primary">
                <span>Buat Akun Sekarang</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>

        {{-- Divider --}}
        <div class="divider"><span>atau</span></div>

        {{-- Google --}}
        <a href="{{ route('google.redirect') }}" class="btn-google">
            <svg width="18" height="18" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Daftar dengan Google
        </a>

        {{-- Login link --}}
        <p class="login-row">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>

</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }

    // Password strength checker
    function checkStrength(val) {
        const bars = [document.getElementById('s1'), document.getElementById('s2'),
                      document.getElementById('s3'), document.getElementById('s4')];
        const label = document.getElementById('strength-label');

        let score = 0;
        if (val.length >= 8)             score++;
        if (/[A-Z]/.test(val))           score++;
        if (/[0-9]/.test(val))           score++;
        if (/[^A-Za-z0-9]/.test(val))   score++;

        const colors  = ['#DC3545', '#FD7E14', '#3B82C4', '#28A745'];
        const labels  = ['Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
        const textCol = ['#DC3545', '#FD7E14', '#3B82C4', '#28A745'];

        bars.forEach((b, i) => {
            b.style.background = i < score ? colors[score - 1] : 'var(--border)';
        });

        if (val.length === 0) {
            label.textContent = '';
        } else {
            label.textContent = labels[score - 1] || 'Lemah';
            label.style.color = textCol[score - 1] || '#DC3545';
        }
    }
</script>
</body>
</html>