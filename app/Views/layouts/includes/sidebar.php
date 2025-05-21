<div class="main-sidebar sidebar-style-2 shadow-sm">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?=base_url('dashboard/')?>">FOTO PERUM BULOG</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">FPB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?=(url_is('dashboard/')) ? 'active' : ''?>">
                <a href="<?=base_url('dashboard/')?>" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <!-- Menu Profile -->
            <li class="<?= (url_is('dashboard/profile*')) ? 'active' : '' ?>">
                <a href="<?= route_to('profile') ?>" class="nav-link">
                    <i class="fas fa-user"></i><span>My Profile</span>
                </a>
            </li>

            <li class="menu-header">Gallery</li>
            <li class="<?=(url_is('dashboard/galleries*')) ? 'active' : ''?>">
                <a href="<?=base_url('dashboard/galleries')?>" class="nav-link"><i
                        class="fas fa-images"></i><span>Galleries</span></a>
            </li>
            <li class="<?=(url_is('dashboard/categories*')) ? 'active' : ''?>">
                <a href="<?=base_url('dashboard/categories')?>" class="nav-link"><i
                        class="fas fa-folder"></i><span>Categories</span></a>
            </li>

            <li class="<?=(url_is('dashboard/users*')) ? 'active' : ''?>">
                <a href="<?=base_url('dashboard/users')?>" class="nav-link"><i
                        class="fas fa-users"></i><span>Users</span></a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini justify-content-center d-flex">
        </div>
    </aside>
</div>