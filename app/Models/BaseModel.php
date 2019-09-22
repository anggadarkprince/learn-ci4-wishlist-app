<?php


namespace App\Models;


use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $beforeInsert = ['insertLog'];
    protected $beforeUpdate = ['updateLog'];
    protected $beforeDelete = ['deleteLog'];

    protected function insertLog(array $data)
    {
        $this->callbackDML('insert', $data['data']);
        return $data;
    }

    protected function updateLog(array $data)
    {
        $this->callbackDML('update', $data['data']);
        return $data;
    }

    protected function deleteLog(array $data)
    {
        $this->callbackDML('delete', $data);
        return $data;
    }

    protected function callbackDML(string $action, array $data)
    {
        if ($this->table != 'logs') {
            $log = new LogModel();
            $log->insert([
                'event_type' => 'query-' . $action,
                'event_access' => get_class($this),
                'data' => json_encode([
                    'path' => current_url(),
                    'data' => $data,
                    'query' => $this->showLastQuery(),
                    'table' => $this->table
                ]),
                'created_by' => AuthModel::loginData('id', 0),
            ]);
        }
    }

    /**
     * Get all data with filters.
     *
     * @param array $filters
     * @return $this
     */
    public function filter($filters = [])
    {
        if (key_exists('search', $filters) && !empty($filters['search'])) {
            $fields = $this->db->getFieldData($this->table);
            foreach ($fields as $field) {
                if ($field->name != 'id' && !preg_match('/_id/', $field->name)) {
                    $this->orLike($this->table . '.' . $field->name, trim($filters['search']));
                }
            }
        }

        if (key_exists('date_from', $filters) && !empty($filters['date_from'])) {
            if ($this->db->fieldExists('created_at', $this->table)) {
                $this->where('DATE(' . $this->table . '.created_at)>=', format_date($filters['date_from']));
            }
        }

        if (key_exists('date_to', $filters) && !empty($filters['date_to'])) {
            if ($this->db->fieldExists('created_at', $this->table)) {
                $this->where('DATE(' . $this->table . '.created_at)<=', format_date($filters['date_to']));
            }
        }

        if (key_exists('sort_by', $filters) && !empty($filters['sort_by'])) {
            if (key_exists('order_method', $filters) && !empty($filters['order_method'])) {
                $this->orderBy($filters['sort_by'], $filters['order_method']);
            } else {
                $this->orderBy($filters['sort_by'], 'asc');
            }
        } else {
            if ($this->db->fieldExists($this->primaryKey, $this->table)) {
                $this->orderBy($this->table . '.' . $this->primaryKey, 'desc');
            }
        }

        return $this;
    }
}
