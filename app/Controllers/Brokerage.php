<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrokerageModel;
use CodeIgniter\API\ResponseTrait;
class Brokerage extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
    public function __construct()
	{
		$this->brokerage = new BrokerageModel();
		$this->session = session();
	}
    public function add()
    {
        return view('backend/brokerage/add');
    }
    // Check Email Existance
    public function checkEmail()
    {
        $email = ($this->request->getVar('email') != '') ? $this->request->getVar('email') : '';
        $conditions = [
            'email' => $email
        ];
        $isExist = $this->brokerage->getSingleRow($conditions);
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
    // Store Data
    public function store()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'mobile' => $this->request->getVar('mobile'),
            'email' => $this->request->getVar('email'),
            'status' => 1,
        );
        if($this->brokerage->addRecord($data))
        {
            $this->session->setFlashdata('brokerage_success', 'Brokerage Added Successfully');
            return redirect()->to('/brokerage');
        }
        else{
            $this->session->setFlashdata('brokerage_error', 'Brokerage Insertion Failed');
            return redirect()->to('/brokerage/add');
        }
        
    }
    public function index()
    {
        return view('backend/brokerage/view');
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
        $db      = \Config\Database::connect();
        $totalRecords = $db->table('brokerages')->countAll();

        ## Total number of record with filtering
        $db      = \Config\Database::connect();
        $totalRecordwithFilter = $db->table('brokerages')->countAll();
        // Main Records Fetch
        $conditions = array();
        $realtors = $this->brokerage->getRecord($conditions,$rowperpage,$start);
        // Prepare the response array
         $data = array();
        $sl = 0;
       // Populate the response array with data
       foreach($realtors as $key => $value){
        $data[] = array(
                'id' => ++$sl,
                'name' => $value['name'],
                'mobile' => $value['mobile'],
                'email' => $value['email'],
                'status' => $value['status'] ? "Active" : "Inactive",
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
