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
        .nav-links { display: flex; gap: 8px; background: #f1f5f9; padding: 4px; border-radius: 10px; align-items: center; }
        .nav-btn-active { background: white; color: #4f46e5; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .nav-btn { color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; }
        .nav-btn:hover { color: #0f172a; }
        .container { max-width: 1100px; margin: 32px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr; gap: 32px; }
        @media (min-width: 1024px) { .container { grid-template-columns: 320px 1fr; } }
                /* 💎 High-End Controls UI Refinement */
        .card { 
            background: white; 
            border: 1px solid rgba(226, 232, 240, 0.7); 
            border-radius: 20px; 
            padding: 24px; 
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.02), 0 10px 15px -3px rgba(15, 23, 42, 0.03); 
        }
        .form-title-header {
            font-size: 0.75rem; 
            font-weight: 800; 
            text-transform: uppercase; 
            tracking: 0.05em; 
            letter-spacing: 0.075em;
            color: #94a3b8; 
            margin: 0 0 16px 0;
        }
        .control-group-wrapper {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .form-label { 
            display: block; 
            font-size: 0.813rem; 
            font-weight: 600; 
            color: #475569; 
            margin-bottom: 6px; 
        }
        .form-select, .form-input, .input-date { 
            width: 100%; 
            box-sizing: border-box; 
            background: #ffffff; 
            border: 1.5px solid #e2e8f0; 
            border-radius: 12px; 
            padding: 12px 14px; 
            font-size: 0.875rem; 
            font-weight: 500; 
            color: #1e293b; 
            outline: none; 
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.02);
        }
        .form-select:focus, .form-input:focus, .input-date:focus { 
            border-color: #4f46e5; 
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: #ffffff;
        }
        .btn-search { 
            width: 100%; 
            background: #4f46e5; 
            color: white; 
            border: none; 
            font-weight: 700; 
            font-size: 0.875rem; 
            padding: 14px; 
            border-radius: 14px; 
            cursor: pointer; 
            margin-top: 4px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
            transition: all 0.2s ease;
        }
        .btn-search:hover {
            background: #4338ca;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
            transform: translateY(-0.5px);
        }
        .btn-search:active {
            transform: translateY(0.5px);
        }

        .stat-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02); margin-top: 16px; }
        .stat-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; tracking: 0.05em; color: #94a3b8; margin: 0; }
        .stat-value { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; }
        .form-select, .form-input, .input-date { width: 100%; box-sizing: border-box; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 12px; font-size: 0.875rem; font-weight: 500; color: #1e293b; margin-top: 6px; outline: none; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 0.75rem; font-weight: 700; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.05em; }
        .btn-search { width: 100%; background: #4f46e5; color: white; border: none; font-weight: 700; font-size: 0.875rem; padding: 12px; border-radius: 12px; cursor: pointer; margin-top: 6px; }
        .alert-danger-pill { display: inline-flex; align-items: center; gap: 6px; background: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; margin-top: 6px; border: 1px solid #fca5a5; }
        .icon-svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }
        .chart-container { margin-top: 16px; display: flex; flex-direction: column; gap: 12px; }
        .chart-row { display: flex; align-items: center; gap: 12px; }
        .chart-label { font-size: 0.813rem; font-weight: 600; color: #475569; width: 90px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; }
        .chart-track { flex-grow: 1; height: 20px; background: #f1f5f9; border-radius: 6px; overflow: hidden; display: flex; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
        .chart-bar-present { height: 100%; background: #10b981; transition: width 0.4s ease; }
        .chart-bar-absent { height: 100%; background: #ef4444; transition: width 0.4s ease; }
        .chart-percentage { font-size: 0.75rem; font-weight: 700; color: #64748b; width: 45px; text-align: right; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <div class="nav-brand">
            <svg class="icon-svg" style="width:24px; height:24px; stroke:#4f46e5;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Sagkahan NHS Tracker</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('attendance.index') }}" class="nav-btn-active">Dashboard</a>
            <a href="{{ route('attendance.students') }}" class="nav-btn">Manage Students</a>
            <a href="{{ route('attendance.reports') }}" class="nav-btn">Reports Ledger</a>
            <a href="{{ route('attendance.settings') }}" class="nav-btn">Settings</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="nav-btn" style="background: none; border: none; cursor: pointer; font-weight: 600; color: #ef4444;">Logout</button>
            </form>
        </div>
    </nav>

        <div class="container">
        <div style="display: flex; flex-direction: column; gap: 16px;">
                      <!-- Modernized Control Center Component -->
            <div class="card">
                <h3 class="form-title-header">Control Center</h3>
                <form method="GET" action="{{ route('attendance.index') }}" class="control-group-wrapper">
                    <div>
                        <label class="form-label">Select Attendance Date</label>
                        <input type="date" id="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="input-date">
                    </div>
                    <div>
                        <label class="form-label">Search Student</label>
                        <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Type Name or LRN..." class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Grade Level</label>
                        <select name="grade_level" class="form-select">
                            <option value="">-- All Grades --</option>
                            @foreach(['Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12'] as $g)
                                <option value="{{ $g }}" {{ $selectedGrade == $g ? 'selected' : '' }}>{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Section</label>
                        <select name="section" class="form-select">
                            <option value="">-- All Sections --</option>
                            @foreach($sectionsList as $sec)
                                <option value="{{ $sec }}" {{ $selectedSection == $sec ? 'selected' : '' }}>{{ $sec }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-search">Apply Filters</button>
                    
                    <a href="{{ route('attendance.index') }}" style="font-size: 0.813rem; text-align: center; color: #64748b; font-weight: 600; text-decoration: none; margin-top: 6px; display: block; transition: color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#64748b'">
                        Reset Clear Options
                    </a>
                </form>
            </div>


            <div class="card" style="padding: 18px;">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin: 0 0 10px 0;">Section Standings</h3>
                <div style="font-size: 0.813rem; font-weight: 500; color: #475569; display: flex; flex-direction: column; gap: 8px;">
                    <div style="background: #e6f4ea; padding: 10px 14px; border-radius: 10px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 8px; color: #065f46;">
                        <svg class="icon-svg" style="stroke:#065f46" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span><strong>Highest:</strong> {{ $highestSection ? $highestSection->section . ' (' . round($highestSection->rate) . '%)' : 'None' }}</span>
                    </div>
                    <div style="background: #fce8e6; padding: 10px 14px; border-radius: 10px; border: 1px solid #fca5a5; display: flex; align-items: center; gap: 8px; color: #991b1b;">
                        <svg class="icon-svg" style="stroke:#991b1b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                        <span><strong>Lowest:</strong> {{ $lowestSection ? $lowestSection->section . ' (' . round($lowestSection->rate) . '%)' : 'None' }}</span>
                    </div>
                </div>
            </div>

            <div class="card" style="padding: 18px;">
                <h3 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin: 0 0 4px 0; display: flex; align-items: center; gap: 6px;">
                    <svg class="icon-svg" style="stroke:#4f46e5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.003 9.003 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.003 0 0120.488 9z"/></svg>
                    <span>Today's Attendance Ratio Chart</span>
                </h3>
                <p style="font-size: 0.715rem; color: #94a3b8; margin: 0 0 12px 0;">Visual distribution bar tracking (■ Present vs ■ Absent)</p>
                <div class="chart-container">
                    @php
                        $grandTotal = $presentCount + $absentCount;
                        $presentBarWidth = $grandTotal > 0 ? ($presentCount / $grandTotal) * 100 : 0;
                        $absentBarWidth = $grandTotal > 0 ? ($absentCount / $grandTotal) * 100 : 0;
                    @endphp
                    <div class="chart-row">
                        <div class="chart-label">Current View</div>
                        <div class="chart-track">
                            <div class="chart-bar-present" style="width: {{ $presentBarWidth }}%;"></div>
                            <div class="chart-bar-absent" style="width: {{ $absentBarWidth }}%;"></div>
                        </div>
                        <div class="chart-percentage">{{ $grandTotal > 0 ? round($presentBarWidth) : 0 }}%</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div><p class="stat-title">Filtered Enrolled</p><p class="stat-value">{{ $totalStudents }}</p></div>
            </div>
            <div class="stat-card">
                <div><p class="stat-title">Present Today</p><p class="stat-value" style="color: #10b981;">{{ $presentCount }}</p></div>
            </div>
            <div class="stat-card">
                <div><p class="stat-title">Absent Today</p><p class="stat-value" style="color: #ef4444;">{{ $absentCount }}</p></div>
            </div>
        </div>

                <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0;">Attendance Log Register</h3>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 4px 0 0 0;">Assigned sheets for date session</p>
            </div>

            @if($students->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; font-size: 0.875rem;">
                    <p style="margin: 0;">No students registered in directory.</p>
                    <a href="{{ route('attendance.students') }}" style="color: #4f46e5; font-weight: 600; text-decoration: none; margin-top: 8px; display: inline-block;">Go to Student Registration →</a>
                </div>
            @else
                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf
                    <input type="hidden" name="attendance_date" value="{{ $date }}">
                    <input type="hidden" name="redirect_url" value="{{ request()->fullUrl() }}">
                    
                    @php $showSaveButton = false; @endphp

                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">
                                <th style="padding: 16px 24px;">Student Information</th>
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
                                        
                                        @if($student->total_absences >= 3)
                                            <div>
                                                <span class="alert-danger-pill">
                                                    <svg class="icon-svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                    High Absence Risk ({{ $student->total_absences }} Total Absences)
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 24px; text-align: center;">
                                        
                                        @if($currentStatus && !$isEditingThisRow)
                                            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                                @if($currentStatus == 'present')
                                                    <span class="status-badge" style="background: #e6f4ea; color: #137333;">
                                                        <svg class="icon-svg" style="stroke:#137333; margin-right:4px;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                        Present
                                                    </span>
                                                @else
                                                    <span class="status-badge" style="background: #fce8e6; color: #c5221f;">
                                                        <svg class="icon-svg" style="stroke:#c5221f; margin-right:4px;" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        Absent
                                                    </span>
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
