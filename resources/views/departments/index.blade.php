@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="custom-card mb-4">
        <div class="custom-card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">إدارة الأقسام</h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2.5 py-1" style="font-size: 0.75rem;">{{ $departments->total() ?? count($departments) }} قسم</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" class="table-search-input" placeholder="ابحث باسم القسم...">
                </div>
                <a href="{{ route('departments.create') }}" class="btn btn-primary rounded-2 px-3 py-2 btn-sm fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> إضافة قسم جديد
                </a>
            </div>
        </div>

        <div class="custom-table-container">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>اسم القسم</th>
                            <th>الوصف</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center" style="width: 100px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departments as $department)
                            <tr>
                                <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $department->name }}</span>
                                </td>
                                <td class="text-secondary">{{ Str::limit($department->description ?? '-', 60) }}</td>
                                <td class="text-center">
                                    @if ($department->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-2 fw-semibold">
                                            <i class="bi bi-check-circle me-1"></i> نشط
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-2 fw-semibold">
                                            <i class="bi bi-x-circle me-1"></i> غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-outline-primary border-0 rounded-2 p-1.5" title="تعديل">
                                            <i class="bi bi-pencil-square fs-6"></i>
                                        </a>
                                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف هذا القسم؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-2 p-1.5" title="حذف">
                                                <i class="bi bi-trash fs-6"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                    لا توجد أقسام حتى الآن.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($departments->hasPages())
            <div class="px-4 py-3 border-top bg-light-subtle">
                {{ $departments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
