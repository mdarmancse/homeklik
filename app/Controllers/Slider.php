<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\SliderModel;

class Slider extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    public function add()
    {
        return view('backend/slider/add');
    }
    // Slider Store
    public function store()
    {
        $image = $this->request->getFile('filePhoto');

        if ($image->isValid() && !$image->hasMoved())
        {
            $timestamp = date('YmdHis'); // Get the current timestamp
            $directory = './uploads/slider'; // Specify the directory path with timestamp
            $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
            // Create the directory if it doesn't exist
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
            }
            $image->move($directory, $newName);
            // Save the image data to the database
            $Slider = new SliderModel();
            $data = [
                'image' =>  $newName,
                'status'  => 1
            ];
            if($Slider->addRecord($data))
            {
                session()->setFlashdata('slider_success', 'Slider Added Successfully');
                return redirect()->to('/slider');
            }
            else{
                session()->setFlashdata('slider_error', 'Slider Add Failed');
                return redirect()->to('/slider/add');
            }
            
        }
        
    }
   public function index()
   {
       return view('backend/slider/view');
   }
   // Get Ajax Data
   public function ajaxView()
    {
        $Slider = new SliderModel();
        $conditions = array();
        $data = $Slider->getRecord($conditions);
        // Prepare the response array
         $response = array();
         $sl = 0;
       // Populate the response array with data 
        foreach ($data as $row) {
            $action = '<button type="button" onclick="ajaxDisable(' . $row['id'] . ',' . $row['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($row['status'] ? 'times' : 'check') . '"></i> ' . ($row['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';
            $action .= '<button type="button" onclick="ajaxDelete(' . $row['id'] . ')" class="btn btn-sm btn-space btn-danger"><i class="fa fa-trash"></i> Delete</button>';
            $response[] = array(
                'id' => ++$sl,
                'image' => $row['image'] ?
                '<img id="oldpic" class="sliderimg" width="70" height="50" src="' . base_url() . 'uploads/slider/' . $row['image'] . '">' : "",
                'status' => $row['status'] ? "Active" : "Inactive",
                'action' => $action
            );

        }
        echo json_encode($response);
    }
    // Delete Slider
    public function ajaxDelete($entity_id)
     {
        $Slider = new SliderModel();
        $status = $Slider->deleteRow($entity_id);
        if($status)
                {
                    $response = [
                        'status'   => 1,
                        'message' => 'Slider Deleted Successfully !'
            
                    ];
                    return $this->respondCreated($response); 
                }
        else
            {
                $response = [
                    'status'   => 0,
                    'message' => 'Slider Deletion Failed !'
        
                ];
                return $this->respondCreated($response); 
            }
    }
    // Disable Slider
    public function ajaxDisable($entity_id,$status)
    {
        $Slider = new SliderModel();
        $data = array(
            'status' => $status ? 0 : 1
        );
        $status = $Slider->updateRecord($entity_id,$data);
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
