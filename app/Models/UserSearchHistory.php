<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSearchHistory extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user_search_histories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','user_id','type','price_from','price_to','construction_style','city','province','latitude','longitude','created_at'];

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
    // Update Data
        public function updateRecord($id, $data)
    {
        return $this->update($id, $data);
    }
}
