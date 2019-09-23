<?= $this->extend('layouts/static') ?>

<?= $this->section('content') ?>
    <div class="card grid-margin">
        <div class="card-body">
            <h2 class="card-title">About <?= config( 'App')->appName ?></h2>
            <h3>Hi, wishliscious...</h3>
            <p>
                Wishlist app will make you to easily create a wishlist for your requirements and send notification to
                all your relatives. One of the best part of wish list apps is to remove to chance of re gift so that you
                can easily filter the gifts which you already have. <?= config( 'App')->appName ?> let you to easily create a list
                of your favorite item which you don’t have or you need and send it to your friends to gift it. It is not
                so easy to know about a wishes of your friends and family so that these apps helps you to know it
                easily.
            </p>
            <p>
                One of the best and free wishlist app for android and iOS users which helps you to easily create your
                wishlist. It allows you to easily share your wishes with your friends and family and shows what you
                really like and also help them to find best present and gift.
            </p>
        </div>
    </div>
<?= $this->endSection() ?>