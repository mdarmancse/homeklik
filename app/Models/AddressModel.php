<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'addresses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['attribute_id','listing_id', 'street_address','address_line', 'street_number','street_name',
     'street_suffix','street_direction_suffix', 'city','province','neighbourhood', 'postal_code','unit_number','country',
      'community_name','sub_division'];


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

     //Batch Data Entry
     public function addBatchRecord($data)
     {
         $this->insertBatch($data);
     }
}
