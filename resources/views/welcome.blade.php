<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Sagkahan NHS Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; line-height: 1.5; }
        .hero-section { 
            background: {{ isset($settings['hero_image']) && !empty($settings['hero_image']) ? "url('/" . $settings['hero_image'] . "')" : "linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)" }}; 
            background-size: cover;
            background-position: center;
            color: white; 
            padding: 100px 24px; 
            text-align: center; 
            position: relative; 
        }
        /* Visual shading layer overlay to make text highly readable regardless of background image color */
        .hero-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); z-index: 1; }
        .hero-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
        .nav-landing { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: white; border-bottom: 1px solid #e2e8f0; }
        .nav-brand { font-weight: 800; font-size: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-portal { background: #4f46e5; color: white; font-weight: 700; padding: 14px 36px; border-radius: 12px; text-decoration: none; font-size: 1rem; box-shadow: 0 4px 12px rgba(79,70,229,0.25); display: inline-block; transition: all 0.2s; }
        .btn-portal:hover { background: #4338ca; transform: translateY(-1px); }
        .container { max-width: 1200px; margin: 48px auto; padding: 0 24px; }
        .badge-tag { display: inline-block; background: #4f46e5; color: white; padding: 6px 16px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; }
        .hero-title { font-size: 3rem; font-weight: 800; margin: 0 0 16px 0; tracking: -0.025em; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .hero-desc { font-size: 1.25rem; margin: 0 auto 32px auto; color: #f1f5f9; font-weight: 500; text-shadow: 0 1px 3px rgba(0,0,0,0.4); max-width: 650px; }
    </style>
</head>
<body>

    <nav class="nav-landing">
        <a href="#" class="nav-brand">
            <span style="background: #4f46e5; color: white; padding: 6px 10px; border-radius: 8px; font-size: 0.875rem;">📋</span>
            <span>Sagkahan National High School</span>
        </a>
    </nav>

    <header class="hero-section">
        @if(isset($settings['hero_image']) && !empty($settings['hero_image']))
            <div class="hero-overlay"></div>
        @endif
        <div class="hero-content">
            <span class="badge-tag" style="{{ isset($settings['hero_image']) && !empty($settings['hero_image']) ? 'background:#4f46e5;' : 'background:rgba(255,255,255,0.2);' }}">Official School Portal</span>
            <h1 class="hero-title">{{ $settings['hero_title'] ?? 'Student Attendance Management System' }}</h1>
            <p class="hero-desc">{{ $settings['hero_subtitle'] ?? 'An institutional framework engineered for accurate rolling count records.' }}</p>
            <a href="{{ route('login') }}" class="btn-portal" style="{{ isset($settings['hero_image']) && !empty($settings['hero_image']) ? '' : 'background:white; color:#1e3a8a;' }}">Launch Application Portal</a>
        </div>
    </header>

    <main class="container" style="text-align: center; margin-top: 64px;">
        <div style="max-width: 600px; margin: 0 auto 48px auto;">
            <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0;">Designed for Institutional Excellence</h2>
            <p style="color: #64748b; font-size: 0.938rem; margin: 8px 0 0 0;">Streamlining daily secondary class attendance logging to maximize data integrity and optimize school-wide administrative overhead.</p>
        </div>
    </main>
</body>
</html>
