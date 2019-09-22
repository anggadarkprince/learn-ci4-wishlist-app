<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="card-title mb-sm-0">System Logs</h4>
                <div>
                    <a href="<?= base_url(uri_string()) ?>?export=true" class="btn btn-outline-primary px-2">
                        <i class="mdi mdi-file-download-outline"></i>
                    </a>
                </div>
            </div>
            <table class="table table-hover table-md mt-3 responsive">
                <thead>
                <tr>
                    <th class="text-md-center" style="width: 60px">No</th>
                    <th>Log File</th>
                    <th>File Size</th>
                    <th>Last Modified</th>
                    <th style="min-width: 120px" class="text-md-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1 ?>
                <?php foreach ($logs as $log) : ?>
                    <tr>
                        <td class="text-md-center"><?= $no++ ?></td>
                        <td><?= $log['log_file'] ?></td>
                        <td><?= numerical($log['file_size']) ?> KB</td>
                        <td><?= format_date($log['last_modified'], 'd F Y H:i:s') ?></td>
                        <td class="text-md-right">
                            <a href="<?= site_url('logs/system?download=' . $log['log_file']) ?>">
                                Download
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($logs)) : ?>
                    <tr>
                        <td colspan="5">No logs data available</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>