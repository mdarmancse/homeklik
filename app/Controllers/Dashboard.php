<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
	{
		$this->user = new UserModel();
		$this->session = session();
	}


    public function login()
    {
        return view('login');
    }
    public function loginStore()
    {
		$email = $this->request->getVar('email');
		$password = $this->request->getVar('password');
        $conditions = [
            'email' => $email,
            'password' => md5(HASH . $password),
            'active' => 1,
            'status' => 1
        ];
        $user = $this->user->getSingleRow($conditions);
		if ($user) {
				$sessionData = [
					'id' => $user['id'],
					'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'mobile' => $user['mobile'],
					'email' => $user['email'],
					'loggedIn' => true,
				];

				$this->session->set($sessionData);
				return redirect()->to('/');
			}
		session()->setFlashdata('login_error', 'Login Failed!');
		return redirect()->to(site_url('/login'));
    }
    public function profile()
    {
        return view('backend/profile');
    }
    // Change Password
    public function changePassword()
    {
		$password = $this->request->getVar('password');
        $data = [
            'password' => md5(HASH . $password),
        ];
        $status = $this->user->updateRecord(session()->get('id'),$data);
		if($status)
        {
            $this->session->setFlashdata('password_success', 'Password Changed Successfully');
            return redirect()->to('/profile');
        }
        else{

            $this->session->setFlashdata('password_error', 'Password Changed Failed');
            return redirect()->to('/profile');
        }
    }
     // Update Profile 
     public function updateProfile()
     {
         $first_name = $this->request->getVar('first_name');
         $last_name = $this->request->getVar('last_name');
         $email = $this->request->getVar('email');
         $mobile = $this->request->getVar('mobile');

         $data = [
             'first_name' => $first_name,
             'last_name' => $last_name,
             'email' => $email,
             'mobile' => $mobile
         ];
         $status = $this->user->updateRecord(session()->get('id'),$data);
         if($status)
         {
            $sessionData = [
                'id' => session()->get('id'),
                'first_name' => $first_name ? $first_name : session()->get('first_name'),
                'last_name' => $last_name ? $last_name : session()->get('last_name'),
                'email' => $email ? $email : session()->get('email'),
                'mobile' => $mobile ? $mobile : session()->get('mobile'),
                'loggedIn' => true,
            ];

            $this->session->set($sessionData);
             $this->session->setFlashdata('profile_update_success', 'Profile Updated Successfully');
             return redirect()->to('/profile');
         }
         else{
 
             $this->session->setFlashdata('profile_update_error', 'Profile Update Failed');
             return redirect()->to('/profile');
         }
     }
    // Logout Function
    public function logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to('login');
	}
    public function index()
    {
        return view('backend/dashboard');
    }
    public function system_option()
    {
        $model = new CommonModel();
        $data['SystemOptionList'] = $model->GetData('system_option');
        return view('backend/system_option',$data);
    }
    public function system_option_update()
    {
        $systemOptionCount = count($_POST['OptionValue']);
        $systemOptionData = array();
        for ($nCount = 0; $nCount < $systemOptionCount; $nCount++) {
            $systemOptionData[] = array(
                'id'  => $_POST['SystemOptionID'][$nCount],
                'option_value'  => $_POST['OptionValue'][$nCount],
            );
        }
        $model = new CommonModel();
        $status = $model->BatchUpdate($systemOptionData,'system_option');
        if($status)
        {
            session()->setFlashdata("success", "Data Updated Successfully");
            return redirect()->to('/system_option');
        }
        else{
            session()->setFlashdata("error", "Data Update failed");
            return redirect()->to('/system_option');
        }
        
    }
    
}
