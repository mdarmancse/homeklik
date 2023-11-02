<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleProperty extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'sale_properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id','user_id', 'property_type','unit', 
    'bedrooms','washrooms', 'parkings','size', 'street_address','city', 'province','postal_code', 
    'price','purchase_year', 'photo','status'];

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
     public function GetData($rowperpage, $start)
     {
          $db  = \Config\Database::connect();
           $builder = $db->table('sale_properties');
                $builder->select("sale_properties.*,users.first_name,users.last_name")
                ->join('users', 'users.id = sale_properties.user_id');
                $builder->limit($rowperpage,$start);
                 return $builder->get()->getResultArray();
     }
}
