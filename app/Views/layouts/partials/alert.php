<?php if (service('session')->getFlashdata('status') != NULL): ?>
    <div class="alert alert-<?= service('session')->getFlashdata('status') ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?= service('session')->getFlashdata('message') ?>
    </div>
<?php endif; ?>