<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="base-url" content="<?= site_url() ?>">
    <meta name="user-id" content="<?= auth('id') ?>">
    <title>Wishlist - <?= isset($title) ? $title : (new \ReflectionClass($this))->getShortName() ?></title>

    <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/layouts/icon.png') ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(get_asset('vendors.css')) ?>">
    <link rel="stylesheet" href="<?= base_url(get_asset('app.css')) ?>">
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
</head>
<body class="bg-default">
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-horizontal navbar-expand-md navbar-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= site_url('/') ?>">
                    <img src="<?= base_url('assets/img/layouts/icon.png') ?>" alt="logo" style="max-width: 50px; -webkit-filter: brightness(0) invert(1)" class="d-inline-block mr-2">
                    <h1 class="d-inline-block mb-0 text-white font-weight-300 text-lowercase">Wishlist</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    <!-- Collapse header -->
                    <div class="navbar-collapse-header d-md-none">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="<?= site_url('/') ?>">
                                    Wishlist
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <form action="<?= site_url('discovery') ?>" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                </div>
                                <input class="form-control" name="q" value="<?= get_url_param('q') ?>" placeholder="Search" type="text" aria-label="Search">
                            </div>
                        </div>
                    </form>
                    <!-- Navbar items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link nav-link-icon" href="<?= site_url('discovery') ?>">
                                <i class="mdi mdi-globe-model"></i>
                                <span class="nav-link-inner--text">Discovery</span>
                            </a>
                        </li>
                        <?php if(auth('id')): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="<?= site_url('wishlists') ?>">
                                    <i class="mdi mdi-gift-outline"></i>
                                    <span class="nav-link-inner--text">My Wishlist</span>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="<?= site_url('register') ?>">
                                    <i class="mdi mdi-account-plus-outline"></i>
                                    <span class="nav-link-inner--text">Register</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="<?= site_url('login') ?>">
                                    <i class="mdi mdi-login-variant"></i>
                                    <span class="nav-link-inner--text">Login</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page content -->
        <div class="container pt-3 pb-5">
            <?= $this->include('layouts/partials/alert') ?>
            <?= $this->renderSection('content') ?>
        </div>

        <!-- Footer -->
        <footer class="py-5">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="copyright text-center text-xl-left text-muted">
                            &copy; <?= date('Y') ?>
                            <a href="<?= site_url('/') ?>" class="font-weight-bold ml-1" target="_blank">
                                Wishlist.app
                            </a> all rights reserved.
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            <li class="nav-item">
                                <a href="http://angga-ari.com" class="nav-link">Angga Ari</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('about') ?>" class="nav-link">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url('help') ?>" class="nav-link">Help</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="<?= base_url(get_asset('runtime.js')) ?>"></script>
    <script src="<?= base_url(get_asset('vendors.js')) ?>"></script>
    <script src="<?= base_url(get_asset('app.js')) ?>"></script>
</body>