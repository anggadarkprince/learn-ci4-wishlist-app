<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form class="form-plaintext">
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">View User</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="name">Name</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="name">
                                    <?= if_empty($user->name, 'No name') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="username">Username</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="username">
                                    <?= if_empty($user->username, 'No username') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="avatar">Avatar</label>
                            <div class="col-sm-8">
                                <img src="<?= base_url(if_empty($user->avatar, 'assets/dist/img/layouts/no-avatar.png', 'writable/uploads/')) ?>"
                                     alt="avatar" class="img-fluid rounded my-2" style="max-width: 100px">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="email">Email</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="email">
                                    <a href="mailto:<?= $user->email ?>">
                                        <?= if_empty($user->email, 'No email') ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="status">Status</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="status">
                                    <?php
                                    $statusLabels = [
                                        App\Models\UserModel::STATUS_PENDING => 'light',
                                        App\Models\UserModel::STATUS_SUSPENDED => 'danger',
                                        App\Models\UserModel::STATUS_ACTIVATED => 'success',
                                    ];
                                    ?>
                                    <span class="label label-<?= get_if_exist($statusLabels, $user->status, 'primary') ?>">
                                        <?= $user->status ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="created_at">Created At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="created_at">
                                    <?= $user->created_at->format('d F Y H:i') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="updated_at">Updated At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="updated_at">
                                    <?= $user->updated_at ? $user->updated_at->format('d F Y H:i') : '' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">User Roles</h4>
                <table class="table table-md responsive">
                    <thead>
                    <tr>
                        <th style="width: 20px">No</th>
                        <th>Role</th>
                        <th>Description</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($roles as $index => $role): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $role->role ?></td>
                            <td><?= $role->description ?></td>
                            <td><?= format_date($role->created_at, 'd F Y H:i') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
                <a href="<?= site_url('master/users/' . $user->id . '/edit') ?>" class="btn btn-primary">
                    Edit User
                </a>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>