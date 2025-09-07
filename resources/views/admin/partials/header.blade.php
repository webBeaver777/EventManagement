<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav" role="navigation" aria-label="Navigation 1">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item user-menu">
                <a href="#" class="nav-link" id="user-profile-link">
                    <span class="d-none d-md-inline" id="user-profile-name"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logout') }}" class="btn btn-primary">Выйти</a>
            </li>
        </ul>
    </div>
</nav>
