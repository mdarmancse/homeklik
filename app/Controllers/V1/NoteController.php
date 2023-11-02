<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\NoteModel;
use \CodeIgniter\I18n\Time;
class NoteController extends BaseController
{
    use ResponseTrait;
    protected $format    = 'json';
   // Add Note
   public function addNote() 
   {
           $Note = new NoteModel();
           $data = [
           'realtor_id' => $this->request->getVar('RealtorID'),
           'title' => $this->request->getVar('Title'),
           'details' => $this->request->getVar('Details'),
           'date' => $this->request->getVar('Date'),
           'status'  => 1,
           'created_at' => Time::now()
           ];
           $status = $Note->addRecord($data);
           if($status)
           {
               $response = [
                   'status'   => 1,
                   'data' => 'Your note has been added !'
               ];
           }
           else{
               $response = [
                   'status'   => -1,
                   'data' => 'Note add failed !'
               ];
           }
           return $this->respondCreated($response);
   }
    // Realtor Task List API
    public function getNotes() 
    {
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
            $conditions = array();
            $Columns = ['id','realtor_id','title','details','date'];
            $Note = new NoteModel();
            $NoteList = $Note->getRecord($Columns,$conditions);
            if($NoteList)
            {
                $response = [
                    'status'   => 1,
                    'message' => 'Data Found !',
                    'data' => $NoteList
                ];
            }
            else{
                $response = [
                    'status'   => 0,
                    'message'=> 'No Task Found !',
                    'data' => $NoteList
                ];
            }
        }
       
       
        return $this->respondCreated($response);
    }
    // Update Note data
    public function updateNote() 
    {
        if($this->request->getVar('Note_ID') == '')
        {
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
        else{
            $conditions = ['id' => $this->request->getVar('Note_ID')];
            $Columns = ['id','realtor_id','title','details','date'];
            $Note = new NoteModel();
            $NoteList = $Note->getRecord($Columns,$conditions);
            if(!($NoteList))
            {
                $response = [
                    'status'   => -1,
                    'data' => 'Notes Not Found !'
                ];
                return $this->respondCreated($response);
            }
            else{
                $data = [
                    'title' => $this->request->getVar('Title'),
                    'details' => $this->request->getVar('Details'),
                    'date' => $this->request->getVar('Date'),
                    'status'  => 1,
                    'updated_at' => Time::now()
                    ];
                    $status = $Note->updateRecord($this->request->getVar('Note_ID'),$data);
                    if($status)
                    {
                        $response = [
                            'status'   => 1,
                            'data' => 'Your note has been updated !'
                        ];
                       return $this->respondCreated($response);

                    }
                    else{
                        $response = [
                            'status'   => -1,
                            'data' => 'Note update failed !'
                        ];
                        return $this->respondCreated($response);

                    }
            }
            
        }
            
    }
    // Delete Slider
    public function deleteNote()
     {
        if($this->request->getVar('Note_ID') == '')
        {
            $response = [
                'status'   => -1,
                'message' => 'Invalid Parameter'
            ];
            return $this->respondCreated($response);
        }
        else{
            $Note = new NoteModel();
            $status = $Note->deleteRecord($this->request->getVar('Note_ID'));
            if($status)
                    {
                        $response = [
                            'status'   => 1,
                            'message' => 'Note Deleted Successfully !'
                
                        ];
                        return $this->respondCreated($response); 
                    }
            else
                {
                    $response = [
                        'status'   => 0,
                        'message' => 'Note Deletion Failed !'
            
                    ];
                    return $this->respondCreated($response); 
                }
            }
    }
}
