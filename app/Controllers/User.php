<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class User extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    public function add()
    {
        return view('backend/user/add');
    }
    public function store()
    {
        $User = new UserModel();
        $data = array(
            'first_name' => $this->request->getVar('first_name'),
            'last_name' => $this->request->getVar('last_name'),
            'mobile' => $this->request->getVar('mobile'),
            'email' => $this->request->getVar('email'),
            'password'  => md5(HASH . $this->request->getVar('password')),
            'user_type' => $this->request->getVar('user_type'),
            'status' => 1,
            'active' => 1
        );
        if($User->addRecord($data))
        {
            $session = Services::session();
            $session->setFlashdata('user_success', 'User Added Successfully');
            return redirect()->to('/user');
        }
        else{
            $session = Services::session();
            $session->setFlashdata('user_error', 'User Insertion Failed');
            return redirect()->to('/user/add');
        }
        
    }
    // User View Page
    public function index()
    {
        return view('backend/user/view');
    }
   // Get Ajax Data
    public function ajaxView()
    {
        $User = new UserModel();
        $conditions = [
            'active' => '1'
        ];
        $data = $User->getRecord($conditions);
        // Prepare the response array
        $response = array();
        $sl = 0;
       // Populate the response array with data
        foreach ($data as $row) {
            $action = '<button type="button" onclick="ajaxDisable(' . $row['id'] . ',' . $row['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($row['status'] ? 'times' : 'check') . '"></i> ' . ($row['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';

            $response[] = array(
                'id' => ++$sl,
                'name' => $row['first_name']. " ".$row['last_name'],
                'mobile' => $row['mobile'],
                'email' => $row['email'],
                'status' => $row['status'] ? "Active" : "Inactive",
                'action' => $action
            );

        }
        echo json_encode($response);
    }
    // Disable User
    public function ajaxDisable($entity_id,$status)
    {
        $User = new UserModel();
        $data = array(
            'status' => $status ? 0 : 1
        );
        $User->updateRecord($entity_id,$data);
        $response = [
            'status'   => 1,
            'message' => 'Status Updated Successfully !'

        ];
        return $this->respondCreated($response);   
    }
    // Check Email Existance
    public function checkEmail()
    {
        $email = ($this->request->getVar('email') != '') ? $this->request->getVar('email') : '';
        $User = new UserModel();
        $conditions = [
            'email' => $email
        ];
        $isExist = $User->getSingleRow($conditions);
        if ($isExist) {
            $response = [
                'status'   => 1,
                'message' => 'Exist !'
    
            ];
        }
        else{
            $response = [
                'status'   => 0,
                'message' => 'Not Exist !'
    
            ];
        }
        return $this->respondCreated($response);   
    }
    public function getUsers()
    {
        $user_info   = $this->request->getVar('term') ? $this->request->getVar('term') : null;
        $User = new UserModel();
        $user_data = $User->getUserData($user_info);

        if (!empty($user_data)) {
            foreach ($user_data as $user) {
                $user_json[] = array(
                    'label' => $user['first_name'] . ' ' . ' (' . $user['mobile'] . ') ',
                    'id'    => $user['id']
                );
            }
        } else {
            $user_json[] = 'No User Found';
        }
        
        echo json_encode($user_json);
    }
    
}
