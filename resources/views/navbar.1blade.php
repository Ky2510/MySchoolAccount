<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
        <a class="sidebar-brand brand-logo" href="index.html"><img src="{{ asset('layouts_backend') }}/assets/images/logo.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="index.html"><img src="{{ asset('layouts_backend') }}/assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
            <div class="nav-profile-image">
            <img src="{{ asset('layouts_backend') }}/assets/images/faces/face1.jpg" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
            </div>
            <div class="nav-profile-text d-flex flex-column pr-3">
            <span class="font-weight-medium mb-2">{{ Auth::user()->name }}</span>
            <span class="font-weight-normal">$8,753.00</span>
            </div>
            <span class="badge badge-danger text-white ml-3 rounded">3</span>
        </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Data User</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('siswa.index') }}" class="nav-link">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Data Siswa</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('wali.index') }}" class="nav-link">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Data Wali Murid</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('biaya.index') }}" class="nav-link">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Data Biaya</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tagihan.index') }}" class="nav-link">
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
                <span class="menu-title">Data Tagihan</span>
            </a>
        </li>
        <li class="nav-item sidebar-actions">
            <div class="nav-link">
                <div class="mt-4">
                    <ul class="mt-4 pl-0">
                        <li>
                            <a href="{{ route('logout') }}" class="nav-link" href="pages/ui-features/typography.html">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</nav>

