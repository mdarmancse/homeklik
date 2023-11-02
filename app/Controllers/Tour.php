<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TourModel;
use App\Models\RealtorModel;
use App\Models\VisitStatusModel;
use CodeIgniter\API\ResponseTrait;
use Carbon\Carbon;
class Tour extends BaseController
{
    use ResponseTrait;
    public function index()
   {
    $db = \Config\Database::connect();
    $builder = $db->table('realtors');
    $builder->select("*");
    $realtors = $builder->get()->getResultArray();  
    $data = [
        'realtors' => $realtors
    ];
        return view('backend/tour/view',$data);
   }
   // Get Ajax Data
   public function ajaxView()
    {
        $Tour = new TourModel();
        $conditions = array();
        $data = $Tour->getRecord();
        // Prepare the response array
         $response = array();
         $sl = 0;
       // Populate the response array with data 
        foreach ($data as $row) {
            if(is_null($row['accept']))
            {
              $action = '<button type="button" onclick="acceptRequest(' . $row['id'].','.$row['user_id']. ')" class="btn btn-sm btn-space btn-primary"><i class="fa fa-check""></i> '  . "Accept"  . '</button>';
              $action .= '<button type="button" onclick="deleteRequest(' . $row['id'].','.$row['user_id']. ')" class="btn btn-sm btn-space btn-danger"><i class="fa fa-trash""></i> '  . "Delete"  . '</button>';
            }
            else if($row['accept'] ==1){
                $action = '<button type="button" onclick="assignRealtor(' . $row['id'] . ')" class="btn btn-sm btn-space btn-primary"><i class="fa fa-eye""></i> '  . "Assign Realtor"  . '</button>';
            }
            $response[] = array(
                'id' => ++$sl,
                'listing_id' => $row['listing_id'],
                'name' => $row['first_name']. " " .$row['last_name'],
                'realtor_name' => $row['realtor_name'],
                'shift' => $row['schedule'],
                'action'=> $action
            );

        }
        echo json_encode($response);
    }
     // Disable City
     public function assignRealtor($entity_id,$realtor_id)
     {
         $Tour = new TourModel();
         $Realtor = new RealtorModel();
         $Vist = new VisitStatusModel();
         $conditions = array(
            'slug'=> 'not_visited'
         );
        $visit_status = $Vist->getSingleRow($conditions);
        $conditions = array(
            'id'=> $realtor_id
         );
        $realtor_data = $Realtor->getSingleRow($conditions);
         $data = array(
             'realtor_id' => $realtor_id,
             'brokerage_id' => $realtor_data['brokerage_id'],
             'visit_id' => $visit_status['id'],
             'created_at' => Carbon::now()->format('Y-m-d')
         );
         
         $status = $Tour->updateRecord($entity_id,$data);
         if($status)
                 {
                     $response = [
                         'status'   => 1,
                         'message' => 'Realtor Assigned Successfully !'
             
                     ];
                     return $this->respondCreated($response); 
                 }
         else
             {
                 $response = [
                     'status'   => 0,
                     'message' => 'Realtor Assign Failed !'
         
                 ];
                 return $this->respondCreated($response); 
             }
           
     }
     // Disable City
     public function confirmRequest($tour_id,$user_id)
     {
      
         $Tour = new TourModel();
         $User = new UserModel();
         $data = array(
             'accept' => $this->request->getVar('value')
         );
         $status = $Tour->updateRecord($tour_id,$data);
          // START Push Notification
          $conditions = [
            'id' => $user_id
        ];
          $user_details = $User->getSingleRow($conditions);

          
          $fields['title'] = "Tour Request";
          $fields['body'] = $this->request->getVar('value') == 1 ? 'Your Tour Request has Accepted !': 'Your Tour Request has Rejected !';
          $fields['sound'] = 'default';
          sendFCMNotification($fields,$user_details['device_id']);
          
         if($status)
                 {
                     $response = [
                         'status'   => 1,
                         'message' => $this->request->getVar('value') == 1 ? 'Tour Request Accepted !': 'Tour Request Rejected !'
             
                     ];
                     return $this->respondCreated($response); 
                 }
         else
             {
                 $response = [
                     'status'   => 0,
                     'message' => 'Tour Request Confirmation Failed !'
         
                 ];
                 return $this->respondCreated($response); 
             }
           
     }
}
