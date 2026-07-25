<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $selectedGrade = $request->input('grade_level');
        $selectedSection = $request->input('section');
        $searchQuery = $request->input('search');

        $query = Student::query();

        if ($selectedGrade) {
            $gradeNumber = filter_var($selectedGrade, FILTER_SANITIZE_NUMBER_INT);
            $query->where('grade_level', 'LIKE', '%' . ($gradeNumber ?: $selectedGrade) . '%');
        }
        if ($selectedSection) {
            $query->where('section', 'LIKE', '%' . $selectedSection . '%');
        }
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('student_number', 'LIKE', '%' . $searchQuery . '%')
                  ->orWhere('first_name', 'LIKE', '%' . $searchQuery . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $students = $query->with(['attendances' => function($q) use ($date) {
            $q->where('attendance_date', $date);
        }])->get();

        // Flag individual students who hit 3 or more total cumulative absences
        foreach ($students as $student) {
            $student->total_absences = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        }

        $sectionsList = Student::select('section')->distinct()->whereNotNull('section')->pluck('section');
        $totalStudents = $students->count();
        $presentCount = Attendance::where('attendance_date', $date)->whereIn('student_id', $students->pluck('id'))->where('status', 'present')->count();
        $absentCount = Attendance::where('attendance_date', $date)->whereIn('student_id', $students->pluck('id'))->where('status', 'absent')->count();

        // Calculate section-by-section stats for the dashboard summary panel
        $sectionPerformance = Attendance::join('students', 'attendances.student_id', '=', 'students.id')
            ->select('students.section', 
                DB::raw('count(case when attendances.status = "present" then 1 end) as present_total'),
                DB::raw('count(*) as combined_total'))
            ->groupBy('students.section')
            ->get()
            ->map(function($item) {
                $item->rate = $item->combined_total > 0 ? ($item->present_total / $item->combined_total) * 100 : 0;
                return $item;
            })->sortByDesc('rate');

        $highestSection = $sectionPerformance->first();
        $lowestSection = $sectionPerformance->last();

        return view('attendance.index', compact('students', 'date', 'totalStudents', 'presentCount', 'absentCount', 'selectedGrade', 'selectedSection', 'sectionsList', 'searchQuery', 'highestSection', 'lowestSection'));
    }

    public function store(Request $request)
    {
        $date = $request->input('attendance_date');
        $statuses = $request->input('status', []);

        foreach ($statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'attendance_date' => $date],
                ['status' => $status]
            );
        }

        return redirect()->to($request->input('redirect_url', '/?date=' . $date))->with('success', 'Attendance tracking logged successfully!');
    }

    public function students()
    {
        $students = Student::all();
        foreach ($students as $student) {
            $student->absences_count = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        }
        return view('attendance.students', compact('students'));
    }

    public function addStudent(Request $request)
    {
        $request->validate([
            'student_number' => 'required|unique:students,student_number',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        Student::create($request->all());
        return redirect()->back()->with('success', 'Student registered into directory!');
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'student_number' => 'required|unique:students,student_number,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $student->update($request->all());
        return redirect()->back()->with('success', 'Student information updated successfully!');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete(); 
        return redirect()->back()->with('success', 'Student removed from directory.');
    }

    public function reports()
    {
        $historicalReports = Attendance::select('attendance_date',
            DB::raw('count(case when status = "present" then 1 end) as total_present'),
            DB::raw('count(case when status = "absent" then 1 end) as total_absent'))
            ->groupBy('attendance_date')
            ->orderBy('attendance_date', 'desc')
            ->get();

        return view('attendance.reports', compact('historicalReports'));
    }

    // CSV File Bulk Import Processing Engine Feature
    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|file']);
        $file = $request->file('csv_file');
        
        $handle = fopen($file->getRealPath(), 'r');
        fgetcsv($handle); // Skips the spreadsheet title header row completely

        $importedCount = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (!empty($row[0])) {
                Student::updateOrCreate(
                    ['student_number' => $row[0]], // Match row by LRN to prevent duplicates
                    [
                        'first_name'   => $row[1],
                        'last_name'    => $row[2],
                        'grade_level'  => $row[3],
                        'section'      => $row[4],
                        'gender'       => $row[5],
                    ]
                );
                $importedCount++;
            }
        }
        fclose($handle);

        return redirect()->back()->with('success', 'Successfully imported ' . $importedCount . ' student profiles!');
    }
}
