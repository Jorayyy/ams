<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Official Attendance Form - Sagkahan NHS</title>
    <style>
        body { font-family: sans-serif; color: #000; padding: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #000; padding-bottom: 12px; }
        .title { font-size: 16px; font-weight: bold; margin: 0 0 4px 0; uppercase; }
        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; margin-bottom: 20px; font-weight: bold; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; text-transform: uppercase; font-size: 11px; }
        .summary-box { margin-top: 20px; font-weight: bold; font-size: 13px; display: inline-flex; gap: 24px; }
        /* Automated Native Print Engine Trigger Directive */
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4f46e5; color: white; border: none; font-weight: bold; border-radius: 8px; cursor: pointer;">Confirm Print Configuration</button>
    </div>

    <div class="header">
        <div class="title">SAGKAHAN NATIONAL HIGH SCHOOL</div>
        <div style="font-size: 12px; font-weight: 500; color: #333;">Official Daily Student Attendance Tracking Report Form</div>
    </div>

    <div class="meta-grid">
        <div>Log Session Date: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
        <div style="text-align: right;">Generated: {{ date('F d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Student ID / LRN</th>
                <th>Full Name</th>
                <th>Classification Info</th>
                <th>Gender</th>
                <th>Attendance Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $rec)
                @php $status = $rec->attendances->first()?->status; @endphp
                <tr>
                    <td style="font-family: monospace;">{{ $rec->student_number }}</td>
                    <td style="font-weight: bold;">{{ $rec->last_name }}, {{ $rec->first_name }}</td>
                    <td>{{ $rec->grade_level }} - {{ $rec->section }}</td>
                    <td>{{ $rec->gender }}</td>
                    <td style="font-weight: bold; color: {{ $status == 'present' ? '#137333' : '#c5221f' }};">
                        {{ $status ? strtoupper($status) : 'UNMARKED' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <div>Total Registry Enrolled: {{ $totalEnrolled }}</div>
        <div style="color: #137333;">Total Verified Present: {{ $totalPresent }}</div>
        <div style="color: #c5221f;">Total Verified Absent: {{ $totalAbsent }}</div>
    </div>

</body>
</html>
