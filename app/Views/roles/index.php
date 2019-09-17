<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="card-title mb-sm-0">Data Roles</h4>
                <div>
                    <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary px-2">
                        <i class="mdi mdi-filter-variant"></i>
                    </a>
                    <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary px-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                    <a href="<?= site_url('master/roles/new') ?>" class="btn btn-success">
                        <i class="mdi mdi-plus-box-outline mr-1"></i>CREATE
                    </a>
                </div>
            </div>
            <table class="table table-hover table-md mt-3 responsive">
                <thead>
                <tr>
                    <th class="text-md-center" style="width: 60px">No</th>
                    <th>Role</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th style="min-width: 120px" class="text-md-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = isset($roles) ? ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] : 0 ?>
                <?php foreach ($roles as $role) : ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td><?= $role->role ?></td>
                        <td><?= $role->description ?></td>
                        <td><?= $role->created_at->format('d F Y H:i') ?></td>
                        <td class="text-md-right">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-action mr-0" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?= site_url('master/roles/' . $role->id) ?>">
                                        <i class="mdi mdi-eye-outline mr-2"></i> View
                                    </a>
                                    <a class="dropdown-item" href="<?= site_url('master/roles/' . $role->id . '/edit') ?>">
                                        <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal" data-id="<?= $role->id ?>" data-label="<?= $role->role ?>" data-title="Role" data-url="<?= site_url('master/roles/' . $role->id) ?>">
                                        <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($roles)) : ?>
                    <tr>
                        <td colspan="5">No roles data available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mt-3">
                <small class="text-muted mb-2 mb-sm-0">Showing <?= count($roles) ?> of <?= $pager->getDetails()['total'] ?> entries</small>
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
    <?= $this->include('layouts/modals/delete') ?>
<?= $this->endSection() ?>