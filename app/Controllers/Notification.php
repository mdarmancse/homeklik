<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Models\RealtorModel;
use CodeIgniter\API\ResponseTrait;
class Notification extends BaseController
{
    use ResponseTrait;
    public function add()
    {
        $db = \Config\Database::connect();
    $builder = $db->table('realtors');
    $builder->select("*");
    $realtors = $builder->get()->getResultArray();  
    $builder = $db->table('users');
    $builder->select("*");
    $users = $builder->get()->getResultArray();  
    $data = [
        'realtors' => $realtors,
        'users' => $users
    ];
        return view('backend/notification/add',$data);
    }
    // Notification Store
    public function store()
    {
        $image = $this->request->getFile('filePhoto');

        if ($image->isValid() && !$image->hasMoved())
        {
            $timestamp = date('YmdHis'); // Get the current timestamp
            $directory = './uploads/notification'; // Specify the directory path with timestamp
            $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
            // Create the directory if it doesn't exist
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
            }
            $image->move($directory, $newName);
        }
            // Save the image data to the database
            $Notification = new NotificationModel();
            $data = [
                'image' =>  $newName,
                'notification_title' => $this->request->getVar('notification_title'),
                'notification_description' => $this->request->getVar('description'),
                'selection_type' => $this->request->getVar('selection_type'),
                'status'  => 1
            ];
            if($this->request->getVar('notification_title'))
            {
                $NotificationID = $Notification->addRecord($data);
            }
            if ($this->request->getVar('selection_type') == "user") {
                if ($this->request->getVar('all_user') == "true") {
                    
                    $User = new UserModel();
                    $conditions = [
                        'active' => '1',
                        'status' => '1'
                    ];
                    $ids = $User->getRecord($conditions);
                    $UserIds = array_column($ids, 'id');
                    
                    $user_data = $User->getRecord($conditions);
                    $add_data = array();
                    foreach ($user_data as $key => $value) {
                        $add_data[] = array(
                            'user_id' => $value['id'],
                            'notification_id' => $NotificationID
                        );
                    }
                } else {
                    $UserIds = $this->request->getVar('user_id');
                   
                    $add_data = array();
                    foreach ($this->request->getVar('user_id') as $key => $value) {
                        if (!empty($value)) {

                            $add_data[] = array(
                                'user_id' => $value,
                                'notification_id' => $NotificationID
                            );
                        }
                    }

                }
                if($this->request->getVar('notification_title'))
                {
                    if (!empty($add_data))
                    $Notification->addBatchRecord($add_data,'notification_user_map');
                }
                
            } 
            else if ($this->request->getVar('selection_type') == "realtor") {
                if ($this->request->getVar('all_realtor') == "true") {
                    $Realtor = new RealtorModel();
                    $conditions = [
                        'status' => '1'
                    ];
                    $ids = $Realtor->getRecord($conditions,100000,1);
                    $UserIds = array_column($ids, 'id');
                    
                    $realtor_data = $Realtor->getRecord($conditions,100000,1);
                    
                    $add_data = array();
                    foreach ($realtor_data as $key => $value) {
                        $add_data[] = array(
                            'realtor_id' => $value['id'],
                            'notification_id' => $NotificationID
                        );
                    }
                } else {
                    $UserIds = $this->request->getVar('realtor_id');
                    $add_data = array();
                    foreach ($this->request->getVar('realtor_id') as $key => $value) {
                        if (!empty($value)) {

                            $add_data[] = array(
                                'realtor_id' => $value,
                                'notification_id' => $NotificationID
                            );
                        }
                    }

                }
                if($this->request->getVar('notification_title'))
                {
                    if (!empty($add_data))
                    $Notification->addBatchRecord($add_data,'notification_realtor_map');
                }
                
            }
            // START Push Notification
            $DeviceIds = $Notification->getUserDevices($UserIds);
            $fields['title'] = $this->request->getVar('notification_title');
            $fields['body'] = $this->request->getVar('description');
            $fields['sound'] = 'default';
            $fields['image'] = base_url() . "uploads/notification/" . $newName;
            $registrationIds = array_column($DeviceIds, 'device_id');
            if(count($registrationIds) ==1)
            {
                sendFCMNotification($fields,$registrationIds[0]);
            }
            else{
                $return = array_chunk($registrationIds, 800);
                foreach ($return as $key => $registrationId) {
                    
                    sendFCMNotification($fields,$registrationId);
                }
            }
            session()->setFlashdata('notification_success', 'Notification Created Successfully');
                return redirect()->to('/notification');
        
    }
    // show product by id
    public function edit($notification_id){
        $Notification = new NotificationModel();
        $conditions = [
            'id' => $notification_id
        ];
        
        $data['notification_data'] = $Notification->getSingleRow($conditions);
        $data['notification_user_map'] = $Notification->getNotificationUserMap($notification_id);
         $data['notification_realtor_map'] = $Notification->getNotificationRealtorMap($notification_id);
        return view('backend/notification/edit',$data);
    }
     // Notification Store
     public function update()
     {
        $db = \Config\Database::connect();
         $image = $this->request->getFile('filePhoto');
 
         if ($image->isValid() && !$image->hasMoved())
         {
             $timestamp = date('YmdHis'); // Get the current timestamp
             $directory = './uploads/notification'; // Specify the directory path with timestamp
             $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
             // Create the directory if it doesn't exist
             if (!file_exists($directory)) {
                 mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
             }
             $image->move($directory, $newName);
         }
         else{
            $newName = $this->request->getVar('uploaded_image');
         }
             // Save the image data to the database
             $Notification = new NotificationModel();
             $data = [
                 'image' =>  $newName,
                 'notification_title' => $this->request->getVar('notification_title'),
                 'notification_description' => $this->request->getVar('description'),
                 'selection_type' => $this->request->getVar('selection_type'),
                 'status'  => 1
             ];
             
             $NotificationID = $Notification->updateRecord($this->request->getVar('notification_id'),$data);
             if ($this->request->getVar('selection_type') == "user") {
                 if ($this->request->getVar('all_user') == "true") {
                     $User = new UserModel();
                     $conditions = [
                         'active' => '1',
                         'status' => '1'
                     ];
                     $user_data = $User->getRecord($conditions);
                     $add_data = array();
                     foreach ($user_data as $key => $value) {
                         $add_data[] = array(
                             'user_id' => $value['id'],
                             'notification_id' => $this->request->getVar('notification_id')
                         );
                     }
                 } else {
                     $add_data = array();
                     foreach ($this->request->getVar('user_id') as $key => $value) {
                         if (!empty($value)) {
 
                             $add_data[] = array(
                                 'user_id' => $value,
                                 'notification_id' => $this->request->getVar('notification_id')
                             );
                         }
                     }
 
                 }
                 if (!empty($add_data))
                 {
                    $builder = $db->table('notification_user_map');
                    $builder->where('notification_id', $this->request->getVar('notification_id'));
                    $builder->delete();
                     $Notification->addBatchRecord($add_data,'notification_user_map');
                 }
             } 
             else if ($this->request->getVar('selection_type') == "realtor") {
                 if ($this->request->getVar('all_realtor') == "true") {
                     $Realtor = new RealtorModel();
                     $conditions = [
                         'status' => '1'
                     ];
                     $realtor_data = $Realtor->getRecord($conditions,1,100000);
                     $add_data = array();
                     foreach ($realtor_data as $key => $value) {
                         $add_data[] = array(
                             'realtor_id' => $value['id'],
                             'notification_id' => $this->request->getVar('notification_id')
                         );
                     }
                 } else {
                     $add_data = array();
                     foreach ($this->request->getVar('realtor_id') as $key => $value) {
                         if (!empty($value)) {
 
                             $add_data[] = array(
                                 'realtor_id' => $value,
                                 'notification_id' => $this->request->getVar('notification_id')
                             );
                         }
                     }
 
                 }
                 if (!empty($add_data))
                 {
                    $builder = $db->table('notification_realtor_map');
                    $builder->where('notification_id', $this->request->getVar('notification_id'));
                    $builder->delete();
                    $Notification->addBatchRecord($add_data,'notification_realtor_map');

                 }
             }
             session()->setFlashdata('notification_success', 'Notification Updated Successfully');
                 return redirect()->to('/notification');
         
     }
    public function index()
   {
        return view('backend/notification/view');
   }
   // Get Ajax Data
   public function ajaxView()
    {
        $Notification = new NotificationModel();
        $data = $Notification->getRecord();
        // Prepare the response array
         $response = array();
         $sl = 0;
       // Populate the response array with data 
        foreach ($data as $row) {
            $action = '<a class="btn btn-sm btn-space btn-success"" href="'.base_url('notification/edit/'.$row['id']) . '"><i class="fa fa-edit"></i>Edit</a>';
            $action .= '<button type="button" onclick="ajaxDelete(' . $row['id'] . ')" class="btn btn-sm btn-space btn-secondary"> <i class="fas fa-trash"></i> Delete</button>'; 
            
        
            $response[] = array(
                'id' => ++$sl,
                'notification_title' => $row['notification_title'],
                'action' => $action
               
            );

        }
        echo json_encode($response);
    }
     // Delete Notification
     public function ajaxDelete($entity_id)
     {
        $db = \Config\Database::connect();
        $builder = $db->table('notification_user_map');
        $builder->where('notification_id', $entity_id);
        $builder->delete();
        $builder = $db->table('notification_realtor_map');
        $builder->where('notification_id', $entity_id);
        $builder->delete();
         $Notification = new NotificationModel();
         $status = $Notification->deleteRow($entity_id);
         if($status)
                 {
                     $response = [
                         'status'   => 1,
                         'message' => 'Notification Deleted Successfully !'
             
                     ];
                     return $this->respondCreated($response); 
                 }
         else
             {
                 $response = [
                     'status'   => 0,
                     'message' => 'Notification Deletion Failed !'
         
                 ];
                 return $this->respondCreated($response); 
             }
     }
}
