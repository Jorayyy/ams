<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function welcome()
    {
        $settings = DB::table('app_settings')->pluck('value', 'key');
        return view('welcome', compact('settings'));
    }

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

        foreach ($students as $student) {
            $student->total_absences = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        }

        $sectionsList = Student::select('section')->distinct()->whereNotNull('section')->pluck('section');
        $totalStudents = $students->count();
        $presentCount = Attendance::where('attendance_date', $date)->whereIn('student_id', $students->pluck('id'))->where('status', 'present')->count();
        $absentCount = Attendance::where('attendance_date', $date)->whereIn('student_id', $students->pluck('id'))->where('status', 'absent')->count();

        $sectionPerformance = Attendance::join('students', 'attendances.student_id', '=', 'students.id')
            ->select('students.section', DB::raw('count(case when attendances.status = "present" then 1 end) as present_total'), DB::raw('count(*) as combined_total'))
            ->groupBy('students.section')->get()->map(function($item) {
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
        foreach ($request->input('status', []) as $studentId => $status) {
            Attendance::updateOrCreate(['student_id' => $studentId, 'attendance_date' => $date], ['status' => $status]);
        }
        return redirect()->to($request->input('redirect_url', '/dashboard?date=' . $date))->with('success', 'Attendance tracking logged successfully!');
    }

    public function students()
    {
        $students = Student::all();
        foreach ($students as $student) {
            $student->absences_count = Attendance::where('student_id', $student->id)->where('status', 'absent')->count();
        }
        return view('attendance.students', compact('students'));
    }

    public function addStudent(Request $request) { Student::create($request->all()); return redirect()->back()->with('success', 'Student registered!'); }
    public function updateStudent(Request $request, $id) { Student::findOrFail($id)->update($request->all()); return redirect()->back()->with('success', 'Student details updated!'); }
    public function deleteStudent($id) { Student::findOrFail($id)->delete(); return redirect()->back()->with('success', 'Student removed.'); }
    
    public function reports()
    {
        $historicalReports = Attendance::select('attendance_date', DB::raw('count(case when status = "present" then 1 end) as total_present'), DB::raw('count(case when status = "absent" then 1 end) as total_absent'))->groupBy('attendance_date')->orderBy('attendance_date', 'desc')->get();
        return view('attendance.reports', compact('historicalReports'));
    }

    public function printReport($date)
    {
        $records = Student::with(['attendances' => function($q) use ($date) { $q->where('attendance_date', $date); }])->get();
        $totalEnrolled = $records->count();
        $totalPresent = Attendance::where('attendance_date', $date)->where('status', 'present')->count();
        $totalAbsent = Attendance::where('attendance_date', $date)->where('status', 'absent')->count();
        return view('attendance.print', compact('records', 'date', 'totalEnrolled', 'totalPresent', 'totalAbsent'));
    }

    public function importCSV(Request $request)
    {
        $request->validate(['csv_file' => 'required|file']);
        $handle = fopen($request->file('csv_file')->getRealPath(), 'r'); fgetcsv($handle);
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (!empty($row)) {
                Student::updateOrCreate(['student_number' => $row], ['first_name' => $row, 'last_name' => $row, 'grade_level' => $row, 'section' => $row, 'gender' => $row]);
            }
        }
        fclose($handle);
        return redirect()->back()->with('success', 'Students list imported successfully!');
    }

    // Settings Interface Controllers
    public function settings()
    {
        $settings = DB::table('app_settings')->pluck('value', 'key');
        return view('attendance.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        DB::table('app_settings')->where('key', 'hero_title')->update(['value' => $request->input('hero_title')]);
        DB::table('app_settings')->where('key', 'hero_subtitle')->update(['value' => $request->input('hero_subtitle')]);

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Saves locally straight to the public directory block for easy instant processing access
            $file->move(public_path('uploads'), $filename);
            DB::table('app_settings')->where('key', 'hero_image')->update(['value' => 'uploads/' . $filename]);
        }

        return redirect()->back()->with('success', 'System configurations updated immediately!');
    }
}
