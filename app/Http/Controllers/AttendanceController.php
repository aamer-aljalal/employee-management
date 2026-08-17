<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->format('Y-m-d'));

        $employees = Employee::where('is_active', true)
            ->with('department')
            ->orderBy('name')
            ->get();

        $attendances = Attendance::where('date', $selectedDate)
            ->get()
            ->keyBy('employee_id');

        $summary = [
            'total' => $employees->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'unmarked' => max(0, $employees->count() - $attendances->count()),
        ];

        return view('attendances.index', compact('employees', 'attendances', 'selectedDate', 'summary'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.status' => 'nullable|in:present,absent,late',
            'attendances.*.notes' => 'nullable|string|max:255',
        ]);

        $date = $request->date;
        $attendanceData = $request->attendances;

        DB::transaction(function () use ($date, $attendanceData) {
            foreach ($attendanceData as $employeeId => $data) {
                if (isset($data['status']) && !empty($data['status'])) {
                    Attendance::updateOrCreate(
                        [
                            'employee_id' => $employeeId,
                            'date' => $date,
                        ],
                        [
                            'status' => $data['status'],
                            'notes' => $data['notes'] ?? null,
                        ]
                    );
                }
            }
        });

        return redirect()->route('attendances.index', ['date' => $date])
            ->with('success', 'تم حفظ سجل تحضير الموظفين بتاريخ (' . $date . ') بنجاح.');
    }
}
