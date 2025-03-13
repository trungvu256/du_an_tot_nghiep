<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">

                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt=""
                                height="150">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('template/admin/velzon/assets/images/logo03.JPG') }}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('template/admin/velzon/assets/images/logo03.JPG') }}" alt=""
                                height="150">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->

            </div>

            <div class="d-flex align-items-center">









                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>



                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button class="btn dropdown-toggle" type="button" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('template/admin/velzon/assets/images/users/avatar-1.jpg') }}"
                                alt="Header Avatar" width="40" height="40">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    @if (Auth::check())
                                    {{ Auth::user()->name }}
                                    @endif
                                </span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->is_admin ? 'admin' : 'user' }}</span>
                            </span>
                        </span>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Hồ sơ</a></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Đăng xuất</a></li>
                    </ul>
                    {{-- <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a class="dropdown-item" href="pages-profile.html"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat.html"><i
                                class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                                class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i
                                class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile.html"><i
                                class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Balance : <b>$5971.67</b></span></a>
                        <a class="dropdown-item" href="pages-profile-settings.html"><span
                                class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                                class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                                class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Lock screen</span></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

</header>

</header>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});

</script>

