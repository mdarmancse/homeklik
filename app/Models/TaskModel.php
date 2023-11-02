<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['realtor_id','title','details','date','task_status','status','created_at','updated_at'];

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
     //Task Add Data 
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
   public function getVisitData($RealtorID)
   {
        $db  = \Config\Database::connect();
         $builder = $db->table('tours');
              $builder->select("tours.listing_id,users.id as customer_id,tours.id as tour_id,visit_status.slug,visit_status.name,addresses.listing_id,addresses.street_address,users.first_name,users.last_name,users.mobile")
              ->join('addresses', 'addresses.listing_id = tours.listing_id','left')
              ->join('users', 'users.id = tours.user_id','left')
              ->join('visit_status', 'visit_status.id = tours.visit_id','left')
              ->where('tours.realtor_id',$RealtorID);
               return $builder->get()->getResultArray();
   }
   public function getVisitDetails($TourID)
   {
        $db  = \Config\Database::connect();
         $builder = $db->table('tours');
              $builder->select("users.image,tours.listing_id,properties.price,properties.transaction_type,buildings.bedrooms_total,
              buildings.bathroom_total,properties.parking,addresses.street_address,properties.photo,properties.price,visit_status.slug,visit_status.name,
              properties.size_total,users.first_name,users.last_name,users.mobile,users.email,tour_schedule_map.date,tour_schedule_map.shift,")
              ->join('addresses', 'addresses.listing_id = tours.listing_id','left')
              ->join('properties', 'properties.listing_id = tours.listing_id','left')
              ->join('buildings', 'buildings.listing_id = tours.listing_id','left')
              ->join('users', 'users.id = tours.user_id','left')
              ->join('visit_status', 'visit_status.id = tours.visit_id','left')
              ->join('tour_schedule_map', 'tour_schedule_map.tour_id = tours.id','left')
              ->where('tours.id',$TourID);
               return $builder->get()->getResultArray();
   }
}
