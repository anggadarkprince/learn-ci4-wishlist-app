<?= $this->extend('layouts/profile') ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="profile-wrapper d-sm-flex justify-content-center align-items-center">
                <div class="profile-avatar text-sm-center">
                    <img src="<?= base_url(if_empty($user->avatar, 'assets/img/layouts/no-avatar.png', 'uploads/')) ?>"
                         alt="avatar" class="img-fluid rounded my-2 mx-auto">
                </div>
                <div class="profile-info">
                    <h3 class="profile-name d-inline-block"><?= $user->name ?> <small>(<?= $user->username ?>)</small></h3>
                    <a href="<?= site_url('/account') ?>" class="btn btn-sm btn-outline-light ml-3">
                        <i class="mdi mdi-settings-outline mr-0"></i><span class="d-none d-sm-inline-block ml-2">EDIT PROFILE</span>
                    </a>
                    <ul class="list-unstyled">
                        <li class="list-inline-item"><strong><?= $pager->getDetails()['total'] ?></strong> wishes</li>
                        <li class="list-inline-item"><strong>23</strong> shared dreams</li>
                    </ul>
                    <p class="font-weight-600 mb-0"><?= $user->email ?></p>
                    <p><?= text_to_link($user->about) ?></p>
                    <?php if($user->id == auth('id')): ?>
                        <a href="<?= site_url('wishlists/new') ?>" class="btn btn-primary mx-auto">
                            Create Wishlist
                        </a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    <hr class="border-light opacity-1">
    <ul class="nav justify-content-center mb-5 profile-nav">
        <li class="list-inline-item">
            <a class="nav-link<?= $section == '' ? ' active' : '' ?>" href="<?= site_url('/' . $user->username) ?>">All Posts</a>
        </li>
        <li class="list-inline-item">
            <a class="nav-link<?= $section == 'shared' ? ' active' : '' ?>" href="<?= site_url('/' . $user->username . '/shared') ?>">Shared</a>
        </li>
        <li class="list-inline-item">
            <a class="nav-link<?= $section == 'completed' ? ' active' : '' ?>" href="<?= site_url('/' . $user->username . '/completed') ?>">Completed</a>
        </li>
    </ul>
    <?= $this->include('discovery/_wishlist_card') ?>
<?= $this->endSection() ?>