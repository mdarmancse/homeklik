<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TaskStatusModel;
use CodeIgniter\API\ResponseTrait;

class TaskStatusController extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    public function index()
    {
        return view('backend/task_status/view');
    }
    public function add()
    {
        return view('backend/task_status/add');
    }
    public function store()
    {

        $model = new TaskStatusModel();
        if ($this->request->getVar('name') != "")
        {
            $data = [
                'name' => $this->request->getVar('name'),
                'slug' => $this->request->getVar('slug'),
                'status'  => 1,
            ];
            $ID = $model->addRecord($data);
            if($ID)
            {
                session()->setFlashdata("success", "Data added successfully");
                return redirect()->to('/task_status');
            }
        }
        else
        {
            session()->setFlashdata("error", "Data insertion failed");
            return redirect()->to('/task_status');
        }
    }

    public function edit($model_id){
        $model = new TaskStatusModel();
        $conditions = [
            'id' => $model_id
        ];
        $data = $model->getSingleRow($conditions);
        return view('backend/task_status/edit',$data);
    }
    public function update()
    {
        $model = new TaskStatusModel();
        if ($this->request->getVar('name') != "")
        {
            $data = [
                'name' => $this->request->getVar('name'),
                'slug' => $this->request->getVar('slug'),
                'status'  => 1,
            ];
            $status = $model->updateRecord($this->request->getVar('entity_id'),$data);
            if($status)
            {
                session()->setFlashdata("success_msg", "Data updated successfully");
                return redirect()->to('/task_status');
            }
        }
        else
        {
            session()->setFlashdata("error_msg", "Data update failed");
            return redirect()->to('/task_status');
        }
    }

    public function ajaxView()
    {
        $model = new TaskStatusModel();
        $conditions = array();
        $data = $model->getRecord($conditions);
        // Prepare the response array
        $response = array();
        $sl = 0;
        // Populate the response array with data
        foreach ($data as $row) {
            $action = '<a class="btn btn-sm btn-space btn-success"" href="'.base_url('task_status/edit/'.$row['id']) . '"><i class="fa fa-edit"></i>Edit</a>';
            // $action = '<button type="button" onclick="ajaxEdit(' . $row['id'] .')" class="btn btn-space btn-success"><i class="fa fa-edit"></i> ' . "Edit" . '</button>';
            $action .= '<button type="button" onclick="ajaxDelete(' . $row['id'] . ')" class="btn btn-sm btn-space btn-secondary"> <i class="fas fa-trash"></i> Delete</button>';
            $action .= '<button type="button" onclick="ajaxDisable(' . $row['id'] . ',' . $row['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($row['status'] ? 'times' : 'check') . '"></i> ' . ($row['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';

            $response[] = array(
                'id' => ++$sl,
                'name' => $row['name'],
                'slug' => $row['slug'],
                'status' => $row['status'] ? "Active" : "Inactive",
                'action' => $action
            );

        }
        echo json_encode($response);
    }

    public function ajaxDelete($entity_id)
    {
        $model = new TaskStatusModel();
        $status = $model->deleteRow($entity_id);
        if($status)
        {
            $response = [
                'status'   => 1,
                'message' => 'Data Deleted Successfully !'

            ];
            return $this->respondCreated($response);
        }
        else
        {
            $response = [
                'status'   => 0,
                'message' => 'Data Deletion Failed !'

            ];
            return $this->respondCreated($response);
        }
    }
    public function ajaxDisable($entity_id,$status)
    {
        $model = new TaskStatusModel();
        $data = array(
            'status' => $status ? 0 : 1
        );
        $status = $model->updateRecord($entity_id,$data);
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
