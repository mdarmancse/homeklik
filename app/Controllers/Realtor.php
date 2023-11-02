<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RealtorModel;
use CodeIgniter\API\ResponseTrait;
use Google\Client;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Google_Service_Gmail_MessagePart;
use Google_Service_Gmail_SendMessageRequest;

class Realtor extends BaseController
{
    use ResponseTrait;

    protected $format = 'json';
    protected $email;
    protected $googleOAuth2;

    public function __construct()
    {
        $this->realtor = new RealtorModel();
        $this->session = session();

    }

    public function index()
    {
        return view('backend/realtor/view');
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

        ## Total number of records without filtering
        $db = \Config\Database::connect();
        $totalRecords = $db->table('realtors')->countAll();

        ## Total number of record with filtering
        $db = \Config\Database::connect();
        $totalRecordwithFilter = $db->table('realtors')->countAll();
        // Main Records Fetch
        $conditions = array();
        $realtors = $this->realtor->getRecord($conditions, $rowperpage, $start);
        // Prepare the response array
        $data = array();
        $sl = 0;
        // Populate the response array with data
        foreach ($realtors as $key => $value) {
            $action = '<a class="btn btn-sm btn-space btn-success"" href="' . base_url('realtor/edit/' . $value['id']) . '"><i class="fa fa-edit"></i>Edit</a>';
            $action .= '<button type="button" onclick="ajaxDisable(' . $value['id'] . ',' . $value['status'] . ')" class="btn btn-sm btn-space btn-warning"><i class="fa fa-' . ($value['status'] ? 'times' : 'check') . '"></i> ' . ($value['status'] ? '' . "Deactive" . '' : '' . "Active" . '') . '</button>';
            $action .= '<button type="button" onclick="ajaxDelete(' . $value['id'] . ')" class="btn btn-sm btn-space btn-danger"><i class="fa fa-trash"></i> Delete</button>';
            $action .= '<button type="button" onclick="ajaxDetails(' . $value['id'] . ')" class="btn btn-sm btn-space btn-info"><i class="fa fa-eye"></i> Details</button>';
            $data[] = array(
                'id' => ++$sl,
                'name' => $value['name'],
                'mobile' => $value['mobile'],
                'email' => $value['email'],
                'status' => $value['status'] ? "Active" : "Inactive",
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

    public function add()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('brokerages');
        $builder->select("*");
        $brokerages = $builder->get()->getResultArray();
        $data = [
            'brokerages' => $brokerages
        ];
        return view('backend/realtor/add', $data);
    }
      //  Store Data
    public function store()
    {
//        $email="mdarmancse@gmail.com";
//        $emailsuccess=$this->sendEmail($email);
//
//        echo $emailsuccess;
//
//        exit();
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $data = array(
            'name' => $this->request->getVar('name'),
            'brokerage_id' => $this->request->getVar('brokerage_id'),
            'username' => $this->request->getVar('username'),
            'password'  =>  md5(HASH . substr(str_shuffle(str_repeat($pool, 5)), 0, 5)),
            'rico' => $this->request->getVar('rico'),
            'registration_date' => $this->request->getVar('registration_date'),
            'board_name' => $this->request->getVar('board_name'),
            'postal_code' => $this->request->getVar('postal_code'),
            'street_number' => $this->request->getVar('street_number'),
            'street_address1' => $this->request->getVar('street_address1'),
            'street_address2' => $this->request->getVar('street_address2'),
            'unit'  => $this->request->getVar('unit'),
            'city' => $this->request->getVar('city'),
            'province' => $this->request->getVar('province'),
            'mobile' => $this->request->getVar('mobile'),
            'email' => $this->request->getVar('email'),
            'status' => 1,
        );
        if($this->realtor->addRecord($data))
        {

            $this->sendEmail($this->request->getVar('email'));
            $this->session->setFlashdata('realtor_success', 'Realtor Added Successfully');
            return redirect()->to('/realtor');
        }
        else{
            $this->session->setFlashdata('realtor_error', 'Realtor Insertion Failed');
            return redirect()->to('/realtor/add');
        }

    }

    public function sendEmail($toEmail)
    {
        // Load the Google API client
        $client = new Google_Client();
        $client->setApplicationName('Your Application Name');
        $client->setScopes([Google_Service_Gmail::GMAIL_SEND]);
        $client->setAuthConfig('./client_secret.json');
        $client->setAccessType('offline');

        // Load the access token from file
        if (file_exists('./access_token.json')) {
            $accessToken = json_decode(file_get_contents('./access_token.json'), true);
            $client->setAccessToken($accessToken);
        } else {
            // Redirect the user to the OAuth 2.0 consent screen
            $authUrl = $client->createAuthUrl();
            return redirect()->to($authUrl);
        }

        // Create Gmail API service
        $gmail = new Google_Service_Gmail($client);

        // Generate a random password
        $randomPassword = $this->generateRandomPassword();

        // Create a message
        $subject = 'Your Randomly Generated Password';
        $messageBody = 'Your randomly generated password: ' . $randomPassword;

        // Construct the email
        $email = new Google_Service_Gmail_Message();
        $email->setRaw(base64_encode("To: $toEmail\r\n" . "Subject: $subject\r\n\r\n" . $messageBody));

        // Send the email
        try {
            $sentEmail = $gmail->users_messages->send('me', $email);
            if ($sentEmail) {
                return 'Email sent successfully.';
            } else {
                return 'Email sending failed.';
            }
        } catch (Exception $e) {
            return 'An error occurred: ' . $e->getMessage();
        }
    }

// Function to generate a random password
    private function generateRandomPassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
    }

    public function callback()
    {
        $client = new Google_Client();
        $client->setApplicationName('Your Application Name');
        $client->setScopes([Google_Service_Gmail::GMAIL_SEND]);
        $client->setAuthConfig('./client_secret.json');
        $client->setAccessType('offline');

        // Exchange authorization code for access token
        if (isset($_GET['code'])) {
            $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            // Save the access token to a file or database
            file_put_contents('./access_token.json', json_encode($accessToken));
            return 'Access token saved successfully.';
        } else {
            return 'Authorization code not found.';
        }
    }


    // Check Email Existance
    public function checkEmail()
    {
        $email = ($this->request->getVar('email') != '') ? $this->request->getVar('email') : '';
        $conditions = [
            'email' => $email
        ];
        $isExist = $this->realtor->getSingleRow($conditions);
        if ($isExist) {
            $response = [
                'status' => 1,
                'message' => 'Exist !'

            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Not Exist !'

            ];
        }
        return $this->respondCreated($response);
    }

    // Check UserName Existance
    public function checkUsername()
    {
        $username = ($this->request->getVar('username') != '') ? $this->request->getVar('username') : '';
        $conditions = [
            'username' => $username
        ];
        $isExist = $this->realtor->getSingleRow($conditions);
        if ($isExist) {
            $response = [
                'status' => 1,
                'message' => 'Exist !'

            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'Not Exist !'

            ];
        }
        return $this->respondCreated($response);
    }

// show product by id
    public function edit($entity_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('brokerages');
        $builder->select("*");
        $brokerages = $builder->get()->getResultArray();
        $conditions = [
            'id' => $entity_id,

        ];
        $data['data'] = $this->realtor->getSingleRow($conditions);
        $data['brokerages'] = $brokerages;

        return view('backend/realtor/edit', $data);
    }

    public function update()
    {

        if ($this->request->getVar('name') != "") {
            $data = [
                'name' => $this->request->getVar('name'),
                'username' => $this->request->getVar('username'),
                'brokerage_id' => $this->request->getVar('brokerage_id'),
                'rico' => $this->request->getVar('rico'),
                'registration_date' => $this->request->getVar('registration_date'),
                'board_name' => $this->request->getVar('board_name'),
                'postal_code' => $this->request->getVar('postal_code'),
                'street_number' => $this->request->getVar('street_number'),
                'street_address1' => $this->request->getVar('street_address1'),
                'street_address2' => $this->request->getVar('street_address2'),
                'unit' => $this->request->getVar('unit'),
                'city' => $this->request->getVar('city'),
                'province' => $this->request->getVar('province'),
                'mobile' => $this->request->getVar('mobile'),
                'email' => $this->request->getVar('email'),
            ];
            //          echo "<pre>";
            // print_r($data);
            // exit();
            $status = $this->realtor->updateRecord($this->request->getVar('entity_id'), $data);
            if ($status) {
                session()->setFlashdata("realtor_edit_success", "Realtor Updated Successfully");
                return redirect()->to('/realtor');
            }
        } else {
            session()->setFlashdata("realtor_edit_error", "Realtor Update Failed");
            return redirect()->to('/realtor');
        }
    }

    // Delete Realtor
    public function ajaxDelete($entity_id)
    {
        $status = $this->realtor->deleteRow($entity_id);
        if ($status) {
            $response = [
                'status' => 1,
                'message' => 'Realtor Deleted Successfully !'

            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 0,
                'message' => 'Realtor Deletion Failed !'

            ];
            return $this->respondCreated($response);
        }
    }

    // Deactive Realtor
    public function ajaxDisable($entity_id, $status)
    {
        $data = array(
            'status' => $status ? 0 : 1
        );
        $status = $this->realtor->updateRecord($entity_id, $data);
        if ($status) {
            $response = [
                'status' => 1,
                'message' => 'Status Updated Successfully !'

            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 0,
                'message' => 'Status Update Failed !'

            ];
            return $this->respondCreated($response);
        }

    }

    // Deactive Realtor
    public function ajaxDetails($entity_id)
    {
        $conditions = [
            'id' => $entity_id
        ];
        $data = $this->realtor->getSingleRow($conditions);
        return $this->respondCreated($data);

    }

    public function getRealtors()
    {
        $realtor_info = $this->request->getVar('term') ? $this->request->getVar('term') : null;
        $Realtor = new RealtorModel();
        $realtor_data = $Realtor->getRealtorData($realtor_info);

        if (!empty($realtor_data)) {
            foreach ($realtor_data as $realtor) {
                $realtor_json[] = array(
                    'label' => $realtor['name'] . ' ' . ' (' . $realtor['mobile'] . ') ',
                    'id' => $realtor['id']
                );
            }
        } else {
            $realtor_json[] = 'No Realtor Found';
        }
        echo json_encode($realtor_json);
    }

    public function getAccessToken()
    {
        $client = new Google_Client();
        $client->setApplicationName('Your Application Name');
        $client->setScopes([Google_Service_Gmail::GMAIL_SEND]);
        $client->setAuthConfig('./client_secret.json'); // Replace with the path to your client secret JSON file
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Redirect the user to the OAuth 2.0 consent screen
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);

    }


}
