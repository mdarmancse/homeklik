<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerClassificationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_classifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','name','default_status_id','default_number','status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function addRecord($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
    //Get Record of a City
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
    // Get Table Data
    public function getRecord()
    {
        return $this->db->table('customer_classifications a')
            ->select('a.*,v.name as visit_status ')
            ->join('visit_status v', 'a.default_status_id = v.id', 'left')
            ->orderBy('id', 'ASC')->get()->getResultArray();
    }
    // Update Data
    public function updateRecord($id, $data)
    {
        return $this->update($id, $data);
    }
    // Delete Row
    public function deleteRow($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function getRealtorCustomerClass($realtor_id)
    {
        $query = $this->db->table('customer_classifications b')
            ->select('b.id, b.default_status_id, b.default_number, b.name, v.name AS visit_status, v.id AS visit_status_id, COALESCE(a.number, 0) AS number')
            ->join('customer_classification_map a', 'a.classification_id = b.id AND a.realtor_id = ' . $realtor_id, 'left')
            ->join('visit_status v', 'a.visit_status_id = v.id', 'left');

        $result = $query->get()->getResult('array');

        // Process the data to adjust the values
        foreach ($result as &$row) {
            if ($row['visit_status'] === null) {
                $row['visit_status'] = $row['default_status_id'] == 1 ? 'Visited' : 'Not Visited';
            }
            if ($row['visit_status_id'] === null) {
                $row['visit_status_id'] = $row['default_status_id'];
            }
            if ($row['number'] === '0') {
                $row['number'] = $row['default_number'];
            }
            unset($row['default_status_id'], $row['default_number']);
        }

        return $result;
    }
}
