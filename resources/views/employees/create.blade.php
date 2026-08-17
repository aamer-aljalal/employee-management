@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4" dir="rtl">

    <div class="custom-card mb-4 w-100">
        <div class="custom-card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-plus fs-5 text-primary"></i>
                <h5 class="mb-0 fw-bold text-dark">إضافة موظف جديد</h5>
            </div>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm rounded-2 px-3 fw-semibold">
                <i class="bi bi-arrow-right me-1"></i> رجوع للموظفين
            </a>
        </div>

        <div class="p-4">
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="name" class="form-label fw-bold text-dark">اسم الموظف <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="مثال: أحمد محمد" required>
                        @error('name')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="department_id" class="form-label fw-bold text-dark">القسم <span class="text-danger">*</span></label>
                        <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                            <option value="">-- اختر القسم --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="job_title" class="form-label fw-bold text-dark">المسمى الوظيفي <span class="text-danger">*</span></label>
                        <input type="text" name="job_title" id="job_title" class="form-control @error('job_title') is-invalid @enderror" value="{{ old('job_title') }}" placeholder="مثال: محاسب قانوني" required>
                        @error('job_title')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="phone" class="form-label fw-bold text-dark">رقم الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="05XXXXXXXX">
                        @error('phone')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="salary" class="form-label fw-bold text-dark">الراتب (اختياري)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}" placeholder="0.00">
                            <span class="input-group-text fw-bold">ر.س</span>
                        </div>
                        @error('salary')
                            <div class="invalid-feedback d-block fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="hire_date" class="form-label fw-bold text-dark">تاريخ التعيين</label>
                        <input type="text" name="hire_date" id="hire_date" class="form-control datepicker @error('hire_date') is-invalid @enderror" value="{{ old('hire_date') }}" placeholder="اختر التاريخ...">
                        @error('hire_date')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold text-dark d-block">حالة الموظف</label>
                        <div class="form-check form-switch d-flex align-items-center gap-2 pt-1">
                            <input class="form-check-input m-0 ms-2" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 2.8em; height: 1.4em; cursor: pointer;">
                            <label class="form-check-label fw-semibold text-dark m-0" for="is_active" style="cursor: pointer;">
                                الموظف (على رأس العمل)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 pt-4 mt-4 border-top">
                    <button type="submit" class="btn btn-primary rounded-2 px-4 py-2 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> حفظ الموظف
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn btn-light border rounded-2 px-4 py-2 text-secondary fw-semibold">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection