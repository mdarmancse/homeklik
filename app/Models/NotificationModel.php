<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    =['id','notification_title','notification_description','image','selection_type','status'];

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

    public function addRecord($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
    // Get Table Data
    public function getRecord()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('notifications');
        $builder->select("*");
        return $builder->get()->getResultArray();  
    }
     //Batch Data Entry
     public function addBatchRecord($data,$table)
     {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->insertBatch($data);
     }
     // Get single Row
     public function getSingleRow($conditions)
     {
         return $this->where($conditions)->get()->getFirstRow('array');
     }
     // Get Notification User Map
     public function getNotificationUserMap($notification_id)
        {
            $db = \Config\Database::connect();
            $builder = $db->table('notification_user_map');
            return $builder->select('notification_user_map.user_id, users.first_name, users.last_name')
            ->join('users', 'users.id = notification_user_map.user_id', 'left')
            ->where('notification_user_map.notification_id', $notification_id)
            ->get()->getResultArray();                      
        }
        // Get Notification Realtor Map
     public function getNotificationRealtorMap($notification_id)
     {
        $db = \Config\Database::connect();
            $builder = $db->table('notification_realtor_map');
            return $builder->select('notification_realtor_map.realtor_id, realtors.name')
            ->join('realtors', 'realtors.id = notification_realtor_map.realtor_id', 'left')
            ->where('notification_realtor_map.notification_id', $notification_id)
            ->get()->getResultArray();              
     }
     // Delete Row
        public function deleteRow($id)
        {
            return $this->where('id', $id)->delete();
        }
        public function updateRecord($id, $data)
        {
            return $this->update($id, $data);
        }
        public function getUserDevices($UserIds)
        {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->select("device_id");
            if(count($UserIds) > 0){
                $builder->whereIn('users.id', $UserIds);
            }
         return $builder->get()->getResultArray();
        }
        // Get User Notifications of a User
        public function getNotifications($user_id)
        {
            $db = \Config\Database::connect();
            $builder = $db->table('notification_user_map');
            return $builder->select('notifications.notification_title,notifications.image,notifications.notification_description,notification_user_map.notification_id')
            ->join('notifications', 'notifications.id = notification_user_map.notification_id', 'left')
            ->where('notification_user_map.user_id', $user_id)
            ->get()->getResultArray();                      
        }

}
