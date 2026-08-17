@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Filter & Controls Header -->
    <div class="custom-card mb-4 p-3">
        <form action="{{ route('reports.attendance') }}" method="GET" id="reportFilterForm" class="row align-items-end g-3">
            <div class="col-md-3">
                <label for="from_date" class="form-label fw-bold small mb-1 text-dark">من تاريخ:</label>
                <input type="text" name="from_date" id="from_date" class="form-control datepicker form-control-sm rounded-2" value="{{ $fromDate }}">
            </div>
            <div class="col-md-3">
                <label for="to_date" class="form-label fw-bold small mb-1 text-dark">إلى تاريخ:</label>
                <input type="text" name="to_date" id="to_date" class="form-control datepicker form-control-sm rounded-2" value="{{ $toDate }}">
            </div>
            <div class="col-md-6 d-flex gap-2 flex-wrap justify-content-md-end">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-3 py-1.5 fw-semibold">
                    <i class="bi bi-filter me-1"></i> عرض التقرير
                </button>
                <a href="{{ route('reports.attendance', ['from_date' => now()->startOfMonth()->format('Y-m-d'), 'to_date' => now()->endOfMonth()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5 py-1.5">
                    هذا الشهر
                </a>
                <a href="{{ route('reports.attendance.pdf', ['from_date' => $fromDate, 'to_date' => $toDate]) }}" class="btn btn-sm btn-danger rounded-2 px-3 py-1.5 fw-semibold">
                    <i class="bi bi-download me-1"></i> تنزيل تقرير PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Attendance Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="custom-card p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-primary-subtle text-primary p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-people fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">إجمالي الموظفين</div>
                        <div class="fs-4 fw-bold text-dark">{{ $summary['total_employees'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="custom-card p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-success-subtle text-success p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">إجمالي الحضور</div>
                        <div class="fs-4 fw-bold text-success">{{ $summary['total_present'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="custom-card p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-danger-subtle text-danger p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-x-circle fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">إجمالي الغياب</div>
                        <div class="fs-4 fw-bold text-danger">{{ $summary['total_absent'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="custom-card p-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 bg-warning-subtle text-warning p-3 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">إجمالي التأخير</div>
                        <div class="fs-4 fw-bold text-warning">{{ $summary['total_late'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table Card -->
    <div class="custom-card mb-4">
        <div class="custom-card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">
                    تقرير سجلات الحضور والغياب
                </h5>
                <span class="badge bg-light text-secondary border rounded-2 px-2.5 py-1" style="font-size: 0.8rem;">من {{ $fromDate }} إلى {{ $toDate }}</span>
            </div>
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" class="table-search-input" placeholder="ابحث باسم الموظف...">
            </div>
        </div>

        <div class="custom-table-container">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>اسم الموظف</th>
                            <th>القسم</th>
                            <th>المسمى الوظيفي</th>
                            <th class="text-center">أيام الحضور</th>
                            <th class="text-center">أيام الغياب</th>
                            <th class="text-center">أيام التأخير</th>
                            <th class="text-center">إجمالي المسجل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reportData as $row)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $row['employee']->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-2 fw-normal">
                                        {{ $row['employee']->department->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-secondary">{{ $row['employee']->job_title }}</td>
                                <td class="text-center fw-bold text-success">{{ $row['present'] }}</td>
                                <td class="text-center fw-bold text-danger">{{ $row['absent'] }}</td>
                                <td class="text-center fw-bold text-warning">{{ $row['late'] }}</td>
                                <td class="text-center fw-bold text-dark">{{ $row['total'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                    لا توجد بيانات حضور مسجلة خلال هذه الفترة.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
