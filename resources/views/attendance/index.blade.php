<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        .nav-bar { background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 24px; height: 64px; }
        .nav-brand { font-weight: 700; font-size: 1.125rem; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 8px; background: #f1f5f9; padding: 4px; border-radius: 10px; }
        .nav-btn-active { background: white; color: #4f46e5; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .nav-btn { color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; }
        .nav-btn:hover { color: #0f172a; }
        .container { max-width: 1200px; margin: 32px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr; gap: 32px; }
        @media (min-width: 1024px) { .container { grid-template-columns: 340px 1fr; } }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .stat-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-top: 14px; }
        .stat-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; tracking: 0.05em; color: #94a3b8; margin: 0; }
        .stat-value { font-size: 1.35rem; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; }
        .form-select, .form-input, .input-date { width: 100%; box-sizing: border-box; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 11px; font-size: 0.875rem; font-weight: 500; color: #1e293b; margin-top: 6px; outline: none; }
        .status-badge { display: inline-block; padding: 6px 14px; font-size: 0.75rem; font-weight: 700; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
        .btn-search { width: 100%; background: #4f46e5; color: white; border: none; font-weight: 700; font-size: 0.875rem; padding: 12px; border-radius: 12px; cursor: pointer; margin-top: 6px; }
        .alert-danger-pill { background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-size: 0.715rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <div class="nav-brand">
            <span style="background: #4f46e5; color: white; padding: 6px 10px; border-radius: 8px; font-size: 0.875rem;">📋</span>
            <span>Sagkahan NHS Tracker</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('attendance.index') }}" class="nav-btn-active">Dashboard</a>
            <a href="{{ route('attendance.students') }}" class="nav-btn">Manage Students</a>
            <a href="{{ route('attendance.reports') }}" class="nav-btn">Reports Ledger</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
    @csrf
    <button type="submit" class="nav-btn" style="background: none; border: none; cursor: pointer; font-weight: 600; color: #ef4444;">Logout</button>
</form>
        
         <a href="{{ route('attendance.settings') }}" class="nav-btn">Settings</a>

        </div>
    </nav>

    <div class="container">
        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Dashboard Filters Card -->
            <div class="card">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin: 0 0 12px 0;">Control Center</h3>
                <form method="GET" action="{{ route('attendance.index') }}" style="display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Select Attendance Date</label>
                        <input type="date" id="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="input-date">
                    </div>
                    <div>
                        <label style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Search Student</label>
                        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Type Name or LRN..." class="form-input">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Grade Level</label>
                            <select name="grade_level" class="form-select">
                                <option value="">All</option>
                                @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $g)
                                    <option value="{{ $g }}" {{ $selectedGrade == $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="font-size: 0.75rem; font-weight: 600; color: #64748b;">Section</label>
                            <select name="section" class="form-select">
                                <option value="">All</option>
                                @foreach($sectionsList as $sec)
                                    <option value="{{ $sec }}" {{ $selectedSection == $sec ? 'selected' : '' }}>{{ $sec }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-search">Apply Layout Filters</button>
                    <a href="{{ route('attendance.index') }}" style="font-size: 0.75rem; text-align: center; color: #ef4444; font-weight: 600; text-decoration: none; margin-top: 2px;">Clear Selection</a>
                </form>
            </div>

            <!-- Automated Section Summary Cards Component -->
            <div class="card" style="padding: 18px;">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin: 0 0 10px 0;">Section Standings</h3>
                <div style="font-size: 0.813rem; font-weight: 500; color: #475569; display: flex; flex-direction: column; gap: 8px;">
                    <div style="background: #e6f4ea; padding: 10px 14px; border-radius: 10px; border: 1px solid #a7f3d0;">
                        🥇 <span style="font-weight: 700; color: #065f46;">Highest:</span> {{ $highestSection ? $highestSection->section . ' (' . round($highestSection->rate) . '%)' : 'None' }}
                    </div>
                    <div style="background: #fce8e6; padding: 10px 14px; border-radius: 10px; border: 1px solid #fca5a5;">
                        ⚠️ <span style="font-weight: 700; color: #991b1b;">Lowest:</span> {{ $lowestSection ? $lowestSection->section . ' (' . round($lowestSection->rate) . '%)' : 'None' }}
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div><p class="stat-title">Filtered Registry</p><p class="stat-value">{{ $totalStudents }}</p></div>
            </div>
            <div class="stat-card">
                <div><p class="stat-title">Present Count</p><p class="stat-value" style="color: #10b981;">{{ $presentCount }}</p></div>
            </div>
            <div class="stat-card">
                <div><p class="stat-title">Absent Count</p><p class="stat-value" style="color: #ef4444;">{{ $absentCount }}</p></div>
            </div>
        </div>

                <!-- Main Attendance Registration Log Component -->
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0;">Attendance Log Register</h3>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 4px 0 0 0;">Assigned profile registry rosters for selection session</p>
            </div>

            @if($students->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; font-size: 0.875rem;">No student profiles match configuration metrics.</div>
            @else
                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf
                    <input type="hidden" name="attendance_date" value="{{ $date }}">
                    <input type="hidden" name="redirect_url" value="{{ request()->fullUrl() }}">
                    
                    @php $showSaveButton = false; @endphp

                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">
                                <th style="padding: 16px 24px;">Student Profile Info</th>
                                <th style="padding: 16px 24px; text-align: center;">Status Declaration</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.875rem; color: #334155;">
                            @foreach($students as $student)
                                @php 
                                    $currentStatus = $student->attendances->first()?->status; 
                                    $isEditingThisRow = (request('edit_id') == $student->id);
                                    if (!$currentStatus || $isEditingThisRow) { $showSaveButton = true; }
                                @endphp
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 16px 24px;">
                                        <div style="font-weight: 600; color: #1e293b;">{{ $student->last_name }}, {{ $student->first_name }}</div>
                                        <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">{{ $student->grade_level }} - {{ $student->section }} | LRN: {{ $student->student_number }}</div>
                                        
                                        <!-- Automated Danger Alert Trigger Banner -->
                                        @if($student->total_absences >= 3)
                                            <div>
                                                <span class="alert-danger-pill">⚠️ High Absence Risk ({{ $student->total_absences }} Total Absences)</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 24px; text-align: center;">
                                        
                                        @if($currentStatus && !$isEditingThisRow)
                                            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                                @if($currentStatus == 'present')
                                                    <span class="status-badge" style="background: #e6f4ea; color: #137333;">✓ Present</span>
                                                @else
                                                    <span class="status-badge" style="background: #fce8e6; color: #c5221f;">✕ Absent</span>
                                                @endif
                                                <a href="{{ request()->fullUrlWithQuery(['edit_id' => $student->id]) }}" style="font-size: 0.75rem; color: #4f46e5; text-decoration: none; font-weight: 600; margin-top: 2px;">Re-mark</a>
                                            </div>
                                        @endif

                                        @if(!$currentStatus || $isEditingThisRow)
                                            <div style="display: inline-flex; gap: 12px; vertical-align: middle;">
                                                <label style="cursor: pointer; font-weight: 600; color: #10b981;">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="present" {{ $currentStatus == 'present' ? 'checked' : '' }} required style="margin-right: 4px;"> Present
                                                </label>
                                                <label style="cursor: pointer; font-weight: 600; color: #ef4444;">
                                                    <input type="radio" name="status[{{ $student->id }}]" value="absent" {{ $currentStatus == 'absent' ? 'checked' : '' }} style="margin-right: 4px;"> Absent
                                                </label>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($showSaveButton)
                        <div style="padding: 20px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                            <button type="submit" style="background: #4f46e5; color: white; border: none; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; padding: 12px 24px; border-radius: 12px; cursor: pointer; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                                Save Verification Logs
                            </button>
                        </div>
                    @endif
                </form>
            @endif
        </div>
    </div>
</body>
</html>
