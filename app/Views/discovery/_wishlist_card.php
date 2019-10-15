<div class="card-columns">
    <?php foreach ($wishlists as $wishlist): ?>
        <div class="card wishlist-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title mb-2">
                        <a href="<?= site_url('wishlists/' . $wishlist->id) ?>"><?= $wishlist->wish ?></a>
                    </h3>
                    <?php if($wishlist->user_id == auth('id')): ?>
                        <div class="dropdown mt-1">
                            <button class="btn-ellipsis" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="action">
                                <a class="dropdown-item" href="<?= site_url('wishlists/' . $wishlist->id . '/edit') ?>">
                                    <i class="mdi mdi-square-edit-outline mr-2"></i> Edit
                                </a>
                                <a class="dropdown-item btn-delete" href="#modal-delete" data-toggle="modal" data-id="<?= $wishlist->id ?>" data-label="<?= $wishlist->wish ?>" data-title="Wishlist"  data-url="<?= site_url('wishlists/' . $wishlist->id) ?>">
                                    <i class="mdi mdi-trash-can-outline mr-2"></i> Delete
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <p class="card-text"><?= $wishlist->description ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <?php if($wishlist->is_completed): ?>
                            <span class="badge badge-pill badge-success">COMPLETED</span>
                        <?php else: ?>
                            <div class="d-inline-block" style="width: 100px">
                                <div class="progress mb-0">
                                    <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                         style="width: <?= $wishlist->is_completed ? '100' : ceil($wishlist->progress / 100 * 100) ?>%;"
                                         aria-valuenow="<?= $wishlist->is_completed ? '100' : ceil($wishlist->progress / 100 * 100) ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <small class="d-inline-block"><?= $wishlist->progress ?> / 100</small>
                        <?php endif; ?>
                    </div>
                    <small class="text-muted" title="Accomplished target">
                        <?= relative_time($wishlist->target) ?>
                    </small>
                </div>
            </div>
            <div class="card-footer py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= site_url('wishlists/support/' . $wishlist->id) ?>" class="btn-support-wishlist <?= $wishlist->is_supported ? 'state-supported' : '' ?> text-<?= $wishlist->is_supported ? 'success' : 'dark' ?>">
                        <?php if($wishlist->is_supported): ?>
                            <i class="mdi mdi-thumb-up mr-2"></i>
                            <small>
                                <span class="label-support-total"><?= numerical($wishlist->total_support) ?></span> Supports
                            </small>
                        <?php else: ?>
                            <i class="mdi mdi-thumb-up-outline mr-2"></i>
                            <small>
                                <span class="label-support-total"><?= numerical($wishlist->total_support) ?></span> Supports
                            </small>
                        <?php endif; ?>
                    </a>
                    <div>
                        <a href="<?= site_url($wishlist->username) ?>" title="Owner: <?= $wishlist->name ?>">
                            <img src="<?= base_url(if_empty($wishlist->avatar, 'assets/img/layouts/no-avatar.png', 'uploads/')) ?>"
                                 alt="avatar" class="img-fluid rounded-circle" style="width: 35px; height: 35px">
                        </a>
                        <?php foreach ($wishlist->participants as $participant): ?>
                            <a href="<?= site_url($participant->username) ?>" title="Participant: <?= $participant->name ?>">
                                <img src="<?= base_url(if_empty($participant->avatar, 'assets/img/layouts/no-avatar.png', 'uploads/')) ?>"
                                     alt="avatar" class="img-fluid rounded-circle" style="width: 35px; height: 35px">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php if (empty($wishlists)): ?>
    <p class="text-center text-light">No wishlist available</p>
<?php endif; ?>

<?= $this->include('layouts/modals/delete') ?>