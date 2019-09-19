<?= $this->extend('layouts/auth') ?>

<?= $this->section('header') ?>
    <div class="container">
        <div class="header-body text-center mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Reset Password</h1>
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
                    <div class="text-center text-muted">
                        Enter your email address that you used to register. We'll send you an email with your username and a
                        link to reset your password.
                    </div>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                    <form action="<?= site_url('forgot-password') ?>" method="post" role="form">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email address" type="email" name="email" value="<?= set_value('username') ?>" aria-label="Username">
                            </div>
                            <?= service('validation')->showError('email') ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg btn-block my-4" data-toggle="one-touch">Reset My Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <a href="<?= site_url('login') ?>" class="text-light"><small>Remember password?</small></a>
                </div>
                <div class="col-6 text-right">
                    <a href="<?= site_url('register') ?>" class="text-light"><small>Create new account</small></a>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>