<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\RealtorModel;
use \CodeIgniter\I18n\Time;
use App\Models\UserModel;
class UserController extends BaseController
{
    use ResponseTrait;
     protected $format    = 'json';
    //Login Api for Realtor
    public function getLogin()
    {
        $Realtor = new RealtorModel();
        $device_id = $this->request->getVar('device_id');
        if ($this->request->getVar('UserName') && $this->request->getVar('Password')) {
            $UserName = $this->request->getVar('UserName');
            $password = $this->request->getVar('Password');
            $conditions = [
                'username' => $UserName,
                'password' => md5(HASH . $password)
            ];
            $login = $Realtor->getSingleRow($conditions);
        
            if (!empty($login)) {
                if ($device_id) {
                    $data = [
                        'device_id'		=> $device_id,
                    ];
                    $Realtor->updateRecord($login['id'], $data);
                }
                    if ($login['status'] == 1) {
                        $db = \Config\Database::connect();
                        $builder = $db->table('brokerages');
                        $builder->select("*");
                        $brokerages = $builder->get()->getResultArray(); 
                        $login_detail = array(
                                'id' => $login['id'],
                                'name' => $login['name'],
                                'username' => $login['username'],
                                'email' => $login['email'],
                                'mobile' => $login['mobile'],
                                'city' => $login['city'],
                                'province' => $login['province'],
                                'unit' => $login['unit'],
                                'postal_code' => $login['postal_code'],
                                'street_number' => $login['street_number'],
                                'street_address1' => $login['street_address1'],
                                'street_address2' => $login['street_address2'],
                                'rico' => $login['rico'],
                                'registration_date' => $login['registration_date'],
                                'brokerage'=> $brokerages

                            );
                        $response = [
                            'status'   => 1,
                            'message' => 'Login Success ',
                            'User' => $login_detail
                        ];
                        return $this->respondCreated($response);
                    } else if ($login['status'] == 0) {
                        $response = [
                            'status'   => 0,
                            'message' => 'Account Deactive!',
                        ];
                        return $this->respondCreated($response);
                    }
                }
                else {
                    $conditions = [
                        'username' => $UserName,
                    ];
                    $CheckUser = $Realtor->getSingleRow($conditions);
                    if ($CheckUser) {
                        $response = [
                            'status'   => -1,
                            'message' => 'Wrong Credentials'
                        ];
                        return $this->respondCreated($response);
                    } else {
                        $response = [
                            'status'   => -1,
                            'message' => 'User Not Found'
                        ];
                        return $this->respondCreated($response);
                    }
             }
        } else {
            $response = [
                'status'   => -1,
                'message' => 'Check Parameters'
            ];
            return $this->respondCreated($response);
        }
    }
    //Realtor Update Data
    public function updateProfile()
    {
        $Realtor = new RealtorModel();
        $UserID = $this->request->getVar('UserID');
        $Name = $this->request->getVar('Name');
        $BrokerageID = $this->request->getVar('BrokerageID');
        $Street_Address1 = $this->request->getVar('Street_Address1');
        $Street_Number = $this->request->getVar('Street_Number');
        $Street_Address2 = $this->request->getVar('Street_Address2');
        $Unit = $this->request->getVar('Unit');
        $Postal_Code = $this->request->getVar('Postal_Code');
        $City = $this->request->getVar('City');
        $Province = $this->request->getVar('Province');
        $Registration_Date = $this->request->getVar('Registration_Date');
        $Rico = $this->request->getVar('Rico');
        $Email = $this->request->getVar('Email');
        $Mobile = $this->request->getVar('Mobile');
        
        if (!$UserID) {
            
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
       else
        {
            $conditions = [
                'id'   => $UserID,
            ];
                $checkRealtor = $Realtor->getSingleRow($conditions);
                if (!($checkRealtor)){
                    $response = [
                        'status'   => -1,
                        'message' => 'User Doesnt Exists!'
                    ];
                    return $this->respondCreated($response);
                    }
                    else
                   {
                        $data = [
                            'name'		=> $Name,
                            'brokerage_id'		=> $BrokerageID,
                            'street_address1'		=> $Street_Address1,
                            'street_address2'		=> $Street_Address2,
                            'street_number'		=> $Street_Number,
                            'unit'		=> $Unit,
                            'postal_code'		=> $Postal_Code,
                            'city'		=> $City,
                            'province'		=> $Province,
                            'rico'		=> $Rico,
                            'registration_date'		=> $Registration_Date,
                            'mobile'		=> $Mobile,
                            'email'		=> $Email,
                        ];
                        
                        if ($Realtor->updateRecord($UserID, $data)) {
                            $response = [
                                'status'   => 1,
                                'message' => 'Successfully Updated !'
                            ];
                            return $this->respondCreated($response);
                        
                        }
                        else{
                            $response = [
                                'status'   => 0,
                                'message' => "Something went wrong. Couldn't update."
                            ];
                            return $this->respondCreated($response);
                        }
                
                    }
        }
        


        
    }
    //Forget Password and Reset Password Api
    public function forgotPassword()
    {
        $Realtor = new RealtorModel();
        $Email = $this->request->getVar('Email');
        $Purpose = $this->request->getVar('Purpose');
        if (!$Email) {
            $response = [
                'status'   => -1,
                'message' => 'Enter Your Email !'
            ];
            return $this->respondCreated($response);
        }
        else
        {
            $conditions = [
                'email' => $Email,
            ];
            $CheckRecord = $Realtor->getSingleRow($conditions);
            if (!$CheckRecord){
                $response = [
                    'status'   => -1,
                    'message' => 'Realtor Not Found !'
                ];
                return $this->respondCreated($response);
            }
            else {
                    if ($Purpose == "Change") {
                        $Otp =  $this->request->getVar('Otp');
                        $Password =  $this->request->getVar('Password');
                        if (!$Otp || !$Password) {
                            $response = [
                                'status'   => -1,
                                'message' => 'No OTP or Password Provided'
                            ];
                            return $this->respondCreated($response);
                        }
        
                        if ($Otp == $CheckRecord['otp']) {
                            $data = [
                                'password'		=> md5(HASH . $Password),
                            ];
                            
                            if ($Realtor->updateRecord($CheckRecord['id'], $data)) {
                                $response = [
                                    'status'   => 1,
                                    'message' => 'Successfully Updated'
                                ];
                                return $this->respondCreated($response);
                            
                            }
                            else{
                                $response = [
                                    'status'   => -1,
                                    'message' => "Something went wrong. Couldn't update."
                                ];
                                return $this->respondCreated($response);
                            }
                            
                        }
                        $response = [
                            'status'   => -1,
                            'message' => "OTP didn't match. Try again."
                        ];
                        return $this->respondCreated($response);
                    } else {
                        $Otp = "123456";
                        $data = [
                            'otp'		=> $Otp,
                        ];
                        $Result = $Realtor->updateRecord($CheckRecord['id'], $data);
                        if ($Result && $Otp) {
                            $response = [
                                'status'   => 1,
                                'message' => "OTP sent"
                            ];
                            return $this->respondCreated($response);
                        } else {
                            $response = [
                                'status'   => -1,
                                'message' => "Could not Send OTP"
                            ];
                            return $this->respondCreated($response);
                        }
                }
            }
        }

        
    }
     // Users Birthday
     public function getBirthdays()
     {
         $User = new UserModel();
         $From_Date = $this->request->getVar('From_Date');
         $To_Date = $this->request->getVar('To_Date');
         if($From_Date == '' && $To_Date == '')
         {
            $conditions = array();
         }
         else if($From_Date == '' &&  $To_Date != ''){
            $From_Date = date('Y-m-d');
            $conditions = ['dob <=' => $To_Date, 'dob >=' => $From_Date];
         }
         else if($From_Date != '' &&  $To_Date == ''){
            $To_Date = date('Y-m-d');
            $conditions = ['dob <=' => $To_Date, 'dob >=' => $From_Date];
         }
         else{
            $conditions = ['dob <=' => $To_Date, 'dob >=' => $From_Date];
         }
        $Columns = ['email','first_name','last_name','mobile','dob'];
        $UserBirthdays = $User->getCondition_Column_Data($Columns,$conditions);
        if (!($UserBirthdays)){
            $response = [
                'status'   => 0,
                'message' => 'No Birthdays!'
            ];
            return $this->respondCreated($response);
            }
        else{
            $response = [
            'status'   => 1,
            'data' => $UserBirthdays,
            'message' => 'Data Found'
            ];
        return $this->respondCreated($response);
        }
                     
                        
    }
    // Send Birthday Notification to User
    public function sendBirthdayNotification()
    {
        $Common = new CommonModel();
        $User = new UserModel();
        $UserID = $this->request->getVar('UserID');
        if (!$UserID) {
            
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
       else
        {
            $conditions = [
                'id'   => $UserID,
            ];
            $checkUser = $User->getSingleRow($conditions);
            if (!($checkUser)){
                $response = [
                    'status'   => -1,
                    'message' => 'User Doesnt Exists!'
                ];
                return $this->respondCreated($response);
                }
            else
            { 
                if ($checkUser['device_id']) {
                    $fields['title'] = "Birthday Notification !";
                    $fields['body'] = $Common->getRecord('system_option','option_slug','birthday_greeting')->option_value;
                    $fields['sound'] = 'default';
                    sendFCMNotification($fields,$checkUser['device_id']);
                    $response = [
                        'status'   => 1,
                        'message' => 'Birthday Notification Send Successfuly !'
                    ];
                    return $this->respondCreated($response);
                
                }
                else{
                    $response = [
                        'status'   => 0,
                        'message' => "Device ID Doesnt exist !"
                    ];
                    return $this->respondCreated($response);
                }
        
            }
        }
        


        
    }
}
