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








                <!--
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div> -->



                <div class="user-dropdown">
                    <button class="user-dropdown-btn" id="userDropdownBtn">
                        <div class="user-info">
                            <img class="user-avatar" src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="User Avatar">
                            <div class="user-details">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ Auth::user()->is_admin ? 'admin' : 'user' }}</span>
                            </div>
                        </div>
                    </button>
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="mdi mdi-logout"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Thêm Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.0/dist/umd/popper.min.js"></script>

<style>
.user-dropdown {
    position: relative;
    margin-left: 1rem;
}

.user-dropdown-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.user-details {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.user-name {
    font-weight: 500;
    font-size: 0.875rem;
    color: #333;
}

.user-role {
    font-size: 0.75rem;
    color: #666;
}

.user-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 200px;
    display: none;
    z-index: 1000;
}

.user-dropdown-menu.show {
    display: block;
}

.dropdown-header {
    padding: 0.75rem 1rem;
    font-weight: 500;
    color: #666;
}

.dropdown-divider {
    height: 1px;
    background: #eee;
    margin: 0.25rem 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    color: #333;
    text-decoration: none;
    transition: background-color 0.2s;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item i {
    font-size: 1.25rem;
    color: #666;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownBtn = document.getElementById('userDropdownBtn');
    const dropdownMenu = document.getElementById('userDropdownMenu');

    // Toggle dropdown menu
    dropdownBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdownMenu.classList.toggle('show');
    });

    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function(e) {
        if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
</script>
