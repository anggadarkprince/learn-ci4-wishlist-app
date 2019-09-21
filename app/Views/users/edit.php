<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form action="<?= site_url('master/users/' . $user->id) ?>" method="POST"  enctype="multipart/form-data" id="form-user" class="edit">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Create New User</h4>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required maxlength="50"
                                   value="<?= set_value('name', $user->name) ?>" placeholder="Enter your full name">
                            <?= service('validation')->showError('name'); ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required maxlength="20"
                                   value="<?= set_value('username', $user->username) ?>" placeholder="User unique ID">
                            <?= service('validation')->showError('username'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required maxlength="50"
                           value="<?= set_value('email', $user->email) ?>" placeholder="Enter email address">
                    <?= service('validation')->showError('email'); ?>
                </div>
                <div class="form-group">
                    <label>Avatar</label>
                    <input type="file" id="avatar" name="avatar" class="file-upload-default" data-max-size="3000000" accept="image/*">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" value="<?= $user->avatar ?>" disabled placeholder="Upload photo" aria-label="path">
                        <span class="input-group-append">
                        <button class="file-upload-browse btn btn-success btn-simple-upload" type="button">
                            Upload
                        </button>
                    </span>
                    </div>
                    <?= service('validation')->showError('avatar'); ?>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="custom-select" name="status" id="status" required>
                        <option value="">-- Please select --</option>
                        <option value="<?= App\Models\UserModel::STATUS_PENDING ?>"
                            <?= set_select('status', App\Models\UserModel::STATUS_PENDING, $user->status == App\Models\UserModel::STATUS_PENDING) ?>>
                            <?= App\Models\UserModel::STATUS_PENDING ?>
                        </option>
                        <option value="<?= App\Models\UserModel::STATUS_ACTIVATED ?>"
                            <?= set_select('status', App\Models\UserModel::STATUS_ACTIVATED, $user->status == App\Models\UserModel::STATUS_ACTIVATED) ?>>
                            <?= App\Models\UserModel::STATUS_ACTIVATED ?>
                        </option>
                        <option value="<?= App\Models\UserModel::STATUS_SUSPENDED ?>"
                            <?= set_select('status', App\Models\UserModel::STATUS_SUSPENDED, $user->status == App\Models\UserModel::STATUS_SUSPENDED) ?>>
                            <?= App\Models\UserModel::STATUS_SUSPENDED ?>
                        </option>
                    </select>
                    <?= service('validation')->showError('status'); ?>
                </div>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Role</h4>
                <p class="text-muted">User at least must has one role</p>
                <?= service('validation')->showError('roles'); ?>

                <div class="row">
                    <?php foreach ($roles as $role): ?>
                        <?php
                        $hasRole = false;
                        foreach ($userRoles as $userRole) {
                            if ($role->id == $userRole->role_id) {
                                $hasRole = true;
                                break;
                            }
                        }
                        ?>
                        <div class="col-sm-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"<?= set_checkbox('roles', $role->id, $hasRole); ?>
                                       id="role_<?= $role->id ?>" name="roles[]" value="<?= $role->id ?>">
                                <label class="custom-control-label" for="role_<?= $role->id ?>">
                                    <?= strtoupper($role->role) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Credential</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="6"
                                   maxlength="50" placeholder="New password">
                        </div>
                        <span class="form-text">Leave it blank if you don't change the password.</span>
                        <?= service('validation')->showError('password'); ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                   maxlength="50" placeholder="Confirm new password">
                        </div>
                        <?= service('validation')->showError('confirm_password'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
                <button type="submit" class="btn btn-primary" data-toggle="one-touch" data-touch-message="Updating...">
                    Update User
                </button>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>