<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form action="<?= site_url('master/roles') ?>" method="POST" id="form-role">
        <?= csrf_field() ?>
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Create New Role</h4>
                <div class="form-group">
                    <label for="role">Role Name</label>
                    <input type="text" class="form-control" id="role" name="role" maxlength="50" required value="<?= set_value('role') ?>" placeholder="Enter a role name">
                    <?= service('validation')->showError('role') ?>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" maxlength="500" placeholder="Enter role description"><?= set_value('description') ?></textarea>
                    <?= service('validation')->showError('description') ?>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Permissions</h4>
                <p class="text-muted mb-0">Role at least must has one permission</p>
                <?= service('validation')->showError('permissions'); ?>

                <div class="form-group">
                    <div class="row">
                        <?php $lastGroup = '' ?>
                        <?php $lastSubGroup = '' ?>
                        <?php foreach ($permissions as $permission) : ?>
                            <?php
                            $module = $permission->module;
                            $submodule = $permission->submodule;
                            ?>

                            <?php if ($lastGroup != $module) : ?>
                                <?php
                                $lastGroup = $module;
                                $lastGroupName = preg_replace('/ /', '_', $lastGroup);
                                ?>
                                <div class="col-12">
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check_all" id="check_all_<?= $lastGroupName ?>" value="<?= $lastGroupName ?>" <?= set_checkbox('check_all_' . $lastGroupName, $lastGroupName) ?>>
                                        <label class="custom-control-label" for="check_all_<?= $lastGroupName ?>">
                                            Module <?= ucwords($lastGroup) ?> (Check All)
                                        </label>
                                    </div>
                                    <hr class="mb-1">
                                </div>
                            <?php endif; ?>

                            <?php if ($lastSubGroup != $submodule) : ?>
                                <?php $lastSubGroup = $submodule; ?>
                                <div class="col-12">
                                    <div class="mb-2 mt-3">
                                        <h5>
                                            <?= ucwords(preg_replace('/\-/', ' ', $lastSubGroup)) ?>
                                        </h5>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-sm-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input <?= $lastGroupName ?>" id="permission_<?= $permission->id ?>" name="permissions[]" value="<?= $permission->id ?>" <?= set_checkbox('permissions', $permission->id) ?>>
                                    <label class="custom-control-label" for="permission_<?= $permission->id ?>">
                                        <?= ucwords(preg_replace('/(_|\-)/', ' ', $permission->permission)) ?>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
                <button type="submit" class="btn btn-success" data-toggle="one-touch" data-touch-message="Saving...">
                    Save Role
                </button>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>