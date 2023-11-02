<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\PreConstructionPropertyModel;
use App\Models\PropertyModel;
use App\Models\RentProperty;
use App\Models\SaleProperty;
use Carbon\Carbon;
use Config\Services;
class Property extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    public function add_preconstruction_property()
    {
        return view('backend/property/pre_construction_add');
    }
    public function preconstruction_store()
   {
    $image = $this->request->getFile('filePhoto');

    if ($image->isValid() && !$image->hasMoved())
    {
        $timestamp = date('YmdHis'); // Get the current timestamp
        $directory = './uploads/preconstruction_property'; // Specify the directory path with timestamp
        $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name

        // Create the directory if it doesn't exist
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
        }

        $image->move($directory, $newName);

        // Save the image data to the database
        $imageModel = new PreConstructionPropertyModel();
        $data = [
        'address' => $this->request->getVar('address'),
        'price' => $this->request->getVar('price'),
        'bedrooms' => $this->request->getVar('bedrooms'),
        'bathrooms' => $this->request->getVar('bathrooms'),
        'parking' => $this->request->getVar('parkings'),
        'size_total' => $this->request->getVar('size'),
        'photo' =>  $newName,
        'status'  => 1
     ];
        if($imageModel->insert($data))
        {
            $session = Services::session();
            $session->setFlashdata('success', 'Property Added Successfully');
            return redirect()->to('/property/construction-property');
        }
        
    }
   }
   public function index()
   {
       return view('backend/property/view');
   }
   // Get Ajax Data
   public function ajaxView()
    {
       $draw = $_POST['draw'];
        $start = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value
        ## Search 
        // $searchQuery = " ";
        // if($searchValue != ''){
        // $searchQuery = " and (emp_name like '%".$searchValue."%' or 
        //         email like '%".$searchValue."%' or 
        //         city like'%".$searchValue."%' ) ";
        // }

        ## Total number of records without filtering
        $db      = \Config\Database::connect();
        $totalRecords = $db->table('properties')->countAll();

        ## Total number of record with filtering
        $db      = \Config\Database::connect();
        $totalRecordwithFilter = $db->table('properties')->countAll();
        $model = new PropertyModel();
        $properties = $model->GetData($rowperpage, $start);
        // echo "<pre>";
        // print_r($properties);
        // exit();
        // Prepare the response array
         $data = array();
        $sl = 0;
       // Populate the response array with data
       foreach($properties as $key => $value){
        $is_feature = '<input name="is_featured" id="is_featured" onclick="ajaxFeature('  . $value['id'] . ',' . $value['is_feature'] . ')" type="checkbox"'.($value['is_feature'] == 1 ? "checked" : ""). ' data-toggle="toggle" data-onstyle="success" data-offstyle="danger">';
        $action = '<button type="button" onclick="ajaxDisable(' . $value['id'] . ',' . $value['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($value['status'] ? 'times' : 'check') . '"></i> ' . ($value['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';
        // $Address = unserialize($value['address']);
         $photo = unserialize($value['photo']);
        // $Buildings = unserialize($value['buildings']);
        // $Land = unserialize($value['land']);
            $date = $value['last_updated'];
                $date = new Carbon($date);
                $now = Carbon::now();
                $difference = ($date->diff($now)->days < 1)
                    ? 'today'
                    : $date->diffForHumans($now);
            $data[] = array(
                'id' => ++$sl,
                'listing_id' => $value['listing_id'],
                'price' => isset($value['price']) ? $value['price'] : "",
                 'address' => isset($value['street_address']) ?$value['street_address']  : "",
                'photo' => isset($photo['0']) ?
          '<img id="oldpic" class="sliderimg" width="70" height="50" src="'.$photo['0'].'">' : "",
                'bathrooms' => $value['bathroom_total'] ? $value['bathroom_total'] : "0",
                'bedrooms' => $value['bedrooms_total'] ? $value['bedrooms_total'] : "0",
                'parking' => $value['parking']? $value['parking'] : "0",
                'size_total_text' => isset($value['size_total']) ? $value['size_total'] : $value['size_total_text'],
                'last_updated' => $difference,
                'is_featured' => $is_feature,
                'action' => $action
            );

        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
    }
    // Disable Property
    public function ajaxDisable($entity_id,$status)
    {
        $Property = new PropertyModel();
        $data = array(
            'status' => $status ? 0 : 1
        );
        $status = $Property->updateRecord($entity_id,$data);
        if($status)
        {
            $response = [
                'status'   => 1,
                'message' => 'Status Updated Successfully !'
    
            ];
            return $this->respondCreated($response); 
        }
        else
            {
                $response = [
                    'status'   => 0,
                    'message' => 'Status Update Failed !'

                ];
                return $this->respondCreated($response); 
            } 
    }
    // Disable/Enable Feature
    public function ajaxFeature($entity_id,$status)
    {
        $Property = new PropertyModel();
        $data = array(
            'is_feature' => $status ? 0: 1
        );
        $status = $Property->updateRecord($entity_id,$data);
        if($status)
        {
            $response = [
                'status'   => 1,
                'message' => 'Status Updated Successfully !'
    
            ];
            return $this->respondCreated($response); 
        }
        else
            {
                $response = [
                    'status'   => 0,
                    'message' => 'Status Update Failed !'

                ];
                return $this->respondCreated($response); 
            } 
    }
    // Pre Construction Property Function
    public function getPreconstruction_Property()
    {
        return view('backend/property/pre_construction_view');
    }
    // Get Ajax Data
   public function getPreconstructionAjaxView()
   {
       $draw = $_POST['draw'];
       $start = $_POST['start'];
       $rowperpage = $_POST['length']; // Rows display per page
       $columnIndex = $_POST['order'][0]['column']; // Column index
       $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
       $searchValue = $_POST['search']['value']; // Search value
       ## Search 
       // $searchQuery = " ";
       // if($searchValue != ''){
       // $searchQuery = " and (emp_name like '%".$searchValue."%' or 
       //         email like '%".$searchValue."%' or 
       //         city like'%".$searchValue."%' ) ";
       // }

       ## Total number of records without filtering
       $db      = \Config\Database::connect();
       $totalRecords = $db->table('preconstructionproperties')->countAll();

       ## Total number of record with filtering
       $db      = \Config\Database::connect();
       $totalRecordwithFilter = $db->table('preconstructionproperties')->countAll();
       $model = new PreConstructionPropertyModel();
       $properties = $model->GetData($rowperpage, $start);
       // Prepare the response array
        $data = array();
       $sl = 0;
      // Populate the response array with data
      foreach($properties as $key => $value){
       $action = '<button type="button" onclick="ajaxDisable(' . $value['id'] . ',' . $value['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($value['status'] ? 'times' : 'check') . '"></i> ' . ($value['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';
           $date = $value['last_updated'];
               $date = new Carbon($date);
               $now = Carbon::now();
               $difference = ($date->diff($now)->days < 1)
                   ? 'today'
                   : $date->diffForHumans($now);
           $data[] = array(
               'id' => ++$sl,
               'listing_id' => $value['listing_id'],
               'price' => isset($value['price']) ? $value['price'] : "",
               'address' => isset($value['price']) ? $value['price'] : "",
               'photo' => $value['photo'] ?
                '<img id="oldpic" class="propertyimg" width="70" height="50" src="' . base_url() . 'uploads/preconstruction_property/' . $value['photo'] . '">' : "",
               'bathrooms' => isset($value['bathrooms']) ? $value['bathrooms'] : "",
               'bedrooms' => isset($value['bedrooms']) ? $value['bedrooms'] : "",
               'parking' => isset($value['parking']) ? $value['parking'] : "",
               'size_total_text' => isset($value['size_total']) ? $value['size_total'] : "",
               'last_updated' => $difference,
               'action' => $action
           );

       }
       ## Response
       $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordwithFilter,
           "aaData" => $data
       );
       echo json_encode($response);
   }
    // Disable Property
    public function ajaxDisable_Preconstruction()
    {
        $model = new PreConstructionPropertyModel();
        $data = array(
            'status' => $this->request->getVar('status') ? 0 : 1
        );
        $model->updateData($this->request->getVar('entity_id'),$data);
        $response = [
            'status'   => 1,
            'message' => 'Status Updated Successfully !'

        ];
        return $this->respondCreated($response);   
    }
    // Rent Property View
    public function getRent_Property()
    {
        return view('backend/property/rent_property');
    }
    // Get Rent Property Ajax Data
    public function getRentPropertyAjaxView()
    {
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value
        ## Search 
        // $searchQuery = " ";
        // if($searchValue != ''){
        // $searchQuery = " and (emp_name like '%".$searchValue."%' or 
        //         email like '%".$searchValue."%' or 
        //         city like'%".$searchValue."%' ) ";
        // }

        ## Total number of records without filtering
        $db      = \Config\Database::connect();
        $totalRecords = $db->table('rent_properties')->countAll();

        ## Total number of record with filtering
        $db      = \Config\Database::connect();
        $totalRecordwithFilter = $db->table('rent_properties')->countAll();
        $model = new RentProperty();
        $properties = $model->GetData($rowperpage, $start);
        // Prepare the response array
        $data = array();
        $sl = 0;
        // Populate the response array with data
        foreach($properties as $key => $value){
            $data[] = array(
                'id' => ++$sl,
                'user_name' => $value['first_name']. " ". $value['last_name'],
                'property_type' => $value['property_type'],
                'unit' => $value['unit'],
                'photo' => $value['photo'] ?
                    '<img id="oldpic" class="propertyimg" width="70" height="50" src="' . base_url() . 'uploads/rent_property/' . $value['photo'] . '">' : "",
                'washrooms' => $value['washrooms'],
                'bedrooms' => $value['bedrooms'],
                'parkings' => $value['parkings'],
                'size' => $value['size'],
                'province' => $value['province'],
                'city' => $value['city'],
                'street_address' => $value['street_address'],
                'postal_code' => $value['postal_code'],
                'price' => $value['price'],
            );

        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
    }
    // Rent Property View
    public function getSale_Property()
    {
        return view('backend/property/sale_property');
    }
    // Get Rent Property Ajax Data
    public function getSalePropertyAjaxView()
    {
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value
        ## Search 
        // $searchQuery = " ";
        // if($searchValue != ''){
        // $searchQuery = " and (emp_name like '%".$searchValue."%' or 
        //         email like '%".$searchValue."%' or 
        //         city like'%".$searchValue."%' ) ";
        // }

        ## Total number of records without filtering
        $db      = \Config\Database::connect();
        $totalRecords = $db->table('sale_properties')->countAll();

        ## Total number of record with filtering
        $db      = \Config\Database::connect();
        $totalRecordwithFilter = $db->table('sale_properties')->countAll();
        $model = new SaleProperty();
        $properties = $model->GetData($rowperpage, $start);
        // Prepare the response array
        $data = array();
        $sl = 0;
        // Populate the response array with data
        foreach($properties as $key => $value){
            $data[] = array(
                'id' => ++$sl,
                'user_name' => $value['first_name']. " ". $value['last_name'],
                'property_type' => $value['property_type'],
                'unit' => $value['unit'],
                'photo' => $value['photo'] ?
                    '<img id="oldpic" class="propertyimg" width="70" height="50" src="' . base_url() . 'uploads/sale_property/' . $value['photo'] . '">' : "",
                'washrooms' => $value['washrooms'],
                'bedrooms' => $value['bedrooms'],
                'parkings' => $value['parkings'],
                'size' => $value['size'],
                'province' => $value['province'],
                'city' => $value['city'],
                'street_address' => $value['street_address'],
                'postal_code' => $value['postal_code'],
                'price' => $value['price'],
            );

        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
    }
}
