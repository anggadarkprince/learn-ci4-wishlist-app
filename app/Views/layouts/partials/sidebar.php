<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0 text-blue" href="<?= site_url('/') ?>">
            <img src="<?= base_url('assets/img/layouts/icon.png') ?>" alt="logo" style="max-width: 25px" class="d-inline-block mb-1 opacity-7">
            Wishlist
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <?= $this->include('layouts/partials/account') ?>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="<?= site_url('/') ?>">
                            Wishlist
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler align-middle mb-1" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="mdi mdi-magnify"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item active">
                    <a class=" nav-link active" href="<?= site_url('dashboard') ?>">
                        <i class="mdi mdi-monitor-dashboard text-yellow"></i> Dashboard
                    </a>
                </li>
                <?php if(is_authorized(PERMISSION_ROLE_VIEW)): ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?= site_url('master/roles') ?>">
                            <i class="mdi mdi-shield-account text-teal"></i> Roles
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(is_authorized(PERMISSION_USER_VIEW)): ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?= site_url('master/users') ?>">
                            <i class="mdi mdi-account-multiple text-success"></i> Users
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(is_authorized(PERMISSION_WISHLIST_VIEW)): ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?= site_url('wishlists') ?>">
                            <i class="mdi mdi-gift text-blue"></i> Wish lists
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?= site_url('logout') ?>">
                        <i class="mdi mdi-exit-to-app text-orange"></i> Sign out
                    </a>
                </li>
            </ul>
            <?php if(is_authorized(PERMISSION_ACCOUNT_EDIT)
                || is_authorized(PERMISSION_SETTING_EDIT)): ?>
                <!-- Heading -->
                <h6 class="navbar-heading text-muted">Personalize</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <?php if(is_authorized(PERMISSION_ACCOUNT_EDIT)): ?>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= site_url('account') ?>">
                                <i class="mdi mdi-account-outline"></i> My Account
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(is_authorized(PERMISSION_SETTING_EDIT)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('setting') ?>">
                                <i class="mdi mdi-settings-outline"></i> Setting
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
            <?php if(is_authorized(PERMISSION_UTILITY_EDIT)): ?>
                <!-- Heading -->
                <h6 class="navbar-heading text-muted">Preference</h6>
                <!-- Navigation -->
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('backup') ?>">
                            <i class="mdi mdi-backup-restore"></i> Backup
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('logs') ?>">
                            <i class="mdi mdi-note-outline"></i> Logs
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>