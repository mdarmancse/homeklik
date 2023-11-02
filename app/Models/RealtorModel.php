<?php

namespace App\Models;

use CodeIgniter\Model;

class RealtorModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'realtors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','street_number','street_address2','username','brokerage_id','rico','username','password','registration_date',
    'board_name','street_address1','unit','device_id','otp','city','province','postal_code',
   'email','mobile','status'];

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
    //Get Record of a Realtor
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
    // Get Table Data
    public function getRecord($conditions,$rowperpage,$start)
    {
       return $this->where($conditions)->orderBy('id', 'ASC')->limit($rowperpage,$start)->get()->getResultArray();
    }
    // Update Data
    public function updateRecord($id, $data)
   {
       return $this->update($id, $data);
   }
   //User Add Data 
   public function addRecord($data)
   {
       $this->insert($data);
       return $this->insertID();
   }
    // Delete Row
    public function deleteRow($id)
    {
        return $this->where('id', $id)->delete();
    }
    public function getRealtorData($realtor_info)
    {
        $db  = \Config\Database::connect();
        $builder = $db->table('realtors');
        if($realtor_info)
        {
            $builder->like('name', $realtor_info, 'both');
            $builder->like('mobile', $realtor_info, 'both');
        }
        $builder->limit(15);
        $realtors =  $builder->get()->getResultArray();
        return $realtors;
    }
}
