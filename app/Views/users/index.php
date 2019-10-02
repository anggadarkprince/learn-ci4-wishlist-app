<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="card-title mb-sm-0">Data Users</h4>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary px-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary px-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <?php if(is_authorized(PERMISSION_USER_CREATE)): ?>
                        <a href="<?= site_url('master/users/new') ?>" class="btn btn-success">
                            <i class="mdi mdi-plus-box-outline mr-1"></i>CREATE
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <table class="table table-hover table-md mt-3 responsive">
                <thead>
                <tr>
                    <th class="text-md-center" style="width: 60px">No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th style="min-width: 120px" class="text-md-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $statusLabels = [
                    App\Models\UserModel::STATUS_PENDING => 'light',
                    App\Models\UserModel::STATUS_SUSPENDED => 'danger',
                    App\Models\UserModel::STATUS_ACTIVATED => 'success',
                ];
                ?>
                <?php $no = isset($users) ? ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] : 0 ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td><?= $user->name ?></td>
                        <td><?= $user->username ?></td>
                        <td><?= $user->email ?></td>
                        <td><?= str_replace(',', '<br>', if_empty($user->roles, '-')) ?></td>
                        <td>
                            <span class="badge badge-<?= get_if_exist($statusLabels, $user->status, 'primary') ?>">
                                <?= $user->status ?>
                            </span>
                        </td>
                        <td class="text-md-right">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-action mr-0" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if(is_authorized(PERMISSION_USER_VIEW)): ?>
                                        <a class="dropdown-item" href="<?= site_url('master/users/' . $user->id) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                    <?php endif; ?>
                                    <?php if(is_authorized(PERMISSION_USER_EDIT)): ?>
                                        <a class="dropdown-item" href="<?= site_url('master/users/' . $user->id . '/edit') ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php if(is_authorized(PERMISSION_USER_DELETE)): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal" data-id="<?= $user->id ?>" data-label="<?= $user->role ?>" data-title="Role" data-url="<?= site_url('master/users/' . $user->id) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)) : ?>
                    <tr>
                        <td colspan="7">No users data available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2 mb-sm-0">Showing <?= count($users) ?> of <?= $pager->getDetails()['total'] ?> entries</small>
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
    <?= $this->include('users/_modal_filter') ?>
    <?= $this->include('layouts/modals/delete') ?>
<?= $this->endSection() ?>