@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4" dir="rtl">

    <div class="custom-card mb-4 w-100">
        <div class="custom-card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square fs-5 text-primary"></i>
                <h5 class="mb-0 fw-bold text-dark">تعديل القسم: {{ $department->name }}</h5>
            </div>
            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary btn-sm rounded-2 px-3 fw-semibold">
                <i class="bi bi-arrow-right me-1"></i> رجوع للأقسام
            </a>
        </div>

        <div class="p-4">
            <form action="{{ route('departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold text-dark">اسم القسم <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark d-block">حالة القسم</label>
                        <div class="form-check form-switch d-flex align-items-center gap-2 pt-2">
                            <input class="form-check-input m-0 ms-2" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $department->is_active) ? 'checked' : '' }} style="width: 2.8em; height: 1.4em; cursor: pointer;">
                            <label class="form-check-label fw-semibold text-dark m-0" for="is_active" style="cursor: pointer;">
                                تفعيل القسم (نشط)
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold text-dark">الوصف</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 pt-4 mt-4 border-top">
                    <button type="submit" class="btn btn-primary rounded-2 px-4 py-2 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> تحديث البيانات
                    </button>
                    <a href="{{ route('departments.index') }}" class="btn btn-light border rounded-2 px-4 py-2 text-secondary fw-semibold">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
