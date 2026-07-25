<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Attendance Tracker</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        .nav-bar { background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 24px; height: 64px; }
        .nav-brand { font-weight: 700; font-size: 1.125rem; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; gap: 8px; background: #f1f5f9; padding: 4px; border-radius: 10px; }
        .nav-btn { color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; }
        .nav-btn:hover { color: #0f172a; }
        .nav-btn-active { background: white; color: #4f46e5; font-weight: 600; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 0.875rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .container { max-width: 1200px; margin: 32px auto; padding: 0 24px; display: grid; grid-template-columns: 1fr; gap: 32px; }
        @media (min-width: 1024px) { .container { grid-template-columns: 360px 1fr; } }
        .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); height: fit-content; }
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; box-sizing: border-box; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 12px; font-size: 0.875rem; font-weight: 500; color: #1e293b; outline: none; }
        .form-input:focus, .form-select:focus { border-color: #4f46e5; }
        .btn-submit { width: 100%; background: #10b981; color: white; border: none; font-weight: 700; font-size: 0.875rem; padding: 12px; border-radius: 12px; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }
        .btn-edit { background: #e0f2fe; color: #0369a1; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; cursor: pointer; }
        .btn-delete { background: #fee2e2; color: #991b1b; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; cursor: pointer; }
    </style>
    <script>
        function toggleEditRow(studentId) {
            var viewRow = document.getElementById('view-row-' + studentId);
            var editRow = document.getElementById('edit-row-' + studentId);
            if (viewRow.style.display === 'none') {
                viewRow.style.display = '';
                editRow.style.display = 'none';
            } else {
                viewRow.style.display = 'none';
                editRow.style.display = '';
            }
        }
    </script>
</head>
<body>

    <nav class="nav-bar">
        <div class="nav-brand">
            <span style="background: #4f46e5; color: white; padding: 6px 10px; border-radius: 8px; font-size: 0.875rem;">📋</span>
            <span>Sagkahan NHS Tracker</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('attendance.index') }}" class="nav-btn">Dashboard</a>
            <a href="{{ route('attendance.students') }}" class="nav-btn-active">Manage Students</a>
            <a href="{{ route('attendance.reports') }}" class="nav-btn">Reports Ledger</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
    @csrf
    <button type="submit" class="nav-btn" style="background: none; border: none; cursor: pointer; font-weight: 600; color: #ef4444;">Logout</button>
</form>

        </div>
    </nav>

    <div class="container">

            <!-- Bulk Spreadsheet Upload Box Form Feature -->
        <div class="card" style="margin-bottom: 20px; border-color: #cbd5e1; background: #f8fafc;">
            <h3 style="font-size: 0.938rem; font-weight: 700; color: #0f172a; margin: 0 0 10px 0;">📦 Spreadsheet Bulk Import</h3>
            <p style="font-size: 0.715rem; color: #64748b; margin: 0 0 12px 0;">Select a <code>.csv</code> spreadsheet containing columns for: LRN, First Name, Last Name, Grade, Section, Gender.</p>
            
            <form method="POST" action="{{ route('attendance.import_csv') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="csv_file" accept=".csv" required style="font-size: 0.813rem; color: #475569; margin-bottom: 12px; width: 100%;">
                <button type="submit" style="width:100%; background:#4f46e5; color:white; border:none; padding:10px; border-radius:10px; font-weight:700; font-size:0.813rem; cursor:pointer;">
                    Upload & Populate Registry
                </button>
            </form>
        </div>

        
        <!-- Register Student Form Panel -->
        <div class="card">
            <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 16px 0; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">➕ Enrollment Registry</h3>
            
            <form method="POST" action="{{ route('attendance.add_student') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Learner Reference Number (LRN)</label>
                    <input type="text" name="student_number" required placeholder="12-digit LRN" class="form-input">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" required placeholder="First Name" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" required placeholder="Last Name" class="form-input">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Grade Level</label>
                    <select name="grade_level" required class="form-select">
                        <option value="Grade 7">Grade 7</option><option value="Grade 8">Grade 8</option>
                        <option value="Grade 9">Grade 9</option><option value="Grade 10">Grade 10</option>
                        <option value="Grade 11">Grade 11</option><option value="Grade 12">Grade 12</option>
                    </select>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Section</label>
                        <input type="text" name="section" required placeholder="e.g. Bonifacio" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" required class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn-submit" style="margin-top: 8px;">Register Student Record</button>
            </form>
        </div>

                <!-- Directory Registry Table -->
        <div class="card" style="padding: 0; overflow: hidden;">
            <div style="padding: 24px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h3 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0;">Comprehensive Student Directory</h3>
                <p style="font-size: 0.75rem; color: #94a3b8; margin: 4px 0 0 0;">Manage profiles, sections, and track structural real-time absence metrics</p>
            </div>
            
            @if($students->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; font-size: 0.875rem;">No student profiles found. Add records on the left panel!</div>
            @else
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">
                            <th style="padding: 16px 24px;">Student Profile</th>
                            <th style="padding: 16px 24px;">Classification</th>
                            <th style="padding: 16px 24px; text-align: center;">Absences</th>
                            <th style="padding: 16px 24px; text-align: right;">Operations</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.875rem; color: #334155;">
                        @foreach($students as $student)
                            <!-- Standard Row View Mode -->
                            <tr id="view-row-{{ $student->id }}" style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px 24px;">
                                    <div style="font-weight: 600; color: #1e293b;">{{ $student->last_name }}, {{ $student->first_name }}</div>
                                    <div style="font-family: monospace; font-size: 0.75rem; color: #94a3b8; margin-top: 2px;">LRN: {{ $student->student_number }}</div>
                                </td>
                                <td style="padding: 16px 24px;">
                                    <div style="font-weight: 500;">{{ $student->grade_level }} - {{ $student->section }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 2px;">{{ $student->gender }}</div>
                                </td>
                                <td style="padding: 16px 24px; text-align: center;">
                                    <span style="display: inline-block; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; border-radius: 9999px; {{ $student->absences_count > 3 ? 'background: #fee2e2; color: #991b1b;' : 'background: #f1f5f9; color: #334155;' }}">
                                        {{ $student->absences_count }}
                                    </span>
                                </td>
                                <td style="padding: 16px 24px; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px;">
                                        <button onclick="toggleEditRow({{ $student->id }})" class="btn-edit">Edit</button>
                                        <form method="POST" action="{{ route('attendance.delete_student', $student->id) }}" onsubmit="return confirm('Remove student permanent from directory?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Interactive Edit Fields Row Mode -->
                            <tr id="edit-row-{{ $student->id }}" style="display: none; background: #fafafa; border-bottom: 1px solid #e2e8f0;">
                                <form method="POST" action="{{ route('attendance.update_student', $student->id) }}">
                                    @csrf @method('PUT')
                                    <td style="padding: 12px 16px;">
                                        <input type="text" name="last_name" value="{{ $student->last_name }}" required class="form-input" style="margin-bottom:6px;" placeholder="Last Name">
                                        <input type="text" name="first_name" value="{{ $student->first_name }}" required class="form-input" placeholder="First Name">
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <input type="text" name="student_number" value="{{ $student->student_number }}" required class="form-input" style="margin-bottom:6px;" placeholder="LRN">
                                        <div style="display:flex; gap:4px;">
                                            <input type="text" name="grade_level" value="{{ $student->grade_level }}" required class="form-input" placeholder="Grade">
                                            <input type="text" name="section" value="{{ $student->section }}" required class="form-input" placeholder="Section">
                                        </div>
                                    </td>
                                    <td style="padding: 12px 16px;">
                                        <select name="gender" class="form-select">
                                            <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </td>
                                    <td style="padding: 12px 16px; text-align: right; vertical-align: middle;">
                                        <button type="submit" class="btn-submit" style="padding: 6px 12px; font-size: 0.75rem; width: auto; display: inline-block; margin-bottom: 4px;">Save</button>
                                        <button type="button" onclick="toggleEditRow({{ $student->id }})" style="background:#e2e8f0; color:#475569; border:none; padding:6px 12px; border-radius:8px; font-weight:600; font-size:0.75rem; cursor:pointer;">Cancel</button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</body>
</html>
