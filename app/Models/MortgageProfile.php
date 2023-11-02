<?php

namespace App\Models;

use CodeIgniter\Model;

class MortgageProfile extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mortgage_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','user_id','home_buyer','family_income','credit_score',
                                 'heating_cost','monthly_installment','total_balance','qualification_rate','status','created_at','updated_at','deleted_at'];

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
    //Single Data Entry
    public function addRecord($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
    //Get Record of a User
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
     // Update Data
     public function updateRecord($id, $data)
     {
         return $this->update($id, $data);
     }
}
