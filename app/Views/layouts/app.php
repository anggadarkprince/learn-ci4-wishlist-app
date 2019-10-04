<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <title>Wishlist - <?= isset($title) ? $title : (new \ReflectionClass($this))->getShortName() ?></title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/layouts/icon.png') ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
    <link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
</head>
<body>
    <?= $this->include('layouts/partials/sidebar') ?>
    <div class="main-content">
        <?= $this->include('layouts/partials/header') ?>

        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-6">
            <?= $this->renderSection('content-header') ?>
        </div>
        <div class="container-fluid mt--7">
            <?= $this->include('layouts/partials/alert') ?>
            <?= $this->renderSection('content') ?>
            <?= $this->include('layouts/partials/footer') ?>
        </div>
    </div>

    <script src="<?= base_url(get_asset('runtime.js')) ?>"></script>
    <script src="<?= base_url(get_asset('vendors.js')) ?>"></script>
    <script src="<?= base_url(get_asset('app.js')) ?>"></script>
</body>