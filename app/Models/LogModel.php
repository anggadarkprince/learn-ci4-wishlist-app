<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use ReflectionException;

class LogModel extends BaseModel
{
    protected $table = 'logs';
    protected $returnType = 'object';

    protected $allowedFields = ['event_type', 'event_access', 'data', 'created_by', 'created_at'];

    /**
     * Basic filter data.
     *
     * @param array $filters
     * @return BaseBuilder
     */
    public function filter($filters = [])
    {
        return parent::filter($filters)
            ->select([
                'logs.*',
                'users.name AS creator_name'
            ])
            ->join('users', 'users.id = logs.created_by', 'left');
    }

    /**
     * Inserts data into the current table. If an object is provided,
     * it will attempt to convert it to an array.
     *
     * @param array|object $data
     * @param boolean      $returnID Whether insert ID should be returned or not.
     *
     * @return integer|string|boolean
     * @throws ReflectionException
     */
    public function insert($data = null, bool $returnID = true)
    {
        $userId = AuthModel::loginData('id');
        $log = $this->where('created_by', $userId)
            ->orderBy('id', 'desc')
            ->get()
            ->getRow();

        $createLog = false;
        if (!empty($log)) {
            $timeDiff = strtotime('now') - strtotime($log->created_at);
            if (strtolower($log->event_access) != strtolower($data['event_access']) || $timeDiff > 300) {
                $createLog = true;
            }
        } else {
            $createLog = true;
        }

        if ($createLog) {
            return parent::insert($data, $returnID);
        }
        return true;
    }
}
