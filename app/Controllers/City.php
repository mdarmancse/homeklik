<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\CityModel;

class City extends BaseController
{
    use ResponseTrait;
     protected $format    = 'json';
     public function add()
     {
         return view('backend/city/add');
     }
     public function store()
    {
            $City = new CityModel();
            if ($this->request->getVar('name') != "")
            {
                    $data = [
                        'name' => $this->request->getVar('name'),
                        'latitude' => $this->request->getVar('latitude'),
                        'longitude' => $this->request->getVar('longitude'),
                        'is_featured' => $this->request->getVar('is_featured') ? $this->request->getVar('is_featured') : 0,
                        'status'  => 1,
                    ];
                    $ID = $City->addRecord($data);  
                    if($ID)
                    {
                        session()->setFlashdata("city_success", "City Added Successfully");
                        return redirect()->to('/city');
                    }
                }
                else
                    {
                        session()->setFlashdata("city_error", "City Insertrion Failed");
                        return redirect()->to('/city');
                    }
    }
   
     // show product by id
     public function edit($city_id){
        $City = new CityModel();  
        $conditions = [
            'id' => $city_id
        ];
        $data = $City->getSingleRow($conditions);
        return view('backend/city/edit',$data);
    }
    public function update()
      {
        $City = new CityModel();
        if ($this->request->getVar('name') != "")
        {
                $data = [
                    'name' => $this->request->getVar('name'),
                    'latitude' => $this->request->getVar('latitude'),
                    'longitude' => $this->request->getVar('longitude'),
                    'is_featured' => $this->request->getVar('is_featured') ? $this->request->getVar('is_featured') : 0,
                    'status'  => 1,
                ];
                $status = $City->updateRecord($this->request->getVar('entity_id'),$data);
                if($status)
                {
                    session()->setFlashdata("city_edit_success", "City Updated Successfully");
                    return redirect()->to('/city');
                }
            }
            else
                {
                    session()->setFlashdata("city_edit_error", "City Update Failed");
                    return redirect()->to('/city');
                }
     }
    // City View Page
    public function index()
    {
        return view('backend/city/view');
    }
      // City Get Data
    public function ajaxView()
    {
        $City = new CityModel();
        $conditions = array();
        $data = $City->getRecord($conditions);
        // Prepare the response array
         $response = array();
        $sl = 0;
       // Populate the response array with data
        foreach ($data as $row) {
            $action = '<a class="btn btn-sm btn-space btn-success"" href="'.base_url('city/edit/'.$row['id']) . '"><i class="fa fa-edit"></i>Edit</a>';
            // $action = '<button type="button" onclick="ajaxEdit(' . $row['id'] .')" class="btn btn-space btn-success"><i class="fa fa-edit"></i> ' . "Edit" . '</button>';
            $action .= '<button type="button" onclick="ajaxDelete(' . $row['id'] . ')" class="btn btn-sm btn-space btn-secondary"> <i class="fas fa-trash"></i> Delete</button>'; 
            $action .= '<button type="button" onclick="ajaxDisable(' . $row['id'] . ',' . $row['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($row['status'] ? 'times' : 'check') . '"></i> ' . ($row['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';
            
            $response[] = array(
                'id' => ++$sl,
                'name' => $row['name'],
                'status' => $row['status'] ? "Active" : "Inactive",
                'action' => $action
            );

        }
        echo json_encode($response);
    }
    // Delete City
    public function ajaxDelete($entity_id)
    {
        $City = new CityModel();
        $status = $City->deleteRow($entity_id);
        if($status)
                {
                    $response = [
                        'status'   => 1,
                        'message' => 'City Deleted Successfully !'
            
                    ];
                    return $this->respondCreated($response); 
                }
        else
            {
                $response = [
                    'status'   => 0,
                    'message' => 'City Deletion Failed !'
        
                ];
                return $this->respondCreated($response); 
            }
    }
    // Disable City
    public function ajaxDisable($entity_id,$status)
    {
        $City = new CityModel();
        $data = array(
            'status' => $status ? 0 : 1
        );
        $status = $City->updateRecord($entity_id,$data);
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
}
