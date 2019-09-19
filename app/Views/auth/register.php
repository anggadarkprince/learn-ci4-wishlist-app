<?= $this->extend('layouts/auth') ?>

<?= $this->section('header') ?>
    <div class="container">
        <div class="header-body text-center mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">Join with Us!</h1>
                    <p class="text-lead text-light">
                        Complete the form bellow and confirm your registration via email to officially join us.
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
                    <div class="text-muted text-center mt-2 mb-3"><small>Sign up with</small></div>
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
                        <small>Or sign up with credentials</small>
                    </div>
                    <form action="<?= site_url('register') ?>" method="post" role="form" id="form-register">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-account-badge-horizontal-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Full name" type="text" id="name" name="name" value="<?= set_value('name') ?>" required maxlength="50" aria-label="Full name">
                            </div>
                            <?= service('validation')->showError('name') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Username" type="text" id="username" name="username" value="<?= set_value('username') ?>" required maxlength="50" aria-label="Username">
                            </div>
                            <?= service('validation')->showError('username') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Email address" type="email" id="email" name="email" value="<?= set_value('email') ?>" required maxlength="50" aria-label="Email address">
                            </div>
                            <?= service('validation')->showError('email') ?>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                </div>
                                <input class="form-control" placeholder="Password" type="password" id="password" name="password" value="<?= set_value('password') ?>" required minlength="6" maxlength="50" aria-label="Password">
                            </div>
                            <?= service('validation')->showError('password') ?>
                        </div>
                        <div class="text-muted font-italic">
                            <small>Password strength: <span class="text-success font-weight-700" id="password-strength">none</span></small>
                        </div>
                        <div class="row my-4">
                            <div class="col-12">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="agreement" name="agreement" type="checkbox" <?= set_checkbox('agreement', 'on') ?> required>
                                    <label class="custom-control-label" for="agreement">
                                        <span class="text-muted">I agree with the <a href="<?= site_url('privacy') ?>">Privacy Policy</a></span>
                                    </label>
                                </div>
                                <?= service('validation')->showError('agreement') ?>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg btn-block my-4" data-toggle="one-touch">Create account</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="<?= site_url('login') ?>" class="text-light"><small>Has an account? login now</small></a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>