<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h4 class="card-title mb-sm-0">Data Logs</h4>
            <div>
                <a href="#modal-filter" data-toggle="modal" class="btn btn-outline-primary px-2">
                    <i class="mdi mdi-filter-variant"></i>
                </a>
                <a href="<?= base_url(uri_string()) ?>?<?= $_SERVER['QUERY_STRING'] ?>&export=true" class="btn btn-outline-primary px-2">
                    <i class="mdi mdi-file-download-outline"></i>
                </a>
            </div>
        </div>
        <table class="table table-hover table-md mt-3 responsive">
            <thead>
                <tr>
                    <th class="text-md-center" style="width: 60px">No</th>
                    <th>Event Access</th>
                    <th>Event Type</th>
                    <th>Data</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th style="min-width: 120px" class="text-md-right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = isset($logs) ? ($pager->getDetails()['currentPage'] - 1) * $pager->getDetails()['perPage'] : 0 ?>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td class="text-md-center"><?= ++$no ?></td>
                        <td><?= if_empty($log->event_access, '-') ?></td>
                        <td><?= if_empty($log->event_type, '-') ?></td>
                        <td><?= if_empty($log->data_label, '-') ?></td>
                        <td><?= if_empty($log->creator_name, '-') ?></td>
                        <td><?= if_empty(format_date($log->created_at, 'd M Y H:i'), '-') ?></td>
                        <td class="text-md-right">
                            <a href="<?= site_url('logs/view/' . $log->id) ?>" class="btn btn-primary" type="button">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($logs)) : ?>
                    <tr>
                        <td colspan="7">No log data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center justify-content-sm-between mt-3">
            <small class="text-muted mb-2 mb-sm-0">Showing <?= count($logs) ?> of <?= $pager->getDetails()['total'] ?> entries</small>
            <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->include('logs/_modal_filter') ?>
<?= $this->endSection() ?>