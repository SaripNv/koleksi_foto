<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav mx-3">
        <li class="nav-item"><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                    class="fas fa-bars"></i></a></li>
    </ul>
    <ul class="navbar-nav ms-auto me-3 align-items-center">
        <!-- Dropdown User -->
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img alt="image"
                    src="<?= base_url('uploads/profile/' . (session('profile_picture') ?? 'default.png')) ?>"
                    class="rounded-circle me-1" style="width: 30px; height: 30px; object-fit: cover;"
                    onerror="this.onerror=null;this.src='<?= base_url('assets/uploads/profile/default.png') ?>'">
                <span class="d-sm-none d-lg-inline-block">Hi, <?= session('username') ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end"
                style="--bs-dropdown-link-active-bg: transparent; --bs-dropdown-link-active-color: transparent;">
                <div class="dropdown-title has-icon d-sm-block d-block"><i class="far fa-user"></i> Hi,
                    <?= session('username') ?>
                </div>
                <a href="<?= route_to('profile') ?>" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <div class="dropdown-item">
                    <div class="btn-group w-100" id="bs-theme" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn btn-outline-primary btn-icon" data-bs-toggle="tooltip"
                            data-bs-title="Mode Cerah" data-bs-theme-value="light"><i class="far fa-sun"></i></button>
                        <button type="button" class="btn btn-outline-primary btn-icon" data-bs-toggle="tooltip"
                            data-bs-title="Mode Gelap" data-bs-theme-value="dark"><i class="far fa-moon"></i></button>
                        <button type="button" class="btn btn-outline-primary btn-icon" data-bs-toggle="tooltip"
                            data-bs-title="Mode Otomatis" data-bs-theme-value="auto"><i
                                class="fas fa-laptop"></i></button>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('/logout') ?>" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>