<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['first_name', 'last_name', 'mobile','email',
     'password', 'gender', 'dob', 'street_address','unit',
     'postal_code', 'city', 'province','image','user_type', 'language_slug','device_id',
     'sms_otp', 'active','status','created_at', 'updated_at','deleted_at'];

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
    
    //Get Record of a User
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
   //User Add Data 
   public function addRecord($data)
   {
       $this->insert($data);
       return $this->insertID();
   }
   public function getUserData($user_info)
    {
        $db  = \Config\Database::connect();
        $builder = $db->table('users');
        if($user_info)
        {
            $builder->like('first_name', $user_info, 'both');
            $builder->like('last_name', $user_info, 'both');
            $builder->like('mobile', $user_info, 'both');
        }
        $builder->limit(15);
        $users =  $builder->get()->getResultArray();
        return $users;
    }
    // Get Specific Column Data Based on Conditions
    public function getCondition_Column_Data($columns,$conditions)
    {
        return $this->where($conditions)->select($columns)->findAll();
    }
}
