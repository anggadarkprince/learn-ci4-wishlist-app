<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <form action="<?= site_url('setting') ?>" method="post" id="form-account">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Notification</h4>
                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_NOTIFICATION_NEWS_UPDATE ?>" type="checkbox" name="<?= SETTING_NOTIFICATION_NEWS_UPDATE ?>" value="1"
                            <?= set_checkbox(SETTING_NOTIFICATION_NEWS_UPDATE, '1', $settings->{SETTING_NOTIFICATION_NEWS_UPDATE}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_NOTIFICATION_NEWS_UPDATE ?>">
                            <span class="text-muted"><?= $settings->{SETTING_NOTIFICATION_NEWS_UPDATE}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_NOTIFICATION_NEWS_UPDATE) ?>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_NOTIFICATION_LOGIN_DEVICE ?>" type="checkbox" name="<?= SETTING_NOTIFICATION_LOGIN_DEVICE ?>" value="1"
                            <?= set_checkbox(SETTING_NOTIFICATION_LOGIN_DEVICE, '1', $settings->{SETTING_NOTIFICATION_LOGIN_DEVICE}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_NOTIFICATION_LOGIN_DEVICE ?>">
                            <span class="text-muted"><?= $settings->{SETTING_NOTIFICATION_LOGIN_DEVICE}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_NOTIFICATION_LOGIN_DEVICE) ?>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_NOTIFICATION_WISHLIST_PROGRESS ?>" type="checkbox" name="<?= SETTING_NOTIFICATION_WISHLIST_PROGRESS ?>" value="1"
                            <?= set_checkbox(SETTING_NOTIFICATION_WISHLIST_PROGRESS, '1', $settings->{SETTING_NOTIFICATION_WISHLIST_PROGRESS}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_NOTIFICATION_WISHLIST_PROGRESS ?>">
                            <span class="text-muted"><?= $settings->{SETTING_NOTIFICATION_WISHLIST_PROGRESS}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_NOTIFICATION_WISHLIST_PROGRESS) ?>
                </div>

                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_NOTIFICATION_PARTICIPANT_WISHLIST ?>" type="checkbox" name="<?= SETTING_NOTIFICATION_PARTICIPANT_WISHLIST ?>" value="1"
                            <?= set_checkbox(SETTING_NOTIFICATION_PARTICIPANT_WISHLIST, '1', $settings->{SETTING_NOTIFICATION_PARTICIPANT_WISHLIST}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_NOTIFICATION_PARTICIPANT_WISHLIST ?>">
                            <span class="text-muted"><?= $settings->{SETTING_NOTIFICATION_PARTICIPANT_WISHLIST}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_NOTIFICATION_PARTICIPANT_WISHLIST) ?>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body">
                <h4 class="card-title">Privacy</h4>
                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_PRIVACY_ALLOW_DISCOVERY ?>" type="checkbox" name="<?= SETTING_PRIVACY_ALLOW_DISCOVERY ?>" value="1"
                            <?= set_checkbox(SETTING_PRIVACY_ALLOW_DISCOVERY, '1', $settings->{SETTING_PRIVACY_ALLOW_DISCOVERY}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_PRIVACY_ALLOW_DISCOVERY ?>">
                            <span class="text-muted"><?= $settings->{SETTING_PRIVACY_ALLOW_DISCOVERY}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_NOTIFICATION_NEWS_UPDATE) ?>
                </div>
                <div class="form-group mb-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" id="<?= SETTING_PRIVACY_AUTO_PARTICIPANT ?>" type="checkbox" name="<?= SETTING_PRIVACY_AUTO_PARTICIPANT ?>" value="1"
                            <?= set_checkbox(SETTING_PRIVACY_AUTO_PARTICIPANT, '1', $settings->{SETTING_PRIVACY_AUTO_PARTICIPANT}->value == 1) ?>>
                        <label class="custom-control-label" for="<?= SETTING_PRIVACY_AUTO_PARTICIPANT ?>">
                            <span class="text-muted"><?= $settings->{SETTING_PRIVACY_AUTO_PARTICIPANT}->description ?></span>
                        </label>
                    </div>
                    <?= service('validation')->showError(SETTING_PRIVACY_AUTO_PARTICIPANT) ?>
                </div>
            </div>
        </div>
        <div class="card grid-margin">
            <div class="card-body d-flex justify-content-between">
                <button type="button" onclick="history.back()" class="btn btn-light">Back</button>
                <button type="submit" class="btn btn-primary" data-toggle="one-touch" data-touch-message="Updating...">Update Setting</button>
            </div>
        </div>
    </form>
<?= $this->endSection() ?>