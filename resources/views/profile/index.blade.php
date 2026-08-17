@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">

    <!-- Profile Page Header Card -->
    <div class="custom-card mb-4">
        <div class="custom-card-header bg-white p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-lg bg-primary bg-opacity-10 text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center fs-2" style="width: 64px; height: 64px; border: 2px solid #bfdbfe;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                    <p class="text-muted mb-0 dir-ltr text-end fs-7"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                </div>
            </div>
            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle px-3 py-2 fs-7 rounded-pill">
                    <i class="bi bi-shield-check me-1"></i> مدير النظام
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Section 1: Update Profile Details -->
        <div class="col-lg-6">
            <div class="custom-card h-100">
                <div class="custom-card-header bg-white d-flex align-items-center gap-2">
                    <i class="bi bi-person-gear text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">تعديل المعلومات الشخصية</h5>
                </div>
                <div class="p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">الاسم الكامل <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required style="padding-right: 2.75rem;">
                                <i class="bi bi-person position-absolute top-50 translate-middle-y text-muted fs-5" style="right: 0.85rem; pointer-events: none;"></i>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required style="padding-right: 2.75rem;">
                                <i class="bi bi-envelope position-absolute top-50 translate-middle-y text-muted fs-5" style="right: 0.85rem; pointer-events: none;"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-check-lg"></i> حفظ التغيرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Section 2: Change Password -->
        <div class="col-lg-6">
            <div class="custom-card h-100">
                <div class="custom-card-header bg-white d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">تغيير كلمة المرور</h5>
                </div>
                <div class="p-4">
                    @if (session('success_password'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success_password') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold text-dark">كلمة المرور الحالية <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required placeholder="••••••••" style="padding-right: 2.75rem; padding-left: 2.75rem;">
                                <i class="bi bi-key position-absolute top-50 translate-middle-y text-muted fs-5" style="right: 0.85rem; pointer-events: none;"></i>
                                <button type="button" class="btn btn-link position-absolute top-50 translate-middle-y text-secondary p-0 text-decoration-none toggle-password" data-target="current_password" style="left: 0.85rem; z-index: 10;">
                                    <i class="bi bi-eye fs-5"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-dark">كلمة المرور الجديدة <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••" style="padding-right: 2.75rem; padding-left: 2.75rem;">
                                <i class="bi bi-lock position-absolute top-50 translate-middle-y text-muted fs-5" style="right: 0.85rem; pointer-events: none;"></i>
                                <button type="button" class="btn btn-link position-absolute top-50 translate-middle-y text-secondary p-0 text-decoration-none toggle-password" data-target="password" style="left: 0.85rem; z-index: 10;">
                                    <i class="bi bi-eye fs-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold text-dark">تأكيد كلمة المرور الجديدة <span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" style="padding-right: 2.75rem; padding-left: 2.75rem;">
                                <i class="bi bi-lock-fill position-absolute top-50 translate-middle-y text-muted fs-5" style="right: 0.85rem; pointer-events: none;"></i>
                                <button type="button" class="btn btn-link position-absolute top-50 translate-middle-y text-secondary p-0 text-decoration-none toggle-password" data-target="password_confirmation" style="left: 0.85rem; z-index: 10;">
                                    <i class="bi bi-eye fs-5"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-shield-check"></i> تحديث كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    });
</script>
@endsection
