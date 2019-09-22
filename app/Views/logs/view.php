<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<form class="form-plaintext">
    <div class="card grid-margin">
        <div class="card-body">
            <h4 class="card-title">View Log</h4>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="event_access">Event Access</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext" id="event_access">
                        <?= $log->event_access ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="event_type">Event Type</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext" id="event_type">
                        <?= $log->event_type ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="created_at">Created By</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext" id="created_at">
                        <?= $log->creator_name ?>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="created_at">Created At</label>
                <div class="col-sm-9">
                    <p class="form-control-plaintext" id="created_at">
                        <?= format_date($log->created_at, 'd F Y H:i') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card grid-margin">
        <div class="card-body">
            <h4 class="card-title">
                Log Detail
            </h4>
            <?php foreach ($log->data as $key => $value) : ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">
                        <?= str_replace('Id', 'ID', ucwords(str_replace(['-', '_'], ' ', $key))) ?>
                    </label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext">
                            <?php if (is_array($value)) : ?>
                                <?= json_encode($value) ?>
                            <?php else : ?>
                                <?= if_empty(is_numeric($value) ? numerical($value) : $value, '-') ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card grid-margin">
        <div class="card-body">
            <button onclick="history.back()" type="button" class="btn btn-light">Back</button>
        </div>
    </div>
</form>
<?= $this->endSection() ?>