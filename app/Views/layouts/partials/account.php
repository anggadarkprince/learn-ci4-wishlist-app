<li class="nav-item dropdown">
    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="media align-items-center">
            <span class="avatar avatar-sm rounded-circle">
                <img alt="Avatar" src="<?= base_url('assets/img/layouts/no-avatar.png') ?>">
            </span>
            <div class="media-body ml-2 d-none d-lg-block">
                <span class="mb-0 text-sm  font-weight-bold"><?= auth('name') ?></span>
            </div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
        <div class=" dropdown-header noti-title">
            <h6 class="text-overflow m-0">Welcome</h6>
        </div>

        <a href="<?= site_url('/' . auth('username')) ?>" class="dropdown-item">
            <i class="mdi mdi-account-outline"></i>
            <span>My profile</span>
        </a>
        <?php if(is_authorized(PERMISSION_SETTING_EDIT)): ?>
            <a href="<?= site_url('setting') ?>" class="dropdown-item">
                <i class="mdi mdi-settings-outline"></i>
                <span>Settings</span>
            </a>
        <?php endif; ?>
        <?php if(is_authorized(PERMISSION_WISHLIST_VIEW)): ?>
            <a href="<?= site_url('wishlists') ?>" class="dropdown-item">
                <i class="mdi mdi-gift-outline"></i>
                <span>Wishlist</span>
            </a>
        <?php endif; ?>
        <a href="<?= site_url('help') ?>" class="dropdown-item">
            <i class="mdi mdi-help-circle-outline"></i>
            <span>Support</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= site_url('logout') ?>" class="dropdown-item">
            <i class="mdi mdi-logout-variant"></i>
            <span>Sign out</span>
        </a>
    </div>
</li>