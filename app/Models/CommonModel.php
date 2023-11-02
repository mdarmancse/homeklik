<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'commons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    // Add Data 
    public function addRecord($table,$data)
    {
        $db  = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->insert($data);
        return $this->insertID();
    }
     // Add Data 
     public function updateRecord($table,$data,$where)
     {
         $db  = \Config\Database::connect();
         $builder = $db->table($table);
         $builder->update($data, $where);
     }
    public function GetData($table)
    {
            $db  = \Config\Database::connect();
            $builder = $db->table($table);
            $builder->select($table.'.*');
            return $builder->get()->getResultArray();
    }
    public function BatchUpdate($systemOptionData, $table)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($table);
        return $builder->upsertBatch($systemOptionData);
    }
    //Get Record of a User
    public function getRecord($table,$column, $param)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->where($column, $param);
        return $builder->get()->getFirstRow();
    }
    public function getRecordArray($table,$array)
    {   
        $db      = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->where($array);
        return $builder->get()->getFirstRow('array');
    }
    public function getFavourites($user_id)
    {
            $db = \Config\Database::connect();
            $builder = $db->table('favourites');
             $builder->select("favourites.listing_id,favourites.react,properties.entity_id,properties.listing_id,buildings.bedrooms_total,
            buildings.bathroom_total,properties.parking,addresses.street_address,properties.photo,properties.price,
            properties.size_total,properties.size_total_text,properties.transaction_type as status,properties.status as isative")
            ->join('properties', 'properties.listing_id = favourites.listing_id', 'left')
            ->join('buildings', 'buildings.listing_id = properties.listing_id', 'left')
                     ->join('addresses', 'addresses.listing_id = properties.listing_id', 'left');
            $builder->where('favourites.user_id', $user_id);
            $builder->where('favourites.react', 1);
            $builder->distinct();
             return $builder->get()->getResultArray();
    }


}
