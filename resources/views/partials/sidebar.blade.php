<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex align-items-center px-3 py-2">
        <!-- Brand Logo -->
        <a href="/" class="app-brand-link d-flex align-items-center text-decoration-none">

            <!-- Left Logo Image -->
            <span class="app-brand-logo me-2">
                <img src="{{ asset('assets/img/logo/folders.png') }}" alt="Logo" style="height:40px;">
            </span>

            <!-- Brand Text -->
            <span class="app-brand-text d-flex flex-column">
                <span class="fw-bold fs-4 text-primary">SIPAS</span>
                <small class="text-muted fw-normal fs-6">Sistem Arsip Surat</small>
            </span>
        </a>

        <!-- Sidebar Toggle (Mobile) -->
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>


    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        @if (auth()->user()->role == 'admin')
            <li class="menu-item {{ Route::is('dashboard.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>

            <li class="menu-item {{ Route::is('arsip.*') ? 'active' : '' }}">
                <a href="{{ route('arsip.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="Analytics">Arsip</div>
                </a>
            </li>
            <li class="menu-item {{ Route::is('kategori-surat.*') ? 'active' : '' }}">
                <a href="{{ route('kategori-surat.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-box"></i>
                    <div data-i18n="Analytics">Kategori Surat</div>
                </a>
            </li>
            </li>
            <li class="menu-item {{ Route::is('biodata.*') ? 'active' : '' }}">
                <a href="{{ route('biodata.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-copy"></i>
                    <div data-i18n="Analytics">About</div>
                </a>
            </li>
        @else
            <li class="menu-item {{ Route::is('dashboard-user.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard-user.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
             <li class="menu-item {{ Route::is('arsip.*') ? 'active' : '' }}">
                <a href="{{ route('arsip.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-detail"></i>
                    <div data-i18n="Analytics">Arsip</div>
                </a>
            </li>
        @endif


    </ul>
</aside>
