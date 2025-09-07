<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark" role="navigation" aria-label="Боковое меню">
    <div class="sidebar-brand">
        <a href="{{ route('admin.home') }}" class="brand-link">
            <img src="{{ asset('adminlte/assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">AdminLTE</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" aria-label="Main navigation" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-calendar-event-fill"></i>
                        <p>События</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logout') }}" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Выход</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
