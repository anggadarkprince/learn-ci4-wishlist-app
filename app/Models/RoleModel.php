<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';

    protected $returnType = 'App\Entities\Role';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['role', 'description'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'role' => 'required|max_length[50]',
        'description' => 'max_length[500]',
    ];

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
                $this->orLike($field->name, trim($filters['search']));
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
            $this->orderBy($this->table . '.' . $this->primaryKey, 'desc');
        }

        return $this;
    }
}
