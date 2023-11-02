<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskStatusModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'task_status';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["name","slug","status"];

    // Dates
    protected $useTimestamps = true;
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
        //echo "<pre>";print_r( $this->insertID());exit();

        return $this->insertID();
    }
    //Get Record of a City
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
    // Get Table Data
    public function getRecord($conditions)
    {
        return $this->where($conditions)->orderBy('id', 'ASC')->get()->getResultArray();
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
    public function getRecordBySelect()
    {
        return $this->select('id,name,slug',)->orderBy('id', 'ASC')->get()->getResultArray();
    }
}
