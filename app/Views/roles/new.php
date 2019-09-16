<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-6"></div>
    <div class="container-fluid mt--7">
        <?= $this->include('layouts/partials/alert') ?>

    </div>
<?= $this->endSection() ?>