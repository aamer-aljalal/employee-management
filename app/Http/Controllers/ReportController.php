<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use ArPHP\I18N\Arabic;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display attendance report filtered by date range.
     */
    public function attendance(Request $request)
    {
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = $this->getReportData($fromDate, $toDate);

        return view('reports.attendance', array_merge($data, [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]));
    }

    /**
     * Download attendance report as PDF using Barryvdh DomPDF + ArPHP text reshaping.
     */
    public function exportPdf(Request $request)
    {
        $fromDate = $request->input('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $data = $this->getReportData($fromDate, $toDate);

        $arabic = new Arabic();

        // Reshape Arabic strings in report data for correct DomPDF rendering
        $reshapedReportData = $data['reportData']->map(function ($row) use ($arabic) {
            return [
                'employee_name' => @$arabic->utf8Glyphs($row['employee']->name),
                'department_name' => @$arabic->utf8Glyphs($row['employee']->department->name ?? '-'),
                'job_title' => @$arabic->utf8Glyphs($row['employee']->job_title ?? '-'),
                'present' => $row['present'],
                'absent' => $row['absent'],
                'late' => $row['late'],
                'total' => $row['total'],
            ];
        });

        // Reshape static text labels used in PDF template
        $labels = [
            'title' => @$arabic->utf8Glyphs('نظام إدارة الموظفين'),
            'subtitle' => @$arabic->utf8Glyphs('كشف إحصائي تفصيلي بحضور وغياب الموظفين'),
            'from' => @$arabic->utf8Glyphs('الفترة من:'),
            'to' => @$arabic->utf8Glyphs('إلى:'),
            'printed_at' => @$arabic->utf8Glyphs('تاريخ الاستخراج:'),
            'total_emp' => @$arabic->utf8Glyphs('إجمالي الموظفين'),
            'total_present' => @$arabic->utf8Glyphs('إجمالي أيام الحضور'),
            'total_absent' => @$arabic->utf8Glyphs('إجمالي أيام الغياب'),
            'total_late' => @$arabic->utf8Glyphs('إجمالي أوقات التأخير'),
            'th_num' => '#',
            'th_name' => @$arabic->utf8Glyphs('اسم الموظف'),
            'th_dept' => @$arabic->utf8Glyphs('القسم'),
            'th_job' => @$arabic->utf8Glyphs('المسمى الوظيفي'),
            'th_present' => @$arabic->utf8Glyphs('الحضور'),
            'th_absent' => @$arabic->utf8Glyphs('الغياب'),
            'th_late' => @$arabic->utf8Glyphs('التأخير'),
            'th_total' => @$arabic->utf8Glyphs('إجمالي المسجل'),
            'no_data' => @$arabic->utf8Glyphs('لا توجد بيانات حضور مسجلة خلال هذه الفترة.'),
            'footer' => @$arabic->utf8Glyphs('تم استخراج هذا التقرير آلياً بواسطة نظام إدارة الموظفين - جميع الحقوق محفوظة.'),
        ];

        $pdf = Pdf::loadView('reports.attendance_pdf', [
            'reportData' => $reshapedReportData,
            'summary' => $data['summary'],
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'labels' => $labels,
        ])->setPaper('a4', 'portrait');

        $fileName = 'attendance_report_' . $fromDate . '_to_' . $toDate . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Helper method to fetch attendance data and calculate statistics.
     */
    private function getReportData($fromDate, $toDate)
    {
        $employees = Employee::where('is_active', true)
            ->with('department')
            ->orderBy('name')
            ->get();

        $attendances = Attendance::whereBetween('date', [$fromDate, $toDate])->get();

        $employeeAttendances = $attendances->groupBy('employee_id');

        $reportData = $employees->map(function ($employee) use ($employeeAttendances) {
            $records = $employeeAttendances->get($employee->id, collect());

            return [
                'employee' => $employee,
                'present' => $records->where('status', 'present')->count(),
                'absent' => $records->where('status', 'absent')->count(),
                'late' => $records->where('status', 'late')->count(),
                'total' => $records->count(),
            ];
        });

        $summary = [
            'total_employees' => $employees->count(),
            'total_present' => $attendances->where('status', 'present')->count(),
            'total_absent' => $attendances->where('status', 'absent')->count(),
            'total_late' => $attendances->where('status', 'late')->count(),
        ];

        return compact('reportData', 'summary');
    }
}
