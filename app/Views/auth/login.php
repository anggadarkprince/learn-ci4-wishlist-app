<?= $this->extend('layouts/auth') ?>

<?= $this->section('header') ?>
    <div class="container">
        <div class="header-body text-center mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Hi, awesome!</h1>
                    <p class="text-lead text-light">
                        Use these forms to login or create new account to access Wishlist's feature.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent pb-4">
                    <div class="text-muted text-center mt-2 mb-3"><small>Sign in with</small></div>
                    <div class="btn-wrapper text-center">
                        <a href="#" class="btn btn-neutral btn-icon mr-4">
                            <span class="btn-inner--icon"><img src="<?= base_url('assets/img/icons/github.svg') ?>" alt="Github"></span>
                            <span class="btn-inner--text">Github</span>
                        </a>
                        <a href="#" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon"><img src="<?= base_url('assets/img/icons/google.svg') ?>" alt="Google"></span>
                            <span class="btn-inner--text">Google</span>
                        </a>
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                    <div class="text-center text-muted mb-4">
                        <small>Or sign in with credentials</small>
                    </div>
                    <form action="<?= site_url('login') ?>" method="post" role="form">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Username or email" type="text" name="username" value="<?= set_value('username') ?>" aria-label="Username">
                            </div>
                            <?= service('validation')->showError('username') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Password" type="password" name="password" aria-label="Password">
                            </div>
                            <?= service('validation')->showError('password') ?>
                        </div>
                        <div class="custom-control custom-control-alternative custom-checkbox">
                            <input class="custom-control-input" id="remember" type="checkbox" name="remember">
                            <label class="custom-control-label" for="remember">
                                <span class="text-muted">Remember me</span>
                            </label>
                        </div>
                        <?= service('validation')->showError('remember') ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg btn-block my-4">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <a href="<?= site_url('forgot-password') ?>" class="text-light"><small>Forgot password?</small></a>
                </div>
                <div class="col-6 text-right">
                    <a href="<?= site_url('register') ?>" class="text-light"><small>Create new account</small></a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>