<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<form action="<?= site_url('wishlists') ?>" method="POST" id="form-wishlist">
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
        <div class="card-body">
            <h4 class="card-title">Wishlist Details</h4>
            <?= service('validation')->showError('details[]') ?>

            <table class="table table-md mt-3" id="table-wishlist-detail">
                <thead>
                <tr>
                    <th style="width: 70px">No</th>
                    <th>Wish Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $details = old('details', [], false); ?>
                <?php foreach ($details as $index => $detail): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td class="label-detail"><?= $detail['detail'] ?></td>
                        <td class="text-right">
                            <input type="hidden" name="details[<?= $index ?>][detail]" id="detail" value="<?= get_if_exist($detail, 'detail') ?>">
                            <input type="hidden" name="details[<?= $index ?>][completed_at]" id="completed_at" value="<?= get_if_exist($detail, 'completed_at') ?>">
                            <input type="hidden" name="details[<?= $index ?>][completed_by]" id="completed_by" value="<?= get_if_exist($detail, 'completed_by') ?>">
                            <button class="btn btn-outline-danger btn-delete" type="button">
                                <i class="mdi mdi-trash-can-outline mr-0"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($details)): ?>
                    <tr class="row-placeholder">
                        <td colspan="3">No sub wish available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <div class="form-group text-left mb-2">
                <textarea class="form-control" id="input-wishlist-detail" rows="2"
                          aria-label="input-task-detail" placeholder="Input sub wish and click add item"></textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted mr-3 text-left">Add sub task (optional) and press ADD ITEM</small>
                <button class="btn btn-primary" id="btn-add-wishlist" type="button">ADD ITEM</button>
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