@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 pb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">لوحة التحكم الرئيسية</h4>
        <a href="{{ route('reports.attendance') }}" class="btn btn-primary rounded-3 px-3">
            <i class="bi bi-printer me-1"></i> طباعة تقارير الحضور
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted fw-semibold mb-1">الأقسام الإدارية</div>
                        <h3 class="fw-bold mb-0 text-primary">{{ \App\Models\Department::count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary-subtle text-primary p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                </div>
                <hr class="my-3 opacity-10">
                <a href="{{ route('departments.index') }}" class="text-primary text-decoration-none small fw-bold">
                    إدارة الأقسام <i class="bi bi-arrow-left ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted fw-semibold mb-1">الموظفين النشطين</div>
                        <h3 class="fw-bold mb-0 text-success">{{ \App\Models\Employee::where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-success-subtle text-success p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                </div>
                <hr class="my-3 opacity-10">
                <a href="{{ route('employees.index') }}" class="text-success text-decoration-none small fw-bold">
                    إدارة الموظفين <i class="bi bi-arrow-left ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted fw-semibold mb-1">التحضير اليومي</div>
                        <h3 class="fw-bold mb-0 text-warning">{{ \App\Models\Attendance::where('date', now()->format('Y-m-d'))->count() }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning-subtle text-warning p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                </div>
                <hr class="my-3 opacity-10">
                <a href="{{ route('attendances.index') }}" class="text-warning text-decoration-none small fw-bold">
                    تسجيل التحضير لليوم <i class="bi bi-arrow-left ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Action Card for Printing Attendance Report -->
    <div class="premium-card mb-4">
        <div class="card-body p-3 text-center py-5">
            <i class="bi bi-file-earmark-pdf fs-1 text-primary d-block mb-3"></i>
            <h4 class="fw-bold">طباعة وتصدير تقارير الحضور والغياب</h4>
            <p class="text-muted max-w-lg mx-auto mb-4">
                يمكنك الآن تحديد الفترة الزمنية المطلوبة (من تاريخ إلى تاريخ) وتوليد كشف تفصيلي يشمل أعداد أيام الحضور، الغياب، والتأخير لجميع الموظفين الجاهز للطباعة والتصدير.
            </p>
            <a href="{{ route('reports.attendance') }}" class="btn btn-primary btn-lg rounded-3 px-5 py-2 fs-6">
                <i class="bi bi-printer me-2"></i> الانتقال لصفحة التقارير والطباعة
            </a>
        </div>
    </div>
</div>
@endsection
