<!-- wrapper -->
<div class="wrapper">
    <!--sidebar-wrapper-->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div class="">
                <img src="<?= base_url('assets/images/logo-icon.png') ?>" class="logo-icon-2" alt="" />
            </div>
            <div>
                <h4 class="logo-text">SIMGudang</h4>
            </div>
            <a href="javascript:;" class="toggle-btn ms-auto">
                <i class="bx bx-menu"></i>
            </a>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?= base_url('home') ?>">
                    <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i></div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            <li class="menu-label">DATA TRANSAKSI</li>
            <li>
                <a href="<?= base_url('purchase') ?>">
                    <div class="parent-icon icon-color-5"><i class="bx bx-cart"></i></div>
                    <div class="menu-title">Manajemen Pembelian</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('incoming-item') ?>">
                    <div class="parent-icon icon-color-2"><i class="bx bx-import"></i></div>
                    <div class="menu-title">Data Barang Masuk</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('outgoing-item') ?>">
                    <div class="parent-icon icon-color-3"><i class="bx bx-export"></i></div>
                    <div class="menu-title">Data Barang Keluar</div>
                </a>
            </li>

            <li class="menu-label">DATA MASTER</li>
            <li>
                <a href="<?= base_url('product') ?>">
                    <div class="parent-icon icon-color-4"><i class="bx bx-package"></i></div>
                    <div class="menu-title">Data Barang</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('category') ?>">
                    <div class="parent-icon icon-color-6"><i class="bx bx-category"></i></div>
                    <div class="menu-title">Kategori Barang</div>
                </a>
            </li>

            <li class="menu-label">LAPORAN</li>
            <li>
                <a href="<?= base_url('report') ?>">
                    <div class="parent-icon icon-color-7"><i class="bx bx-bar-chart-alt"></i></div>
                    <div class="menu-title">Laporan</div>
                </a>
            </li>

            <li class="menu-label">MANAJEMEN USER</li>
            <li>
                <a href="<?= base_url('user') ?>">
                    <div class="parent-icon icon-color-9"><i class="bx bx-user"></i></div>
                    <div class="menu-title">Manajemen User</div>
                </a>
            </li>

            <li class="menu-label">LOGOUT</li>
            <li>
                <a href="<?= base_url('logout') ?>">
                    <div class="parent-icon icon-color-10"><i class="bx bx-log-out"></i></div>
                    <div class="menu-title">Logout</div>
                </a>
            </li>
        </ul>
        <!--end navigation-->
    </div>

    <!--end sidebar-wrapper-->
    <!--header-->
    <header class="top-header">
        <nav class="navbar navbar-expand">
            <div class="left-topbar d-flex align-items-center">
                <a href="javascript:;" class="toggle-btn"> <i class="bx bx-menu"></i>
                </a>
            </div>
            <div class="right-topbar ms-auto">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown dropdown-user-profile">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                            data-bs-toggle="dropdown">
                            <div class="d-flex user-box align-items-center">
                                <div class="user-info">
                                    <p class="user-name mb-0">
                                        <?= esc(logged_in() ? user()->username : 'Guest') ?>
                                    </p>
                                </div>
                                <img src="<?= base_url(); ?>assets/images/avatars/avatar-1.png" class="user-img"
                                    alt="user avatar">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-user"></i><span>Profile</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-cog"></i><span>Settings</span></a>
                            <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-tachometer"></i><span>Dashboard</span></a>
                            <div class="dropdown-divider mb-0"></div> <a class="dropdown-item" href="javascript:;"><i
                                    class="bx bx-power-off"></i><span>Logout</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--end header-->
</div>
<!--end wrapper-->