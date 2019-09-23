<?= $this->extend('layouts/static') ?>

<?= $this->section('content') ?>
    <div class="card grid-margin">
        <div class="card-body">
            <h2 class="card-title">Help and FAQ</h2>
            <h3>I have problem with authentication</h3>
            <p>
                If you just register to our app then make your that you already activate the account through link
                that sent to your email. Valid email is required to activate your account, if you forgot your password
                then do reset, again it needs valid registered email address.
            </p>
            <h3>I forgot my credential?</h3>
            <p>
                Use forgot password feature, you must able to log in to your email to access reset link. Consider to
                bind your social authentication so you can logged in to your account with many ways.
            </p>
            <h3>How many wishlist I can make?</h3>
            <p>
                We don't limit your wishlist, you can making wishlist as much as possible, but we limiting you access
                rate to keep our server stable. Throttling large amount request to our server will make your account be
                suspended and your IP will be blacklisted.
            </p>
            <h3>My mailbox bunch of notification email from <?= config( 'App')->appName ?>?</h3>
            <p>
                You can setting your notification configuration in your account - setting, check or uncheck your desire
                preferences that suit to your need. You always come back and activate all notification that you disable
                before.
            </p>
            <h3>How to deactivate my account?</h3>
            <p>
                Send us email (<?= config( 'App')->appEmail ?>) and give the reason you deactivate your account.
                We will proceed you request a few days.
            </p>
        </div>
    </div>
<?= $this->endSection() ?>