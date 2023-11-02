<?php

namespace App\Models;

use CodeIgniter\Model;

class TourModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tours';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','listing_id','brokerage_id','visit_id','date','shift','realtor_id','accept','bid_price','bid_closing_date','status','created_at'];

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
     //Tour Add Data 
     public function addRecord($data)
     {
         $this->insert($data);
         return $this->insertID();
     }
      //Get Single Data
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
     //Batch Data Entry
     public function addBatchRecord($data,$table)
     {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        return $builder->insertBatch($data);
     }
     // Get Table Data
    public function getRecord()
    {
     $query = $this->db->table('tours t')
    ->select('t.id,realtors.name as realtor_name,users.first_name,users.last_name,t.id AS tour_id, t.user_id, t.listing_id, t.realtor_id, t.accept, t.status, t.created_at, t.updated_at, t.deleted_at')
    ->select("GROUP_CONCAT(CONCAT(ts.date, ' - ', ts.shift) SEPARATOR '<br>') AS schedule")
    ->join('tour_schedule_map ts', 't.id = ts.tour_id', 'left')
    ->join('users', 't.user_id = users.id', 'left')
    ->join('realtors', 't.realtor_id = realtors.id', 'left')
    ->groupBy('t.id, t.user_id, t.listing_id, t.realtor_id, t.accept, t.status, t.created_at, t.updated_at, t.deleted_at');
     return $query->get()->getResult('array');
    }
    // Update Data
    public function updateRecord($id, $data)
   {
       return $this->update($id, $data);
   }
   public function getProfileActiveCustomer($realtor_id){
       $query = $this->db->table('tours t');
       return $query->get()->getResult('array');
   }
}
