<div class="sidebar d-flex flex-column bg-white border-end p-3">
    <ul class="nav nav-pills flex-column mb-auto gap-2">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : 'link-dark' }} rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-speedometer2 me-2 fs-5"></i>
                <span>لوحة التحكم</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : 'link-dark' }} rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-people me-2 fs-5"></i>
                <span>الموظفين</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('attendances.index') }}" class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : 'link-dark' }} rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-calendar-check me-2 fs-5"></i>
                <span>التحضير اليومي</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.attendance') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : 'link-dark' }} rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-file-earmark-bar-graph me-2 fs-5"></i>
                <span>تقارير الحضور</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : 'link-dark' }} rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-building me-2 fs-5"></i>
                <span>الأقسام</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link link-dark rounded-3 d-flex align-items-center py-2 px-3">
                <i class="bi bi-person me-2 fs-5"></i>
                <span>الملف الشخصي</span>
            </a>
        </li>
     
    </ul>

    <div class="mt-auto pt-3 border-top">
        <a href="{{ route('logout') }}"
           class="nav-link rounded-3 d-flex align-items-center py-2 px-3 btn-logout"
           style="background-color: #f64f4fff; color: #000; font-weight: 500; border: 1px solid #ff0000ff;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2 fs-5 text-dark fw-bold"></i>
            <span class="text-dark fw-bold">تسجيل الخروج</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>