<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="">
    <title>Wishlist</title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/layouts/icon.png') ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
    <link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
</head>
<body>
    <?= $this->include('layouts/partials/sidebar') ?>
    <div class="main-content">
        <?= $this->include('layouts/partials/header') ?>
        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url(get_asset('runtime.js')) ?>"></script>
    <script src="<?= base_url(get_asset('vendors.js')) ?>"></script>
    <script src="<?= base_url(get_asset('app.js')) ?>"></script>
</body>