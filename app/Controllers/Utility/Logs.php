<?php

namespace App\Controllers\Utility;

use App\Controllers\BaseController;
use App\Libraries\Exporter;
use App\Models\LogModel;

class Logs extends BaseController
{
    /**
     * Show log index page.
     */
    public function index()
    {
        return view('logs/index', ['title' => 'Logs']);
    }

    /**
     * Show system log files.
     */
    public function system()
    {
        helper('filesystem');

        $logPath = WRITEPATH . 'logs/';

        $download = $this->request->getGet('download');
        if (!empty($download)) {
            return $this->response->download($logPath . $download, null, true);
        }

        $logs = directory_map($logPath, 1);

        foreach ($logs as $index => &$file) {
            if ($file == 'index.html') {
                unset($logs[$index]);
            }
            $file = [
                'log_file' => $file,
                'file_size' => round(filesize($logPath . $file) / 1000, 1),
                'last_modified' => date("Y-m-d H:i:s", filemtime($logPath . $file)),
            ];
        }
        rsort($logs);

        if ($this->request->getGet('export')) {
            $exporter = new Exporter();
            $filePath = $exporter->exportFromArray('System Logs', $logs);
            return $this->response->download($filePath, null, true);
        }

        return view('logs/system', ['title' => 'System Logs', 'logs' => $logs]);
    }

    /**
     * Show access log data
     */
    public function access()
    {
        $title = 'Access Logs';
        $log = new LogModel();
        $data = $log->filter($_GET);

        if ($this->request->getGet('export')) {
            $exporter = new Exporter();
            $filePath = $exporter->exportFromArray($title, $data->asArray()->findAll());
            return $this->response->download($filePath, null, true);
        }

        $logs = $data->paginate();
        $pager = $log->pager;

        foreach ($logs as &$log) {
            $data = json_decode($log->data, true);
            $log->data_label = '-';
            if ($log->event_type == 'access') {
                $log->data_label = get_if_exist($data, 'ip', '-');
            }
            if (strpos($log->event_type, "query-") !== FALSE) {
                $log->data_label = get_if_exist($data, 'table', '-');
            }
        }

        return view('logs/access', compact('title', 'logs', 'pager'));
    }

    /**
     * View log access detail
     */
    public function view($id)
    {
        $title = 'View Log Detail';

        $logModel = new LogModel();
        $log = $logModel->filter()->find($id);
        $data = json_decode($log->data, true);
        if (is_array($data)) {
            $log->data = $data;
        }
        return view('logs/view', compact('title', 'log'));
    }
}
