<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['realtor_id','title','details','date','status','created_at','updated_at'];

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
     //Note Add Data 
   public function addRecord($data)
   {
       $this->insert($data);
       return $this->insertID();
   }
   // Get Specific Column Data Based on Conditions
   public function getRecord($columns,$conditions)
   {
       return $this->where($conditions)->select($columns)->findAll();
   }
   // Update Data
   public function updateRecord($id, $data)
   {
       return $this->update($id, $data);
   }
   // Delete Row
   public function deleteRecord($id)
   {
       return $this->where('id', $id)->delete();
   }
}
