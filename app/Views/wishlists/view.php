<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form class="form-plaintext">
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">View Wishlist</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="wish">Wish</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="wish">
                                    <?= if_empty($wishlist->wish, 'No name') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="description">Description</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="description">
                                    <?= if_empty($wishlist->description, 'No description') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="target">Target</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="target">
                                    <?= $wishlist->target->format('d F Y') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="progress">Progress</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="progress">
                                    <?= if_empty($wishlist->progress, 'No progress') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="is_private">Is Private</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="is_private">
                                    <?= $wishlist->is_private ? 'YES' : 'NO' ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="is_completed">Is Completed</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="is_completed">
                                    <?= $wishlist->is_completed ? 'YES' : 'NO' ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="created_at">Created At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="created_at">
                                    <?= $wishlist->created_at->format('d F Y H:i') ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="updated_at">Updated At</label>
                            <div class="col-sm-8">
                                <p class="form-control-plaintext" id="updated_at">
                                    <?= $wishlist->updated_at ? $wishlist->updated_at->format('d F Y H:i') : '' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Wishlist Detail</h4>
                <ul class="timeline pl-0">
                    <?php foreach ($wishlistDetails as $wishlistDetail): ?>
                        <li class="d-sm-flex justify-content-between">
                            <p>
                                <?= nl2br(if_empty($wishlistDetail->detail, '-')) ?>
                            </p>
                            <small><?= relative_time($wishlistDetail->created_at)?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php if(empty($wishlistDetails)): ?>
                    <p class="text-muted mt-3">No detail activity available</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
                <?php if(is_authorized(PERMISSION_WISHLIST_VIEW)): ?>
                    <a href="<?= site_url('wishlists/' . $wishlist->id . '/edit') ?>" class="btn btn-primary">
                        Edit Wishlist
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>