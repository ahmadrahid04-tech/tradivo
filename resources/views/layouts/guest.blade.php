<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk — Tradivo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <a href="{{ route('home') }}" class="navbar-brand" style="justify-content:center; margin-bottom:1rem;">
                    <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                        <rect width="32" height="32" rx="8" fill="#4f46e5"/>
                        <path d="M8 12h16M8 20h10" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="24" cy="20" r="3" fill="#34d399"/>
                    </svg>
                    Tradivo
                </a>
                <h1>@yield('auth_title')</h1>
                <p>@yield('auth_subtitle')</p>
            </div>

            @if(session('error'))
                <div style="background:#ffe4e6; color:#9f1239; padding:0.75rem 1rem; border-radius:var(--radius-md); margin-bottom:1rem; font-size:0.875rem; font-weight:500;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
