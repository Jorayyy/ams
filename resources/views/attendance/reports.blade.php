<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Reports - Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        .nav-bar { background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 24px; height: 64px; }
        .nav-brand { font-weight: 700; font-size: 1.125rem; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 8px; background: #f1f5f9; padding: 4px; border-radius: 10px; }
        .nav-btn { color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; }
        .nav-btn:hover { color: #0f172a; }
        .nav-btn-active { background: white; color: #4f46e5; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .container { max-width: 1000px; margin: 32px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr; gap: 32px; }
        @media (min-width: 1024px) { .container { grid-template-columns: 1fr 1fr; } }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .chart-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .chart-date { font-size: 0.813rem; font-weight: 600; color: #475569; width: 110px; }
        .chart-track { flex-grow: 1; height: 24px; background: #f1f5f9; border-radius: 6px; overflow: hidden; display: flex; }
        .chart-bar-present { height: 100%; background: #10b981; transition: width 0.3s; }
        .chart-bar-absent { height: 100%; background: #ef4444; transition: width 0.3s; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <div class="nav-brand">
            <span style="background: #4f46e5; color: white; padding: 6px 10px; border-radius: 8px; font-size: 0.875rem;">📋</span>
            <span>Sagkahan NHS Tracker</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('attendance.index') }}" class="nav-btn">Dashboard</a>
            <a href="{{ route('attendance.students') }}" class="nav-btn">Manage Students</a>
            <a href="{{ route('attendance.reports') }}" class="nav-btn-active">Reports Ledger</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
    @csrf
    <button type="submit" class="nav-btn" style="background: none; border: none; cursor: pointer; font-weight: 600; color: #ef4444;">Logout</button>
</form>

        </div>
    </nav>

    <div class="container">
        
        <!-- Left Side Panel: Visual Chart Trends -->
        <div class="card">
            <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">Visual Attendance Trends</h3>
            <p style="font-size: 0.75rem; color: #94a3b8; margin: 0 0 20px 0;">Proportional data comparison bars (<span style="color:#10b981; font-weight:700;">■ Present</span> vs <span style="color:#ef4444; font-weight:700;">■ Absent</span>)</p>

            @if($historicalReports->isEmpty())
                <p style="font-size:0.875rem; color:#94a3b8; text-align:center; padding: 24px;">No visual metrics available yet.</p>
            @else
                @foreach($historicalReports as $report)
                    @php 
                        $total = $report->total_present + $report->total_absent;
                        $presentPercent = $total > 0 ? ($report->total_present / $total) * 100 : 0;
                        $absentPercent = $total > 0 ? ($report->total_absent / $total) * 100 : 0;
                    @endphp
                    <div class="chart-row">
                        <div class="chart-date">{{ \Carbon\Carbon::parse($report->attendance_date)->format('M d, Y') }}</div>
                        <div class="chart-track">
                            <div class="chart-bar-present" style="width: {{ $presentPercent }}%;" title="Present: {{ round($presentPercent) }}%"></div>
                            <div class="chart-bar-absent" style="width: {{ $absentPercent }}%;" title="Absent: {{ round($absentPercent) }}%"></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

                <!-- Right Side Panel: Detailed Operational Table -->
        <div class="card" style="padding: 0; overflow: hidden; height: fit-content;">
            <div style="padding: 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0;">Attendance Session History</h3>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 4px 0 0 0;">Review raw counts and download printable school records sheets</p>
            </div>

            @if($historicalReports->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; font-size: 0.875rem;">No historical logs found.</div>
            @else
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">
                            <th style="padding: 16px 24px;">Date</th>
                            <th style="padding: 16px 24px; text-align: center;">Counts</th>
                            <th style="padding: 16px 24px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.875rem; color: #334155;">
                        @foreach($historicalReports as $report)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 24px; font-weight: 600; color: #1e293b;">
                                    {{ \Carbon\Carbon::parse($report->attendance_date)->format('F d, Y') }}
                                </td>
                                <td style="padding: 16px 24px; text-align: center; font-size: 0.813rem; font-weight: 600;">
                                    <span style="color: #10b981;">P: {{ $report->total_present }}</span> 
                                    <span style="color: #94a3b8; margin: 0 4px;">|</span>
                                    <span style="color: #ef4444;">A: {{ $report->total_absent }}</span>
                                </td>
                                <td style="padding: 16px 24px; text-align: right;">
                                    <div style="display: inline-flex; gap: 12px;">
                                        <a href="{{ route('attendance.index', ['date' => $report->attendance_date]) }}" style="color: #4f46e5; font-weight: 600; text-decoration: none; font-size: 0.813rem;">View</a>
                                        <!-- Clean direct linking layout to print template window engine -->
                                        <a href="{{ route('attendance.print', ['date' => $report->attendance_date]) }}" target="_blank" style="color: #10b981; font-weight: 600; text-decoration: none; font-size: 0.813rem;">🖨️ Print Report</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</body>
</html>
