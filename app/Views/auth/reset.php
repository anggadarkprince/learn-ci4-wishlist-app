<?= $this->extend('layouts/auth') ?>

<?= $this->section('header') ?>
    <div class="container">
        <div class="header-body text-center mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Password Recovery</h1>
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
                <div class="card-body px-lg-5 pb-lg-4 pt-lg-5">
                    <form action="<?= site_url('reset-password/' . $token->token) ?>" method="post" role="form" id="form-register">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email address" type="email" name="email" readonly value="<?= $token->email ?>" required aria-label="Username">
                            </div>
                            <?= service('validation')->showError('email') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="New password" type="password" id="password" name="password" required minlength="6" maxlength="50" aria-label="Password">
                            </div>
                            <?= service('validation')->showError('password') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Confirm new password" type="password" id="confirm_password" name="confirm_password" aria-label="Confirm password">
                            </div>
                            <?= service('validation')->showError('confirm_password') ?>
                        </div>
                        <div class="text-muted font-italic">
                            <small>Password strength: <span class="text-success font-weight-700" id="password-strength">none</span></small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg btn-block my-4" data-toggle="one-touch" data-touch-message="Resetting...">Reset My Password</button>
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