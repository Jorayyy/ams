<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Sagkahan NHS Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; line-height: 1.5; }
        .hero-section { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 80px 24px; text-align: center; position: relative; overflow: hidden; }
        .hero-section::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at top right, rgba(255,255,255,0.1) 0%, transparent 60%); pointer-events: none; }
        .nav-landing { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; background: white; border-bottom: 1px solid #e2e8f0; }
        .nav-brand { font-weight: 800; font-size: 1.25rem; color: #0f172a; display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-portal { background: #4f46e5; color: white; font-weight: 700; padding: 10px 24px; border-radius: 12px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(79,70,229,0.2); transition: all 0.2s; }
        .btn-portal:hover { background: #4338ca; transform: translateY(-1px); }
        .container { max-width: 1200px; margin: 48px auto; padding: 0 24px; }
        .badge-tag { display: inline-block; background: rgba(255,255,255,0.15); color: white; padding: 6px 16px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; backdrop-filter: blur(4px); }
        .hero-title { font-size: 2.75rem; font-weight: 800; margin: 0 0 16px 0; tracking: -0.025em; line-height: 1.2; }
        .hero-desc { font-size: 1.125rem; max-width: 600px; margin: 0 auto 32px auto; color: #bfdbfe; font-weight: 500; }
        .grid-features { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-top: 48px; }
        .feature-card { background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); transition: transform 0.2s; }
        .feature-card:hover { transform: translateY(-4px); }
        .feature-icon { font-size: 1.75rem; background: #f1f5f9; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; margin-bottom: 20px; }
        .feature-name { font-size: 1.125rem; font-weight: 700; color: #0f172a; margin: 0 0 8px 0; }
        .feature-desc { font-size: 0.875rem; color: #64748b; margin: 0; }
    </style>
</head>
<body>

    <!-- Cleaned Navigation Bar: Removed top-right duplicate button -->
    <nav class="nav-landing">
        <a href="#" class="nav-brand">
            <span style="background: #4f46e5; color: white; padding: 6px 10px; border-radius: 8px; font-size: 0.875rem;">📋</span>
            <span>Sagkahan National High School</span>
        </a>
    </nav>

    <!-- Hero Section with Single, Prominent Access Point -->
    <header class="hero-section">
        <span class="badge-tag">Official Administrative App</span>
        <h1 class="hero-title">Student Attendance<br>Management System</h1>
        <p class="hero-desc">An institutional framework engineered for accurate rolling count records, dynamic analytics reporting, and structural access metrics.</p>
        <a href="{{ route('login') }}" class="btn-portal" style="background: white; color: #1e3a8a; font-size: 1rem; padding: 14px 36px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">Launch Application Portal</a>
    </header>

    <main class="container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto;">
            <h2 style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0;">Designed for Institutional Excellence</h2>
            <p style="color: #64748b; font-size: 0.938rem; margin: 8px 0 0 0;">Streamlining daily secondary class attendance logging to maximize data integrity and optimize school-wide administrative overhead.</p>
        </div>

        <div class="grid-features">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h4 class="feature-name">Instant Tracking Sheet</h4>
                <p class="feature-desc">Interactive, high-speed radio checkbox matrices with smart-save states that transform inputs immediately into persistent status badges.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h4 class="feature-name">Visual Trend Analytics</h4>
                <p class="feature-desc">Automated, proportional data charts that track class behaviors and instantly highlight your highest and lowest section attendance rates.</p>
            </div>

                        <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h4 class="feature-name">Granular Access Control</h4>
                <p class="feature-desc">Enforced middleware guard infrastructure mapping distinct operation levels separating high-level Admins from regular Class Instructors.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🖨️</div>
                <h4 class="feature-name">Official Reporting Forms</h4>
                <p class="feature-desc">Built-in browser print matrix styling overrides that output historical summaries cleanly formatted into professional school documents.</p>
            </div>
        </div>

        <!-- Institutional Properties Overview Bar -->
        <section style="margin-top: 64px; background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; display: flex; flex-wrap: wrap; justify-content: space-around; gap: 24px; text-align: center;">
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #4f46e5; margin: 0;">100%</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Offline Capable</p>
            </div>
            <div style="border-left: 1px solid #e2e8f0;"></div>
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #10b981; margin: 0;">SQLite</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Database File Architecture</p>
            </div>
            <div style="border-left: 1px solid #e2e8f0;"></div>
            <div>
                <p style="font-size: 1.75rem; font-weight: 800; color: #0f172a; margin: 0;">DepEd</p>
                <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; tracking: 0.05em; margin: 4px 0 0 0;">Compliance Parameters Map</p>
            </div>
        </section>
    </main>

    <footer style="border-top: 1px solid #e2e8f0; background: white; padding: 24px; text-align: center; margin-top: 80px;">
        <p style="font-size: 0.813rem; color: #94a3b8; margin: 0;">&copy; {{ date('Y') }} Sagkahan National High School. All rights reserved.</p>
        <p style="font-size: 0.75rem; color: #cbd5e1; margin: 4px 0 0 0;">Engineered via Laravel Core System App Infrastructure Framework</p>
    </footer>

</body>
</html>
