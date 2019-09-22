<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="card grid-margin">
    <div class="card-body py-3">
        <div class="d-sm-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title mb-0">System Log</h4>
                    <p class="mb-sm-0 text-muted">
                        Generated log that colleccting errors
                    </p>
            </div>
            <a href="<?= site_url("logs/system") ?>" class="btn btn-danger">
                Show Logs
            </a>
        </div>
        <hr>
        <div class="d-sm-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title mb-0">Access Log</h4>
                    <p class="mb-sm-0 text-muted">
                        Access menu and database changes logs
                    </p>
            </div>
            <a href="<?= site_url("logs/access") ?>" class="btn btn-success">
                Show Logs
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>