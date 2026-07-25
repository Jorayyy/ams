<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sagkahan NHS Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .login-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%; max-width: 400px; box-sizing: border-box; }
        .header { text-align: center; margin-bottom: 24px; }
        .logo { background: #4f46e5; color: white; padding: 8px 12px; border-radius: 8px; font-size: 1.25rem; font-weight: bold; display: inline-block; margin-bottom: 12px; }
        .title { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0; }
        .subtitle { font-size: 0.813rem; color: #64748b; margin-top: 4px; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; }
        .form-input { width: 100%; box-sizing: border-box; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; font-size: 0.875rem; outline: none; }
        .form-input:focus { border-color: #4f46e5; background: white; }
        .btn-login { width: 100%; background: #4f46e5; color: white; border: none; font-weight: 700; font-size: 0.875rem; padding: 12px; border-radius: 12px; cursor: pointer; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2); margin-bottom: 12px; }
        .btn-login:hover { background: #4338ca; }
        .btn-back { display: block; text-align: center; width: 100%; box-sizing: border-box; background: transparent; border: 1px solid #cbd5e1; color: #475569; font-weight: 600; font-size: 0.875rem; padding: 11px; border-radius: 12px; text-decoration: none; transition: background 0.2s; }
        .btn-back:hover { background: #f1f5f9; color: #0f172a; }
        .error-banner { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px; border-radius: 12px; font-size: 0.813rem; font-weight: 500; margin-bottom: 16px; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="header">
            <div class="logo">📋</div>
            <h2 class="title">Sagkahan NHS Portal</h2>
            <p class="subtitle">Attendance Management Access Panel</p>
        </div>

        @if($errors->any())
            <div class="error-banner">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" required placeholder="teacher@sagkahan.edu.ph" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="form-input">
            </div>
            
            <button type="submit" class="btn-login">Sign In to Dashboard</button>
            
            <!-- Clean direct link route out back to the main landing page view matrix -->
            <a href="{{ route('welcome') }}" class="btn-back">← Back to Welcome Page</a>
        </form>
    </div>

</body>
</html>
