<div class="card-columns">
    <?php foreach ($wishlists as $wishlist): ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-2">
                    <a href="<?= site_url('wishlists/' . $wishlist->id) ?>"><?= $wishlist->wish ?></a>
                </h3>
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
                    <a href="<?= site_url('wishlists/support/' . $wishlist->id) ?>">
                        <i class="mdi mdi-thumb-up-outline mr-2"></i>
                        <small><?= numerical($wishlist->total_support) ?> Supports</small>
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