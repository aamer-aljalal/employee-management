<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام إدارة الموظفين</title>
    
    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-Regular.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-SemiBold.ttf") }}') format('truetype');
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-Bold.ttf") }}') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        body {
            background-color: #f9fafb;
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 1.5rem;
        }
        
        .login-container {
            max-width: 28rem; /* 448px */
            width: 100%;
            margin: 0 auto;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-title {
            font-weight: 800;
            font-size: 1.75rem;
            color: #111827;
            letter-spacing: -0.025em;
            margin: 0;
        }
        
        .login-card {
            background-color: #ffffff;
            border-radius: 1rem; /* 16px */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            padding: 2.5rem 2.5rem;
        }
        
        .login-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .login-input {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.625rem 0.875rem;
            font-size: 0.95rem;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            direction: ltr; /* Keeping LTR for emails/passwords */
            text-align: right;
            background-color: #ffffff;
            color: #111827;
            outline: none;
        }
        
        .login-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .login-input::placeholder {
            color: #9ca3af;
        }
        
        .login-btn {
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 0.5rem;
            padding: 0.625rem 1rem;
            width: 100%;
            border: none;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s;
            margin-top: 1rem;
        }
        
        .login-btn:hover {
            background-color: #2563eb;
            color: #ffffff;
        }
        
        .login-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .login-link:hover {
            color: #2563eb;
            text-decoration: underline;
        }
        
        .custom-checkbox {
            width: 1.1rem;
            height: 1.1rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            cursor: pointer;
            outline: none;
        }
        .custom-checkbox:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">نظام إدارة الموظفين</h1>
        </div>
        
        <div class="login-card">
            <div class="text-center mb-4 pb-2">
                <h2 class="fs-5 fw-bold text-dark mb-2">تسجيل الدخول</h2>
                <p class="text-secondary" style="font-size: 0.9rem;">مرحباً بك مجدداً، يرجى إدخال بياناتك للمتابعة.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="login-label">البريد الإلكتروني</label>
                    <input id="email" type="email" class="login-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@example.com">
                    @error('email')
                        <span class="text-danger d-block fw-bold small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="login-label mb-0">كلمة المرور</label>
                        @if (Route::has('password.request'))
                            <a class="login-link" href="{{ route('password.request') }}">
                                نسيت كلمة المرور؟
                            </a>
                        @endif
                    </div>
                    <div class="position-relative">
                        <input id="password" type="password" class="login-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••" style="padding-left: 2.75rem;">
                        <button type="button" class="btn btn-link position-absolute top-50 translate-middle-y text-secondary p-0 text-decoration-none toggle-password" data-target="password" style="left: 0.75rem; z-index: 10;">
                            <i class="bi bi-eye fs-5"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger d-block fw-bold small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 m-0 p-0">
                        <input class="custom-checkbox m-0" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="text-secondary fw-semibold m-0" for="remember" style="font-size: 0.875rem; cursor: pointer; padding-right: 0.25rem;">
                            تذكرني
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    تسجيل الدخول
                </button>
            </form>
        </div>

        <div class="login-footer">
            جميع الحقوق محفوظة &copy; {{ date('Y') }} نظام إدارة الموظفين
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
</body>
</html>
