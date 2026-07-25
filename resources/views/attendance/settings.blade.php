<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        .nav-bar { background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 24px; height: 64px; }
        .nav-brand { font-weight: 700; font-size: 1.125rem; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 8px; background: #f1f5f9; padding: 4px; border-radius: 10px; align-items: center; }
        .nav-btn { color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; }
        .nav-btn:hover { color: #0f172a; }
        .nav-btn-active { background: white; color: #4f46e5; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .container { max-width: 700px; margin: 40px auto; padding: 0 24px; }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; text-transform: uppercase; tracking: 0.05em; }
        .form-input, .form-textarea { width: 100%; box-sizing: border-box; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; font-size: 0.875rem; font-weight: 500; color: #1e293b; outline: none; }
        .form-textarea { height: 100px; resize: vertical; }
        .btn-save { background: #4f46e5; color: white; border: none; font-weight: 700; font-size: 0.875rem; padding: 12px 24px; border-radius: 12px; cursor: pointer; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2); }
        .btn-save:hover { background: #4338ca; }
        .alert-success { background: #e6f4ea; border: 1px solid #a7f3d0; color: #137333; padding: 14px; border-radius: 12px; font-size: 0.875rem; font-weight: 600; margin-bottom: 20px; }
        .icon-svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <div class="nav-brand">
            <svg class="icon-svg" style="width:24px; height:24px; stroke:#4f46e5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Sagkahan NHS Admin</span>
        </div>
        <div class="nav-links">
            <a href="/dashboard" class="nav-btn">Dashboard</a>
            <a href="/students" class="nav-btn">Manage Students</a>
            <a href="/reports" class="nav-btn">Reports Ledger</a>
            <a href="/settings" class="nav-btn-active">Settings</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="nav-btn" style="background: none; border: none; cursor: pointer; font-weight: 600; color: #ef4444;">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                <svg class="icon-svg" style="width:20px; height:24px; stroke:#4f46e5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Landing Page Customization</span>
            </h2>
            <p style="font-size: 0.813rem; color: #94a3b8; margin: 0 0 24px 0;">Modify the school portal's hero graphics, typography, and background context layouts live.</p>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('attendance.save_settings') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Portal Hero Main Title</label>
                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" required class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Portal Hero Subtitle / Description</label>
                    <textarea name="hero_subtitle" required class="form-textarea">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Custom Background Hero Image</label>
                    <!-- Explicitly whitelists .jpeg extensions to bypass browser filter bugs -->
                    <input type="file" name="hero_image" accept=".jpeg,.jpg,.png" class="form-input" style="background:white; padding:8px;">
                    @if(isset($settings['hero_image']) && !empty($settings['hero_image']))
                        <p style="font-size: 0.75rem; color: #10b981; font-weight: 600; margin: 6px 0 0 0; display: inline-flex; align-items: center; gap: 4px;">
                            <svg class="icon-svg" style="stroke:#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Active background image: {{ $settings['hero_image'] }}</span>
                        </p>
                    @endif
                </div>

                <div style="display: flex; justify-content: flex-end; border-top: 1px solid #f1f5f9; padding-top: 18px;">
                    <button type="submit" class="btn-save">Apply Branding Settings</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
