<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'brands';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','name','url','logo','status'];

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

    //City Add Data 
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
}
