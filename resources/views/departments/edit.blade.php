@extends('layouts.app')

@section('content')
<div class="container-fluid px-3" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold text-dark">تعديل القسم: {{ $department->name }}</h4>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary rounded-3 px-3">
                    <i class="bi bi-arrow-right ms-1"></i> رجوع
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-pencil-square me-1"></i> تعديل بيانات القسم</h6>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold text-secondary">اسم القسم <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg bg-light border-0 rounded-3 @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold text-secondary">الوصف</label>
                            <textarea name="description" id="description" rows="3" class="form-control bg-light border-0 rounded-3 @error('description') is-invalid @enderror">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback fw-bold">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 bg-light p-3 rounded-3 d-flex align-items-center justify-content-between">
                            <div>
                                <label class="fw-bold mb-0 text-dark" for="is_active">حالة القسم</label>
                                <p class="text-muted small mb-0">حدد ما إذا كان هذا القسم نشطاً حالياً</p>
                            </div>
                            <div class="form-check form-switch m-0" style="transform: scale(1.3); margin-left: 0.5rem !important;">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('departments.index') }}" class="btn btn-light rounded-3 px-4 fw-bold text-muted">إلغاء</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold">
                                <i class="bi bi-check2-circle ms-1"></i> تحديث القسم
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
