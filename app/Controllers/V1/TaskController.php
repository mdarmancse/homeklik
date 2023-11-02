<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Models\RealtorEarningsModel;
use App\Models\RealtorModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\TaskModel;
use App\Models\TourModel;
use Carbon\Carbon;
use App\Models\VisitStatusModel;
use \CodeIgniter\I18n\Time;
class TaskController extends BaseController
{
    use ResponseTrait;
     protected $format    = 'json';
     // Add Task
     public function addTask() 
     {
             $Task = new TaskModel();
             $data = [
             'realtor_id' => $this->request->getVar('RealtorID'),
             'title' => $this->request->getVar('Title'),
             'details' => $this->request->getVar('Details'),
             'date' => $this->request->getVar('Date'),
             'task_status' => $this->request->getVar('Task_Status'),
             'status'  => 1,
             'created_at' => Time::now()
             ];
             $status = $Task->addRecord($data);
             if($status)
             {
                 $response = [
                     'status'   => 1,
                     'data' => 'Your task has been added !'
                 ];
             }
             else{
                 $response = [
                     'status'   => -1,
                     'data' => 'Task add failed !'
                 ];
             }
             return $this->respondCreated($response);
     }
     // Realtor Task List API
    public function getTasks() 
    {
        $Realtor_ID = $this->request->getVar('Realtor_ID');
        if(!($Realtor_ID))
        {
             $response = [
                        'status' => -1,
                        'message' => "Check your parameter"
                    ];
        }
        else
        {
            $From_Date = $this->request->getVar('From_Date');
            $To_Date = $this->request->getVar('To_Date');
            if($From_Date == '' && $To_Date == '')
            {
                $conditions = array();
            }
            else if($From_Date == '' &&  $To_Date != ''){
                $From_Date = date('Y-m-d');
                $conditions = ['realtor_id' => $Realtor_ID,'date <=' => $To_Date, 'date >=' => $From_Date];
            }
            else if($From_Date != '' &&  $To_Date == ''){
                $To_Date = date('Y-m-d');
                $conditions = ['realtor_id' => $Realtor_ID,'date <=' => $To_Date, 'date >=' => $From_Date];
            }
            else{
                $conditions = ['realtor_id' => $Realtor_ID,'date <=' => $To_Date, 'date >=' => $From_Date];
            }
            $Columns = ['id','realtor_id','title','details','task_status','date'];
            $Task = new TaskModel();
            $TaskList = $Task->getRecord($Columns,$conditions);
            if($TaskList)
            {
                $response = [
                    'status'   => 1,
                    'message' => 'Data Found !',
                    'data' => $TaskList
                ];
            }
            else{
                $response = [
                    'status'   => 0,
                    'message'=> 'No Task Found !',
                    'data' => $TaskList
                ];
            }
        }
       
       
        return $this->respondCreated($response);
    }
    // Update Task data
    public function updateTask() 
    {
        if($this->request->getVar('Task_ID') == '')
        {
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
        else{
            $conditions = ['id' => $this->request->getVar('Task_ID')];
            $Columns = ['id','realtor_id','title','details','task_status','date'];
            $Task = new TaskModel();
            $TaskList = $Task->getRecord($Columns,$conditions);
            if(!($TaskList))
            {
                $response = [
                    'status'   => -1,
                    'data' => 'Task Not Found !'
                ];
                return $this->respondCreated($response);
            }
            else{
                $data = [
                    'title' => $this->request->getVar('Title'),
                    'details' => $this->request->getVar('Details'),
                    'date' => $this->request->getVar('Date'),
                    'task_status' => $this->request->getVar('Task_Status'),
                    'status'  => 1,
                    'created_at' => Time::now()
                    ];
                    $status = $Task->updateRecord($this->request->getVar('Task_ID'),$data);
                    if($status)
                    {
                        $response = [
                            'status'   => 1,
                            'data' => 'Your task has been updated !'
                        ];
                       return $this->respondCreated($response);

                    }
                    else{
                        $response = [
                            'status'   => -1,
                            'data' => 'Task update failed !'
                        ];
                        return $this->respondCreated($response);

                    }
            }
            
        }
            
    }
    public function getVisitLists()
    {
        $Task = new TaskModel();
        $RealtorID = $this->request->getVar('RealtorID');
        if (!$RealtorID) {
            
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
        else{
            
            $VisitList = $Task->getVisitData($RealtorID);
            if (!($VisitList)){
                $response = [
                    'status'   => 0,
                    'message' => 'No Tours!'
                ];
                return $this->respondCreated($response);
                }
            else{
                $Visited = array();
                $NotVisited = array();
                foreach ($VisitList as $key => $value) {
                    if ($value['slug'] == "visited") {
                        $Visited[] = $value;
                    } else {
                        $NotVisited[] = $value;
                    }
                }
                $data['visited'] = $Visited;
                $data['not_visited'] = $NotVisited;
                $response = [
                'status'   => 1,
                'data' => $data,
                'message' => 'Data Found'
                ];
            return $this->respondCreated($response);
            }
        }
        
    }
    public function getVisitDetails()
    {
        $Task = new TaskModel();
        $TourID = $this->request->getVar('TourID');
        if (!$TourID) {
            
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
        else{
            
            $VisitDetails = $Task->getVisitDetails($TourID);
            $data = array();
            $data['visit_status'] = $VisitDetails[0]['name'];
            $data['listing_id'] = $VisitDetails[0]['listing_id'];
            $data['price'] = $VisitDetails[0]['price'];
            $data['transaction_type'] = $VisitDetails[0]['transaction_type'];
            $data['bedrooms_total'] = $VisitDetails[0]['bedrooms_total'];
            $data['bathroom_total'] = $VisitDetails[0]['bathroom_total'];
            $data['parking'] = $VisitDetails[0]['parking'];
            $data['street_address'] = $VisitDetails[0]['street_address'];
            $data['size_total'] = $VisitDetails[0]['size_total'];
            $data['first_name'] = $VisitDetails[0]['first_name'];
            $data['last_name'] = $VisitDetails[0]['last_name'];
            $data['mobile'] = $VisitDetails[0]['mobile'];
            $data['email'] = $VisitDetails[0]['email'];
            $data['photo'] = unserialize($VisitDetails[0]['photo'])[0];

            $schedule = array();
            $schedule[0]['date'] = $VisitDetails[0]['date'];
            $schedule[0]['shift'] = $VisitDetails[0]['shift'];
            $schedule[1]['date'] = $VisitDetails[1]['date'];
            $schedule[1]['shift'] = $VisitDetails[1]['shift'];
            $schedule[2]['date'] = $VisitDetails[2]['date'];
            $schedule[2]['shift'] = $VisitDetails[2]['shift'];
            $data['photo'] = unserialize($VisitDetails[0]['photo'])[0];
            $data['user_image'] = $VisitDetails['image'] ?  base_url() . "uploads/user/" . $VisitDetails['image'] : base_url().'assets/images/human.png';
            $data['schedule'] = $schedule;
            if (!($VisitDetails)){
                $response = [
                    'status'   => 0,
                    'message' => 'No Data Found!'
                ];
                return $this->respondCreated($response);
                }
            else{
                $response = [
                'status'   => 1,
                'data' => $data,
                'message' => 'Data Found'
                ];
            return $this->respondCreated($response);
            }
        }
    }
    public function changeBid()
    {
        try {
            $tourModel =new TourModel();
            $data = [
                'bid_price' => $this->request->getVar('bid_price'),
                'bid_closing_date' => $this->request->getVar('bid_closing_date'),
                'updated_at' =>Time::now()
            ];
            $updated_data = $tourModel->updateRecord($this->request->getVar('tour_id'),$data);
            if ($updated_data === true){
                $response = [
                    'status'   => 1,
                    'message' =>"Success",
                ];
            }else{
                $response = [
                    'status'   => -1,
                    'message' =>"Something went wrong",
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status'   => -1,
                'message' =>"An error occurred: " . $e->getMessage(),
            ];
        }

        return $this->respondCreated($response);
    }
    // Update Schedule
    public function updateSchedule() 
    {
           $Tour = new TourModel();
            $Tour_ID = $this->request->getVar('Tour_ID');
            $conditions = [
                'id' => $Tour_ID
            ];
            $Data = $Tour->getSingleRow($conditions);
            if($Data)
            {
                foreach ($this->request->getVar('schedule') as $key => $value) {
                    if (!empty($value)) {
      
                        $add_data[] = array(
                            'tour_id' => $Tour_ID,
                            'date' => $value->date,
                            'shift' => $value->shift,
                            'status' => 1,
                            'created_at'=> Time::now()
                        );
                    }
                }
                $db = \Config\Database::connect();
                $builder = $db->table('tour_schedule_map');
                $builder->where('tour_id', $Tour_ID);
                $builder->delete();
                  $status = $Tour->addBatchRecord($add_data,'tour_schedule_map');
                  if($status)
                  {
                      $response = [
                          'status'   => 1,
                          'data' => 'Your Schedule has been updated !'
                      ];
                  }
                  else{
                      $response = [
                          'status'   => -1,
                          'data' => 'Tour Scheduled Failed ! '
                      ];
                  }
                  return $this->respondCreated($response);
            }
            else{
                $response = [
                    'status'   => -1,
                    'data' => 'Tour Doesnt Exist !'
                ];
                return $this->respondCreated($response);
            }
            
    }

    // Change Status of A Property Tour
    public function changeStatus() 
    {
           $Visit = new VisitStatusModel();
           $Tour = new TourModel();
           $Earning = new RealtorEarningsModel();
           $currentDate = Carbon::now();
           $currentMonth = $currentDate->format('F');
           $currentYear = $currentDate->format('Y');
           $tour_id = $this->request->getVar('tour_id');
            $realtor_id = $this->request->getVar('realtor_id');
            $status = $this->request->getVar('status');
            $conditions = [
                'slug' => $status
            ];
            $data = $Visit->getSingleRow($conditions);
            if($data)
            {
                $conditions = [
                    'id' => $tour_id
                ];
                $tour_data = $Tour->getSingleRow($conditions);
                        $update_data = array(
                            'visit_id' => $data['id']
                        );
                        $add_data = array(
                            'realtor_id' => $realtor_id,
                            'tour_id' => $tour_id,
                            'earning' => ($tour_data['bid_price'] * 2.5)/100,
                            'month' => $currentMonth,
                            'year' => $currentYear,
                            'created_at' => Carbon::now()

                        );
                  $earning_status = $Earning->addRecord($add_data);
                  $status = $Tour->updateRecord($tour_id,$update_data);
                  if($status && $earning_status)
                  {
                      $response = [
                          'status'   => 1,
                          'message' => 'Your have successfully bid for this property !'
                      ];
                  }
                  else{
                      $response = [
                          'status'   => -1,
                          'message' => 'Bidding failed ! '
                      ];
                  }
                  return $this->respondCreated($response);
            }
            else{
                $response = [
                    'status'   => -1,
                    'message' => 'Tour Doesnt Exist !'
                ];
                return $this->respondCreated($response);
            }
            
    }



}
