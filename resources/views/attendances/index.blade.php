@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Toolbar & Date Filter -->
    <div class="custom-card mb-4 p-3">
        <form action="{{ route('attendances.index') }}" method="GET" id="dateFilterForm" class="row align-items-center g-3">
            <div class="col-md-5 d-flex align-items-center gap-2">
                <label for="date" class="form-label fw-bold mb-0 text-nowrap text-dark">تاريخ التحضير:</label>
                <input type="text" name="date" id="date" class="form-control datepicker rounded-2 form-control-sm" value="{{ $selectedDate }}" onchange="document.getElementById('dateFilterForm').submit();">
                <a href="{{ route('attendances.index', ['date' => now()->format('Y-m-d')]) }}" class="btn btn-sm btn-outline-primary rounded-2 text-nowrap">
                    <i class="bi bi-calendar-event me-1"></i> اليوم
                </a>
            </div>
            <div class="col-md-7 text-md-end text-muted small">
                <i class="bi bi-info-circle me-1"></i> اختر التاريخ لعرض أو تعديل سجل تحضير الموظفين لذلك اليوم.
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
                        <div class="fs-4 fw-bold text-dark">{{ $summary['total'] }}</div>
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
                        <div class="text-muted small fw-semibold">الحضور</div>
                        <div class="fs-4 fw-bold text-success">{{ $summary['present'] }}</div>
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
                        <div class="text-muted small fw-semibold">الغياب</div>
                        <div class="fs-4 fw-bold text-danger">{{ $summary['absent'] }}</div>
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
                        <div class="text-muted small fw-semibold">المتأخرين</div>
                        <div class="fs-4 fw-bold text-warning">{{ $summary['late'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Form Card -->
    <form action="{{ route('attendances.store') }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $selectedDate }}">

        <div class="custom-card mb-4">
            <div class="custom-card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        جدول التحضير اليومي
                    </h5>
                    <span class="badge bg-light text-secondary border rounded-2 px-2.5 py-1" style="font-size: 0.8rem;">{{ $selectedDate }}</span>
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
                                <th class="text-center" style="width: 320px;">حالة التحضير</th>
                                <th>ملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                @php
                                    $currentAtt = $attendances[$employee->id] ?? null;
                                    $currentStatus = $currentAtt ? $currentAtt->status : null;
                                    $currentNotes = $currentAtt ? $currentAtt->notes : '';
                                @endphp
                                <tr>
                                    <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $employee->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-2 fw-normal">
                                            {{ $employee->department->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-secondary">{{ $employee->job_title }}</td>
                                    <td>
                                        <div class="btn-group w-100" role="group" aria-label="Attendance Status">
                                            <!-- Present -->
                                            <input type="radio" 
                                                   class="btn-check" 
                                                   name="attendances[{{ $employee->id }}][status]" 
                                                   id="status_present_{{ $employee->id }}" 
                                                   value="present" 
                                                   {{ $currentStatus === 'present' ? 'checked' : '' }}>
                                            <label class="btn btn-sm btn-outline-success py-1.5" for="status_present_{{ $employee->id }}">
                                                <i class="bi bi-check-circle me-1"></i> حاضر
                                            </label>

                                            <!-- Absent -->
                                            <input type="radio" 
                                                   class="btn-check" 
                                                   name="attendances[{{ $employee->id }}][status]" 
                                                   id="status_absent_{{ $employee->id }}" 
                                                   value="absent" 
                                                   {{ $currentStatus === 'absent' ? 'checked' : '' }}>
                                            <label class="btn btn-sm btn-outline-danger py-1.5" for="status_absent_{{ $employee->id }}">
                                                <i class="bi bi-x-circle me-1"></i> غائب
                                            </label>

                                            <!-- Late -->
                                            <input type="radio" 
                                                   class="btn-check" 
                                                   name="attendances[{{ $employee->id }}][status]" 
                                                   id="status_late_{{ $employee->id }}" 
                                                   value="late" 
                                                   {{ $currentStatus === 'late' ? 'checked' : '' }}>
                                            <label class="btn btn-sm btn-outline-warning py-1.5" for="status_late_{{ $employee->id }}">
                                                <i class="bi bi-clock-history me-1"></i> متأخر
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" 
                                               name="attendances[{{ $employee->id }}][notes]" 
                                               class="form-control form-control-sm rounded-2 bg-light-subtle border-slate-200" 
                                               placeholder="ملاحظات اختيارية..." 
                                               value="{{ $currentNotes }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                        لا يوجد موظفون نشطون للتحضير.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($employees->count() > 0)
                <div class="px-4 py-3 border-top bg-light-subtle text-end">
                    <button type="submit" class="btn btn-success rounded-2 px-4 py-2 fw-semibold btn-sm">
                        <i class="bi bi-check2-square me-1"></i> حفظ التحضير
                    </button>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection
