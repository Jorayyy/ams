<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Sagkahan NHS Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; line-height: 1.5; }
        
                .hero-section { 
            position: relative;
            background: {{ isset($settings['hero_image']) && !empty($settings['hero_image']) ? "url('" . asset($settings['hero_image']) . "')" : "linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)" }}; 
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            color: white; 
            padding: 120px 24px; 
            text-align: center; 
            min-height: 340px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        
        /* High-contrast shading overlay to ensure typography stays incredibly sharp over custom images */
        .hero-overlay { 
            position: absolute; 
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0; 
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.7)); 
            z-index: 1; 
        }
        
        .hero-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
        .nav-landing { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: white; border-bottom: 1px solid #e2e8f0; }
        .nav-brand { font-weight: 800; font-size: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-portal { background: #4f46e5; color: white; font-weight: 700; padding: 14px 36px; border-radius: 12px; text-decoration: none; font-size: 1rem; box-shadow: 0 4px 12px rgba(79,70,229,0.3); display: inline-block; transition: all 0.2s ease; border: 1px solid transparent; }
        .btn-portal:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,0.4); }
        .container { max-width: 1200px; margin: 64px auto; padding: 0 24px; }
        .badge-tag { display: inline-block; background: #4f46e5; color: white; padding: 6px 16px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .hero-title { font-size: 3.25rem; font-weight: 800; margin: 0 0 16px 0; tracking: -0.025em; line-height: 1.15; text-shadow: 0 2px 8px rgba(0,0,0,0.5); }
        .hero-desc { font-size: 1.25rem; margin: 0 auto 36px auto; color: #f8fafc; font-weight: 500; text-shadow: 0 1px 4px rgba(0,0,0,0.5); max-width: 680px; line-height: 1.4; }
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
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="badge-tag">Official School Portal</span>
            <h1 class="hero-title">{{ $settings['hero_title'] ?? 'Student Attendance Management System' }}</h1>
            <p class="hero-desc">{{ $settings['hero_subtitle'] ?? 'An institutional framework engineered for accurate rolling count records.' }}</p>
            <a href="{{ route('login') }}" class="btn-portal">Launch Application Portal</a>
        </div>
    </header>

        <main class="container" style="text-align: center;">
        <div style="max-width: 600px; margin: 0 auto 48px auto;">
            <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0;">Designed for Institutional Excellence</h2>
            <p style="color: #64748b; font-size: 0.938rem; margin: 8px 0 0 0;">Streamlining daily secondary class attendance logging to maximize data integrity and optimize school-wide administrative overhead.</p>
        </div>
        
        <!-- Institutional Properties Overview Bar -->
        <section style="margin-top: 64px; background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; display: flex; flex-wrap: wrap; justify-content: space-around; gap: 24px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #4f46e5; margin: 0;">100%</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Offline Capable</p>
            </div>
            <div style="border-left: 1px solid #e2e8f0;"></div>
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #10b981; margin: 0;">SQLite</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Database Architecture</p>
            </div>
            <div style="border-left: 1px solid #e2e8f0;"></div>
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0;">DepEd</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Compliance Parameters</p>
            </div>
        </section>
    </main>

    <footer style="border-top: 1px solid #e2e8f0; background: white; padding: 24px; text-align: center; margin-top: 80px;">
        <p style="font-size: 0.813rem; color: #94a3b8; margin: 0;">&copy; {{ date('Y') }} Sagkahan National High School. All rights reserved.</p>
        <p style="font-size: 0.75rem; color: #cbd5e1; margin: 4px 0 0 0;">Engineered via Laravel Core System App Infrastructure Framework</p>
    </footer>

</body>
</html>
