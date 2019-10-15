<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title mb-sm-0">Data Wishlist</h4>
            <div>
                <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary px-2">
                    <i class="mdi mdi-filter-variant"></i>
                </a>
                <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary px-2">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
                <?php if(is_authorized(PERMISSION_WISHLIST_CREATE)): ?>
                    <a href="<?= site_url('wishlists/new') ?>" class="btn btn-success">
                        <i class="mdi mdi-plus-box-outline mr-1"></i>CREATE
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <table class="table table-hover table-md mt-3 responsive">
            <thead>
                <tr>
                    <th class="text-md-center" style="width: 60px">No</th>
                    <th>Wish</th>
                    <th>Target</th>
                    <th>Progress</th>
                    <th style="min-width: 120px" class="text-md-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = isset($wishlists) ? ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] : 0 ?>
                <?php foreach ($wishlists as $wishlist) : ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td><?= $wishlist->wish ?></td>
                        <td><?= $wishlist->target->format('d F Y') ?></td>
                        <td><?= $wishlist->progress ?></td>
                        <td class="text-md-right">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-action mr-0" type="button" data-toggle="dropdown">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if(is_authorized(PERMISSION_WISHLIST_VIEW)): ?>
                                        <a class="dropdown-item" href="<?= site_url('wishlists/' . $wishlist->id) ?>">
                                            <i class="mdi mdi-eye-outline mr-2"></i> View
                                        </a>
                                    <?php endif; ?>
                                    <?php if(is_authorized(PERMISSION_WISHLIST_EDIT)): ?>
                                        <a class="dropdown-item" href="<?= site_url('wishlists/' . $wishlist->id . '/edit') ?>">
                                            <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <?php if(is_authorized(PERMISSION_WISHLIST_DELETE)): ?>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal" data-id="<?= $wishlist->id ?>" data-label="<?= $wishlist->wish ?>" data-title="Wishlist" data-url="<?= site_url('wishlists/' . $wishlist->id) ?>">
                                            <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($wishlists)) : ?>
                    <tr>
                        <td colspan="5">No wishlists data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mt-3">
            <small class="text-muted mb-2 mb-sm-0">Showing <?= count($wishlists) ?> of <?= $pager->getDetails()['total'] ?> entries</small>
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->include('wishlists/_modal_filter') ?>
<?= $this->include('layouts/modals/delete') ?>
<?= $this->endSection() ?>