<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="<?= site_url('/') ?>">
            <?= isset($title) ? $title : (new \ReflectionClass($this))->getShortName() ?>
        </a>
        <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text" aria-label="Search">
                </div>
            </div>
        </form>
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <?= $this->include('layouts/partials/account') ?>
        </ul>
    </div>
</nav>