<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<form action="<?= site_url('wishlists') ?>" method="POST" id="form-user">
    <?= csrf_field() ?>
    <div class="card grid-margin">
        <div class="card-body">
            <h4 class="card-title">Create a Wish</h4>
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="wish">Wish Title</label>
                        <input type="text" class="form-control" id="wish" name="wish" required maxlength="50" value="<?= set_value('wish') ?>" placeholder="Wish sort story">
                        <?= service('validation')->showError('wish'); ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="text" class="form-control datepicker" id="target" name="target" required maxlength="20" value="<?= set_value('target') ?>" placeholder="Achieved at">
                        <?= service('validation')->showError('target'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Wish Description</label>
                <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Wishlist detail"><?= set_value('description') ?></textarea>
                <?= service('validation')->showError('description') ?>
            </div>
            <div class="form-group">
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id="is_private" type="checkbox" name="is_private" value="1" <?= set_checkbox('is_private', '1', true) ?>>
                    <label class="custom-control-label" for="is_private">
                        <span class="text-muted">Is private</span>
                    </label>
                </div>
                <?= service('validation')->showError('is_private') ?>
            </div>
            <div class="form-group">
                <div class="custom-control custom-control-alternative custom-checkbox">
                    <input class="custom-control-input" id="is_completed" type="checkbox" name="is_completed" value="1" <?= set_checkbox('is_completed', '1') ?>>
                    <label class="custom-control-label" for="is_completed">
                        <span class="text-muted">Is completed</span>
                    </label>
                </div>
                <?= service('validation')->showError('is_completed') ?>
            </div>
        </div>
    </div>

    <div class="card grid-margin">
        <div class="card-body d-flex justify-content-between">
            <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
            <button type="submit" class="btn btn-success" data-toggle="one-touch" data-touch-message="Saving...">
                Save Wishlist
            </button>
        </div>
    </div>
</form>
<?= $this->endSection() ?>