@extends('layouts.app')

@section('content')
<div class="container-fluid px-3" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-dark">إضافة موظف جديد</h4>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="bi bi-arrow-right ms-1"></i> رجوع
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-person-badge me-1"></i> بيانات الموظف الأساسية</h6>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-bold text-secondary">اسم الموظف <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg bg-light border-0 rounded-3 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="مثال: أحمد محمد" required>
                                @error('name')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="department_id" class="form-label fw-bold text-secondary">القسم <span class="text-danger">*</span></label>
                                <select name="department_id" id="department_id" class="form-select form-select-lg bg-light border-0 rounded-3 @error('department_id') is-invalid @enderror" required>
                                    <option value="">-- اختر القسم --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="job_title" class="form-label fw-bold text-secondary">المسمى الوظيفي <span class="text-danger">*</span></label>
                                <input type="text" name="job_title" id="job_title" class="form-control form-control-lg bg-light border-0 rounded-3 @error('job_title') is-invalid @enderror" value="{{ old('job_title') }}" placeholder="مثال: محاسب قانوني" required>
                                @error('job_title')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label fw-bold text-secondary">رقم الهاتف</label>
                                <input type="text" name="phone" id="phone" class="form-control form-control-lg bg-light border-0 rounded-3 @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="05XXXXXXXX" dir="ltr" style="text-align: right;">
                                @error('phone')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="salary" class="form-label fw-bold text-secondary">الراتب (اختياري)</label>
                                <div class="input-group input-group-lg">
                                    <input type="number" step="0.01" name="salary" id="salary" class="form-control bg-light border-0 rounded-end-3 @error('salary') is-invalid @enderror" value="{{ old('salary') }}" placeholder="0.00" dir="ltr" style="text-align: right;">
                                    <span class="input-group-text bg-light border-0 rounded-start-3 text-secondary">ر.س</span>
                                </div>
                                @error('salary')
                                    <div class="invalid-feedback fw-bold d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="hire_date" class="form-label fw-bold text-secondary">تاريخ التعيين</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-0 rounded-end-3 text-secondary"><i class="bi bi-calendar3"></i></span>
                                    <input type="text" name="hire_date" id="hire_date" class="form-control datepicker bg-light border-0 rounded-start-3 @error('hire_date') is-invalid @enderror" value="{{ old('hire_date') }}" placeholder="اختر التاريخ...">
                                </div>
                                @error('hire_date')
                                    <div class="invalid-feedback fw-bold d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 bg-light p-3 rounded-3 d-flex align-items-center justify-content-between">
                            <div>
                                <label class="fw-bold mb-0 text-dark" for="is_active">حالة الموظف</label>
                                <p class="text-muted small mb-0">حدد ما إذا كان هذا الموظف على رأس العمل حالياً</p>
                            </div>
                            <div class="form-check form-switch m-0" style="transform: scale(1.3); margin-left: 0.5rem !important;">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-light rounded-3 px-4 fw-bold text-muted">إلغاء</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold">
                                <i class="bi bi-check2-circle ms-1"></i> حفظ الموظف
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
