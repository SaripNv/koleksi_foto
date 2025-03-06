<div class="main-sidebar sidebar-style-2 shadow-sm">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">FOTO PERUM BULOG</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img width="30px" class="navbar-brand" src="<?=base_url('/assets/gallery/LOGO-1.png')?>" />
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="<?=(url_is('admin/')) ? 'active' : ''?>">
                <a href="<?=base_url('admin/')?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Gallery</li>
            <li class="<?=(url_is('admin/galleries')) ? 'active' : ''?>">
                <a href="<?=base_url('admin/galleries')?>" class="nav-link"><i
                        class="fas fa-images"></i><span>Galleries</span></a>
            </li>
            <li class="<?=(url_is('admin/categories')) ? 'active' : ''?>">
                <a href="<?=base_url('admin/categories')?>" class="nav-link"><i
                        class="fas fa-folder"></i><span>Categories</span></a>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini justify-content-center d-flex">
        </div>
    </aside>
</div>