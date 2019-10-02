<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="card grid-margin">
        <div class="card-body py-3">
            <div class="d-sm-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-0">Database</h3>
                    <p class="mb-sm-0 text-muted"><?= config( 'App')->appName ?>'s database file</p>
                </div>
                <a href="<?= site_url("backup/database") ?>" class="btn btn-danger">
                    Backup Now
                </a>
            </div>
        </div>
        <div class="card-footer small">
            <strong>Live on</strong>
            <?= config( 'Database')->default['hostname'] ?><?= empty(config( 'Database')->default['port']) ? '' : ':' . config( 'Database')->default['port'] ?>/<?= config( 'Database')->default['database'] ?>
        </div>
    </div>

    <div class="card grid-margin">
        <div class="card-body py-3">
            <div class="d-sm-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title mb-0">Upload</h3>
                    <p class="mb-sm-0 text-muted"><?= config( 'App')->appName ?>'s uploaded file</p>
                </div>
                <a href="<?= site_url("backup/upload") ?>" class="btn btn-info">
                    Backup Now
                </a>
            </div>
        </div>
        <div class="card-footer small">
            <strong>Live on</strong>
            app/uploads
        </div>
    </div>
<?= $this->endSection() ?>