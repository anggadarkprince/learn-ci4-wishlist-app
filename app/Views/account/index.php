<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form action="<?= site_url('account') ?>" method="post" enctype="multipart/form-data" id="form-account">
        <?= csrf_field() ?>
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Account Setting</h4>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required maxlength="50"
                                   value="<?= set_value('name', $user->name) ?>" placeholder="Enter your full name">
                            <?= service('validation')->showError('name') ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" maxlength="50"
                                   value="<?= set_value('username', $user->username) ?>" placeholder="User unique ID">
                            <?= service('validation')->showError('username') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="50"
                           value="<?= set_value('email', $user->email) ?>" placeholder="Enter email address">
                    <?= service('validation')->showError('email') ?>
                </div>
                <div class="form-group">
                    <label>Avatar</label>
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url(if_empty($user->avatar, 'assets/img/layouts/no-avatar.png', 'uploads/')) ?>"
                             alt="avatar" class="d-block img-fluid rounded my-2 mr-3" style="max-width: 100px">
                        <div class="flex-grow-1">
                            <input type="file" id="avatar" name="avatar" class="file-upload-default" data-max-size="3000000" accept="image/*">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload photo" aria-label="Avatar">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-success btn-simple-upload" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?= service('validation')->showError('avatar') ?>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Password</h4>
                <div class="form-group">
                    <label for="password">Current Password</label>
                    <input type="password" class="form-control" id="password" name="password" required maxlength="50" placeholder="Enter your current password">
                    <?= service('validation')->showError('password') ?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6" maxlength="50" placeholder="Replace password with">
                            <small class="form-text text-gray mt-2">Leave it blank if you don't intent to change your password.</small>
                            <?= service('validation')->showError('new_password') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" maxlength="50" placeholder="Confirm new password">
                            <?= service('validation')->showError('confirm_password') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button type="button" onclick="history.back()" class="btn btn-light">Back</button>
                <button type="submit" class="btn btn-primary" data-toggle="one-touch" data-touch-message="Updating...">Update Account</button>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>