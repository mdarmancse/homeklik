<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;

use App\Models\CustomerClassificaionMap;
use App\Models\CustomerClassificationModel;
use App\Models\DashboardModel;
use App\Models\RealtorEarningsModel;
use App\Models\TaskStatusModel;
use App\Models\TourModel;
use App\Models\CommonModel;
use App\Models\VisitStatusModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class DashboardController extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    // Realtor Task List API
    public function getHighlights()
    {
        $Dashboard = new DashboardModel();
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
            $Highlights = $Dashboard->getHighlightsData($Realtor_ID);
            // echo "<pre>";
            // print_r($Highlights);
            // exit();
            if($Highlights)
            {
                $response = [
                    'status'   => 1,
                    'message' => 'Data Found !',
                    'data' => $Highlights
                ];
            }
            else{
                $response = [
                    'status'   => 0,
                    'message'=> 'No Data Found !',
                ];
            }
        }


        return $this->respondCreated($response);
    }

    public function getCustomerClassifications()

    {
//        $customerClass=new CustomerClassificationModel();
        $customerClass=new CustomerClassificationModel();
        $data= $customerClass->getRealtorCustomerClass($this->request->getVar('realtor_id'));
        if ($data){
            $response = [
                'status'   => 1,
                'data' => $data
            ];
        }else{
            $response = [
                'status'   => -1,
                'message' => 'No Data found !',

            ];
        }
        return $this->respondCreated($response);


    }
    public function updateRealtorCustomerClassification()
    {
        $customerMapClass = new CustomerClassificaionMap();
        $customerClass = new CustomerClassificationModel();
        $realtor_id = $this->request->getVar('realtor_id');
        $update_data = $this->request->getVar('update_data');
        $updated_rows = 0;
        $updated_data = array();
        foreach ($update_data as $data) {
            $classification_id = $data->classification_id;
            $visit_status_id = $data->visit_status_id;
            $number = $data->number;


            // Retrieve the existing data as an object
            $existingData = $customerMapClass->where('realtor_id', $realtor_id)
                ->where('classification_id', $classification_id)
                ->first();

            if ($existingData) {
                // Update existing record
                $updateResult = $customerMapClass->update($existingData['id'], [
                    'visit_status_id' => $visit_status_id,
                    'number' => $number,
                    'updated_at'         => Time::now(),
                ]);

                if ($updateResult) {
                    $updated_rows++;
                    $updated_data[] = $customerClass->getRealtorCustomerClass($realtor_id);
                }
            } else {
                // Insert new record
                $insertData = [
                    'realtor_id' => $realtor_id,
                    'classification_id' => $classification_id,
                    'visit_status_id' => $visit_status_id,
                    'number' => $number,
                    'created_at'         =>  Time::now(),
                    'updated_at'         =>  Time::now(),
                ];

                $insertResult = $customerMapClass->insert($insertData);
                if ($insertResult) {
                    $updated_rows++;
                    $updated_data[] = $customerClass->getRealtorCustomerClass($realtor_id);
                }
                if ($insertResult) {
                    $updated_rows++;
                }
            }
        }

        if ($updated_rows > 0) {
            $response = [
                'status' => 1,
                'message' => 'Data updated or inserted successfully',
                'data' => $updated_data[0]
            ];
        } else {
            $response = [
                'status' => -1,
                'message' => 'No Data updated or inserted'
            ];
        }

        return $this->respondCreated($response);
    }

    public function getVisitStatus(){
        $model = new VisitStatusModel();

        $data = $model->getRecordBySelect();

        if($data)
        {
            $response = [
                'status'   => 1,
                'message' => 'Data Found !',
                'data' => $data
            ];
        }
        else{
            $response = [
                'status'   => 0,
                'message'=> 'No Data Found !',
            ];
        }

        return $this->respondCreated($response);

    }

    public function getRealtorEarning(){
        $model = new RealtorEarningsModel();
        $realtor_id = $this->request->getVar('realtor_id');

        $data = $model->getEarningsData($realtor_id);

        if($data)
        {
            $response = [
                'status'   => 1,
                'message' => 'Data Found !',
                'data' => $data
            ];
        }
        else{
            $response = [
                'status'   => -1,
                'message'=> 'No Data Found !',
            ];
        }

        return $this->respondCreated($response);

    }
    // Customer Profiles data
    public function getCustomerProfiles()
    {
        $Dashboard = new DashboardModel();
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
            $CustomerProfiles = $Dashboard->getCustomerProfilesData($Realtor_ID);
            if($CustomerProfiles)
            {
                $response = [
                    'status'   => 1,
                    'message' => 'Data Found !',
                    'data' => $CustomerProfiles
                ];
            }
            else{
                $response = [
                    'status'   => 0,
                    'message'=> 'No Data Found !',
                ];
            }
        }


        return $this->respondCreated($response);
    }
    // Property List API
    public function getPropertyList() 
    {
        if($this->request->getVar('realtor_id') != '')
        {
            $PropertyModel = new DashboardModel();
            $realtor_id = $this->request->getVar('realtor_id');
            $user_type = $this->request->getVar('user_type');
            $property_type = $this->request->getVar('type');
            $price_from = $this->request->getVar('price_from');
            $price_to = $this->request->getVar('price_to');
            $construction_style = $this->request->getVar('construction_style');
            $city = $this->request->getVar('city');
            $bedrooms = $this->request->getVar('bedrooms');
            $bathrooms = $this->request->getVar('bathrooms');
            $parkings = $this->request->getVar('parkings');
            $properties = $PropertyModel->getPropertyList($realtor_id,$user_type,$property_type,$price_from,$price_to,$construction_style,$city,$bedrooms,$bathrooms,$parkings);
            $sl = 0;
            $data = array();
        foreach($properties as $key => $value)
            {
                $photo = unserialize($value['photo']);
                    $data[] = array(
                        'sl' => ++$sl,
                        'listing_id' => $value['listing_id'],
                        'attribute_id' => $value['attribute_id'],
                        'price' => isset($value['price']) ? $value['price'] : "",
                        'address' => isset($value['street_address']) ?$value['street_address']  : "",
                         'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png' ,
                        'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "0",
                        'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "0",
                        'parking' => isset($value['parking'])? $value['parking'] : "0",
                        'size_total' => isset($value['size_total']) ? $value['size_total'] : "0",
                        'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "0",
                        'latitude' => isset($value['latitude']) ? $value['latitude'] : "",
                        'longitude' => isset($value['longitude']) ? $value['longitude'] : "",
                        'property_type' => isset($value['transaction_type']) ? $value['transaction_type'] : "",
                        'status' => $value['status']
                
                    );
            }
         $response = [
            'status'   => 1,
            'data' => $data
        ];
        }
        else{
             $response = [
            'status'   => -1,
            'data' => "Check Your Parameter!"
        ];
        }
        
       
        return $this->respondCreated($response);
    }
    // Add Realtor Favourites Property
     public function addFavourite() 
     {
       if($this->request->getVar('realtor_id') && $this->request->getVar('listing_id')){
             $Common = new CommonModel();
             $array = ['realtor_id' => $this->request->getVar('realtor_id'), 'listing_id' => $this->request->getVar('listing_id')];
             $records = $Common->getRecordArray('realtor_favourites',$array);
             if(!($records))
             {
               $data = [
                   'realtor_id' => $this->request->getVar('realtor_id'),
                   'listing_id' => $this->request->getVar('listing_id'),
                   'favourite' => 1,
                   'status'   => 1,
                   'created_at'         => Time::now()
                   ];
               $Common->addRecord('realtor_favourites',$data);
               $response = [
                   'status'   => 1,
                   'favourite' => 1,
                   'message' => 'Property Added to Favourites !'
               ];
             }
             else{

               $data = [
                   'favourite' => ($records['favourite'] == 0) ? 1: 0,
                   'updated_at'         => Time::now()
                   ];
                   
                   $Common->updateRecord('realtor_favourites',$data,['realtor_id' => $this->request->getVar('realtor_id'),'listing_id' => $this->request->getVar('listing_id')]);
                   $response = [
                       'status'   => 1,
                       'favourite' => ($records['favourite'] == 0) ? 1: 0,
                       'message' => $records['favourite'] == 0 ? 'Propert added to favourites !' : 'Property removed from favourites !'
                   ];
               }
           }
             else{
                 $response = [
                     'status'   => -1,
                     'data' => 'Check Your Parameter!'
                 ];
             }
             return $this->respondCreated($response);
     }
}
