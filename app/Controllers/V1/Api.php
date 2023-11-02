<?php

namespace App\Controllers\V1;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\PropertyModel;
use App\Models\AddressModel;
use App\Models\BuildingModel;
use App\Libraries\Auth;
use App\Controllers\BaseController;
use App\Models\BrandModel;
use App\Models\CityModel;
use App\Models\CommonModel;
use App\Models\MortgageProfile;
use App\Models\NotificationModel;
use App\Models\SaleProperty;
use App\Models\RentProperty;
use App\Models\SliderModel;
use App\Models\TourModel;
use App\Models\UserSearchHistory;
use Carbon\Carbon;

class Api extends BaseController
{
     use ResponseTrait;
     protected $format    = 'json';
     //Registration APi 
        public function Registration()
        {
            $Auth = new Auth();
            $User = new UserModel();
            if ($this->request->getVar('PhoneNumber') != "" && $this->request->getVar('Password') != "")
            {
                $mobile = $this->request->getVar('PhoneNumber');
                $password = $this->request->getVar('Password');

                    $conditions = [
                        'mobile' => $mobile,
                    ];
                    $CheckRecord =$User->getSingleRow($conditions);
                 
                    if(!($CheckRecord))
                    {
                        $data = [
                            'mobile' => $mobile,
                            'password'  => md5(HASH . $password),
                            'status'  => 1,
                            'active'  => 0,
                        ];
                        if ($UserID = $User->addRecord($data)){
                            if ($UserID) {
                                $conditions = [
                                    'id' => $UserID,
                                ];
                                $login = $User->getSingleRow($conditions);
                                $token = $Auth->generate_token($UserID);
                                $login['token'] = $token;
                            } else {
                                $response = [
                                    'status'   => -1,
                                    'message' => 'Registration Failed !'
                                ];
                                return $this->respondCreated($response);
                            }
                            if ($token) {
                                $otp = $Auth->sendOtp($mobile);
                                if (!$otp) {
                                    $response = [
                                        'User' => $login,
                                        'active'   => 0,
                                        'status'   => -1,
                                        'message' => 'Registration Success. OTP Failed'
                                    ];
                                    return $this->respondCreated($response);
                                } else {
                                    $data = [
                                        'sms_otp'		=> $otp,
                                    ];
                                    $User->updateRecord($UserID, $data);
                                    $response = [
                                        'User' => $login,
                                        'status'   => 1,
                                        'active' => 0,
                                        'message' => 'Registration Success !'
                                    ];
                                    return $this->respondCreated($response);
                                }; 
                            } 
                            else {
                                $response = [
                                    'status'   => -1,
                                    'message' => 'Registration Failed !'
                                ];
                                return $this->respondCreated($response);
                            }
                        }
                        else{
                            $response = [
                                'status'   => -1,
                                'message' => 'Data Insertion Failed !'
                            ];
                        }
                        return $this->respondCreated($response);
                    }
                    else if($CheckRecord)
                    {
                         if($CheckRecord['active'] == 0)
                            {
                                $response = [
                                    'active'   => 0,
                                    'status'   => 1,
                                    'User' => $CheckRecord,
        
                                ];
                                return $this->respondCreated($response);
                            }
                        else{
                                 $response = [
                                   
                                    'active'   => 1,
                                    'status'   => -1,
                                    'message' => 'User Already Exist !',
                                ];
                                return $this->respondCreated($response);
                            }
                   }
                    
                    
                }
            else
                {
                    $response = [
                        'status'   => -1,
                        'message' => 'Check Your Parameter !'

                    ];
                    return $this->respondCreated($response);
                }
        }
    
     //Verify OTP API
        public function verifyOTP()
        {
            $User = new UserModel();
            $mobile = $this->request->getVar('PhoneNumber');
            $otp =$this->request->getVar('sms_otp');
            $conditions = [
                'mobile' => $mobile,
            ];
             $login = $User->getSingleRow($conditions);
    
            if (!empty($login)) {
                if ($login['sms_otp'] == $otp) {
                    $data = [
                        'active'		=> 1,
                    ];
                    $User->updateRecord($login['id'], $data);
                    $login_detail = array('first_name' => $login['first_name'],'last_name' => $login['last_name'], 'PhoneNumber' => $login['mobile'], 'UserID' => $login['id']);
                    $response = [
                        'status'   => 1,
                        'active' => 1,
                        'login' => $login_detail,
                        'message' => 'Success!'
                    ];
                    return $this->respondCreated($response);
                }
                else {
                    $response = [
                        'status'   => -1,
                        'active' => 0,
                        'message' => 'OTP Wrong!'
                    ];
                    return $this->respondCreated($response);
                }
            } else {
                $response = [
                    'status'   => -1,
                    'message' => 'Number Doesnt Exist!'
                ];
                return $this->respondCreated($response);
            }
        }
     //Login Api for User
        public function getLogin()
        {
            $User = new UserModel();
            $Auth = new Auth();
            $device_id = $this->request->getVar('device_id');
            if ($this->request->getVar('PhoneNumber') && $this->request->getVar('Password')) {
                $mobile = $this->request->getVar('PhoneNumber');
                $password = $this->request->getVar('Password');
                $conditions = [
                    'mobile' => $mobile,
                    'password' => md5(HASH . $password)
                ];
                $login = $User->getSingleRow($conditions);
            
                if (!empty($login)) {
                    if ($device_id) {
                        $data = [
                            'device_id'		=> $device_id,
                        ];
                        $User->updateRecord($login['id'], $data);
                    }
                    if ($login['active'] == 1) {

                        if ($login['status'] == 1) {
                            $token = $Auth->generate_token($login['id']);
                            $login_detail = array(
                                "id" => $login['id'],
                                 'first_name' => $login['first_name'],
                                 'last_name' => $login['last_name'],
                                 'email' => $login['email'],
                                  'mobile' => $login['mobile'], 
                                  'token' => $token);
                            $response = [
                                'status'   => 1,
                                'message' => 'Login Success ',
                                'active' => 1,
                                'User' => $login_detail
                            ];
                            return $this->respondCreated($response);
                        } else if ($login['status'] == 0) {
                            $response = [
                                'status'   => -1,
                                'message' => 'Account Deactive!',
                            ];
                            return $this->respondCreated($response);
                        }
                    } else {
                        $otp = $Auth->sendOtp($mobile);
                        if (!$otp) {
                            $response = [
                                'status'   => -1,
                                'active' => 0,
                                'message' => 'OTP send failed',
                            ];
                            return $this->respondCreated($response);
                        } else {
                            $data = [
                                'sms_otp'		=> $otp,
                            ];
                            $User->updateRecord($login['id'], $data);
                            $response = [
                                'status'   => 1,
                                'active' => 0,
                                'message' => "OTP Sent",
                                'phoneNumber' => $login['mobile']
                            ];
                        return $this->respondCreated($response);   
                        }
                    }
                } else {
                    $conditions = [
                        'mobile' => $mobile,
                    ];
                    $CheckUser = $User->getSingleRow($conditions);
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
     //Forget Password API
        public function forgotPassword()
        {
            $User = new UserModel();
            $Auth = new Auth();
            $mobile = $this->request->getVar('PhoneNumber');
            $purpose = $this->request->getVar('purpose');
            if (!$mobile) {
                $response = [
                    'status'   => -1,
                    'message' => 'Check Parameter'
                ];
                return $this->respondCreated($response);
            }
            else
            {
                $conditions = [
                    'mobile' => $mobile,
                ];
                $checkRecord = $User->getSingleRow($conditions);
                if (!$checkRecord){
                    $response = [
                        'status'   => -1,
                        'message' => 'User Not Found'
                    ];
                    return $this->respondCreated($response);
                }
                else {
                        if ($purpose == "change") {
                            $user_otp =  $this->request->getVar('otp');
                            $password =  $this->request->getVar('password');
                            if (!$user_otp || !$password) {
                                $response = [
                                    'status'   => -1,
                                    'message' => 'No OTP or Password Provided'
                                ];
                                return $this->respondCreated($response);
                            }
            
                            if ($user_otp == $checkRecord['sms_otp']) {
                                $data = [
                                    'password'		=> md5(HASH . $password),
                                ];
                                
                                if ($User->updateRecord($checkRecord['id'], $data)) {
                                    $response = [
                                        'status'   => 1,
                                        'message' => 'Successfully updated'
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
                            $otp = $Auth->sendOtp($checkRecord['mobile']);
                            $data = [
                                'sms_otp'		=> $otp,
                            ];
                            $result = $User->updateRecord($checkRecord['id'], $data);
                            if ($result && $otp) {
                                $response = [
                                    'status'   => 1,
                                    'message' => "OTP sent"
                                ];
                                return $this->respondCreated($response);
                            } else {
                                $response = [
                                    'status'   => -1,
                                    'message' => "Could not initiate OTP"
                                ];
                                return $this->respondCreated($response);
                            }
                    }
                }
            }

            
        }
     //User Details Information Add API
        public function detailsSignup()
        {
        
            $User = new UserModel();
            $UserID = $this->request->getVar('UserID');
            $FirstName = $this->request->getVar('FirstName');
            $LastName = $this->request->getVar('LastName');
            $Dob = $this->request->getVar('Dob');
            $Gender = $this->request->getVar('Gender');
            $Email = $this->request->getVar('Email');
            $Language = $this->request->getVar('Language');
            $Street_Address = $this->request->getVar('Street_Address');
            $Unit = $this->request->getVar('Unit');
            $Postal_Code = $this->request->getVar('Postal_Code');
            $City = $this->request->getVar('City');
            $Province = $this->request->getVar('Province');
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
                            $data = [
                                'first_name'		=> $FirstName,
                                'last_name'		=> $LastName,
                                'email'		=> $Email,
                                'gender'		=> $Gender,
                                'dob'		=> $Dob,
                                'street_address'		=> $Street_Address,
                                'unit'		=> $Unit,
                                'postal_code'		=> $Postal_Code,
                                'city'		=> $City,
                                'province'		=> $Province,
                                'language_slug'		=> serialize($Language),
                            ];
                            
                            if ($User->updateRecord($UserID, $data)) {
                                $response = [
                                    'status'   => 1,
                                    'message' => 'Successfully updated'
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
            }
            

    
            
        }
     // Digest Auth API
        public function DigestAuth()
        {
            $cookies = array();
            $url = 'https://data.crea.ca/Login.svc/Login'; // Replace with your target URL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "");

            // Set the CURLOPT_HEADERFUNCTION callback to extract the cookies
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$cookies) {
            if (stripos($header, "Set-Cookie:") === 0) {
                $cookie = trim(substr($header, strlen("Set-Cookie:")));
                $cookies[] = $cookie;
            }
            return strlen($header);
            });
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($ch, CURLOPT_USERPWD, 'twJ1BuSczeGuur8PQnRRUkVg:aYbG4piQVdsJuYC2XqCiTcfm'); // Replace with your username and password
            curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in the response

            $response = curl_exec($ch);
            if ($response === false) {
                // Handle error
                $error = curl_error($ch);
                echo "cURL Error: " . $error;
            }
            // Close cURL handle
            curl_close($ch);
            return $cookies;
        }
     // Fetch Data from Server Using Digest Authenitication
        public function FetchData()
        {

             ///////////////////////////////////////////////////////////
            $PropertyModel = new PropertyModel();
            $AddressModel = new AddressModel();
            $BuildingModel = new BuildingModel();
            $cookies = $this->DigestAuth();
            $finalcookies = "";
            foreach ($cookies as $cookie)
            {
            $value = strtok($cookie, ';');
            $finalcookies .= $value .";";
            }
        
            $cookie = rtrim($finalcookies,";");
            $cookies = $cookie;

            $url = 'https://data.crea.ca/Search.svc/Search?SearchType=Property&Class=Property&QueryType=DMQL2&Format=STANDARD-XML&ID=*&Offset=1&Query=(LastUpdated=2023-01-01T22:00:17Z)';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_COOKIE, $cookies);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($ch, CURLOPT_USERPWD, 'twJ1BuSczeGuur8PQnRRUkVg:aYbG4piQVdsJuYC2XqCiTcfm'); // Replace with your username and password
            curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in the response

            $response = curl_exec($ch);
            if ($response === false) {
                // Handle error
                $error = curl_error($ch);
                echo "cURL Error: " . $error;
            }
            // Close cURL handle
            curl_close($ch);

            $keyword = "<?xml";
            $position = strpos($response, $keyword);
            $xml_String = substr($response, $position);
             $xmlString = simplexml_load_string($xml_String);
            $json = json_encode($xmlString);
            $array = json_decode($json,TRUE);
            //return $array;
//             echo "<pre>";
//             print_r($array);
//             exit();
            $PropertyDetails = $array['RETS-RESPONSE']['PropertyDetails'];
            $TotalRecords = $array['RETS-RESPONSE']['Pagination']['TotalRecords'];
            $latest = $PropertyModel->orderBy('id', 'DESC')->first();
            if(!($latest))
            {
                $i = 1;
            }
            else{
                $i = $latest['id'] + 1;
            }
                do {
                    $url = 'https://data.crea.ca/Search.svc/Search?SearchType=Property&Class=Property&QueryType=DMQL2&Format=STANDARD-XML&ID=*&Offset='.$i.'&Query=(LastUpdated=2023-01-01T22:00:17Z)';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_COOKIE, $cookies);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 2147483647);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
                    curl_setopt($ch, CURLOPT_USERPWD, 'twJ1BuSczeGuur8PQnRRUkVg:aYbG4piQVdsJuYC2XqCiTcfm'); // Replace with your username and password
                    curl_setopt($ch, CURLOPT_HEADER, true); // Include headers in the response
        
                    $response = curl_exec($ch);
                    if ($response === false) {
                        // Handle error
                        $error = curl_error($ch);
                        echo "cURL Error: " . $error;
                        $latest = $PropertyModel->orderBy('id', 'DESC')->first();
                            if(!($latest))
                            {
                                $i = 1;
                            }
                            else{
                            $i = $latest['id'] + 1;
                            }
                    }
                    // Close cURL handle
                    curl_close($ch);
                    $keyword = "<?xml";
                    $position = strpos($response, $keyword);
                    $xml_String = substr($response, $position);
                     $xmlString = simplexml_load_string($xml_String);
                    $json = json_encode($xmlString);
                    $array = json_decode($json,TRUE);
                    $PropertyDetails = $array['RETS-RESPONSE']['PropertyDetails'];
                   
                foreach($PropertyDetails as $Property)
                   {
                    $photo = array();

                        $photo[0] = isset($Property['Photo']['PropertyPhoto'][0]['PhotoURL'])? $Property['Photo']['PropertyPhoto'][0]['PhotoURL']: "";
                        $photo[1] = isset($Property['Photo']['PropertyPhoto'][1]['PhotoURL'])? $Property['Photo']['PropertyPhoto'][1]['PhotoURL'] : "";
                        $photo[2] = isset($Property['Photo']['PropertyPhoto'][2]['PhotoURL'])? $Property['Photo']['PropertyPhoto'][2]['PhotoURL'] : "";
                        $photo[3] = isset($Property['Photo']['PropertyPhoto'][3]['PhotoURL'])?$Property['Photo']['PropertyPhoto'][3]['PhotoURL'] : "" ;
                        // echo "<pre>";
                        // print_r(serialize($photo));
                        // exit();
                        $date = Carbon::parse($Property['@attributes']['LastUpdated']);
                        
                        $datework = $date->format('Y-m-d H:i:s');
                        $data[] = array(
                             'entity_id' => isset($Property['@attributes']['ID']) ? $Property['@attributes']['ID'] : "",
                            'listing_id' => isset($Property['ListingID']) ? $Property['ListingID'] : "",
                            'agent_details' => isset($Property['AgentDetails']) ? serialize($Property['AgentDetails']) : "",
                            'land' => isset($Property['Land']) ? serialize($Property['Land']) : "",
                            'photo' => serialize($photo),
                            'plan' => isset($Property['Plan']) ? $Property['Plan'] : "",
                            'latitude' => isset($Property['Address']['Latitude']) ? $Property['Address']['Latitude'] : "",
                            'longitude' => isset($Property['Address']['Longitude']) ? $Property['Address']['Longitude'] : "",
                            'price' => isset($Property['Price']) ? $Property['Price'] : "",
                            'building_type' => isset($Property['Building']['ConstructionStyleAttachment']) ? $Property['Building']['ConstructionStyleAttachment'] : "",
                            'property_type' => isset($Property['PropertyType']) ? $Property['PropertyType'] : "",
                            'transaction_type' => isset($Property['TransactionType']) ? $Property['TransactionType'] : "",
                            'parking' => isset($Property['ParkingSpaceTotal']) ? $Property['ParkingSpaceTotal'] : "",
                            'province' => isset($Property['Address']['Province']) ? $Property['Address']['Province'] : "",
                            'city' => isset($Property['Address']['City']) ? $Property['Address']['City'] : "",
                            'size_total' => isset($Property['Land']['SizeTotal']) ? $Property['Land']['SizeTotal'] : "",
                            'size_total_text' => isset($Property['Land']['SizeTSizeTotalTextotal']) ? $Property['Land']['SizeTSizeTotalTextotal'] : "",
                            'maintenance_fee' => isset($Property['MaintenanceFee']) ? $Property['MaintenanceFee']: "",
                            'public_remarks' => isset($Property['PublicRemarks']) ? $Property['PublicRemarks']: "",
                            'features' => isset($Property['Features']) ? $Property['Features'] : "",
                            'ownership_type' => isset($Property['OwnershipType']) ? $Property['OwnershipType'] : "",
                            'listing_contract_date' => isset($Property['ListingContractDate']) ? $Property['ListingContractDate'] : "",
                            'last_updated' => $datework,
                            'status' => 1,
                        );
                        $address_data[] = array(
                             'attribute_id' => isset($Property['@attributes']['ID']) ? $Property['@attributes']['ID'] : "",
                            'listing_id' => isset($Property['ListingID']) ? $Property['ListingID'] : "",
                            'street_address' => isset($Property['Address']['StreetAddress']) ? $Property['Address']['StreetAddress'] : "",
                            'address_line' => isset($Property['Address']['AddressLine1']) ? $Property['Address']['AddressLine1'] : "",
                            'street_number' => isset($Property['Address']['StreetNumber']) ? $Property['Address']['StreetNumber'] : "",
                            'street_name' => isset($Property['Address']['StreetName']) ? $Property['Address']['StreetName'] : "",
                            'street_suffix' => isset($Property['Address']['StreetSuffix']) ? $Property['Address']['StreetSuffix'] : "",
                            'street_direction_suffix' => isset($Property['Address']['StreetDirectionSuffix']) ? $Property['Address']['StreetDirectionSuffix'] : "",
                            'city' => isset($Property['Address']['City']) ? $Property['Address']['City'] : "",
                            'province' => isset($Property['Address']['Province']) ? $Property['Address']['Province'] : "",
                            'neighbourhood' => isset($Property['Address']['Neighbourhood']) ? $Property['Address']['Neighbourhood'] : "",
                            'postal_code' => isset($Property['Address']['PostalCode']) ? $Property['Address']['PostalCode'] : "",
                            'unit_number' => isset($Property['Address']['UnitNumber']) ? $Property['Address']['UnitNumber'] : "",
                            'country' => isset($Property['Address']['Country']) ? $Property['Address']['Country'] : "",
                            'community_name' => isset($Property['Address']['CommunityName']) ? $Property['Address']['CommunityName'] : "",
                            'sub_division' => isset($Property['Address']['Subdivision']) ? $Property['Address']['Subdivision'] : ""
                        );
                        $building_data[] = array(
                            'attribute_id' => isset($Property['@attributes']['ID']) ? $Property['@attributes']['ID'] : "",
                            'listing_id' => isset($Property['ListingID']) ? $Property['ListingID'] : "",
                            'bathroom_total' => isset($Property['Building']['BathroomTotal']) ? $Property['Building']['BathroomTotal'] : "",
                            'bedrooms_total' => isset($Property['Building']['BedroomsTotal']) ? $Property['Building']['BedroomsTotal'] : "",
                            'bedrooms_above_ground' => isset($Property['Building']['BedroomsAboveGround']) ? $Property['Building']['BedroomsAboveGround'] : "",
                            'bedrooms_below_ground' => isset($Property['Building']['BedroomsBelowGround']) ? $Property['Building']['BedroomsBelowGround'] : "",
                            'appliances' => isset($Property['Building']['Appliances']) ? $Property['Building']['Appliances'] : "",
                            'architectural_style' => isset($Property['Building']['ArchitecturalStyle']) ? $Property['Building']['ArchitecturalStyle'] : "",
                            'basement_development' => isset($Property['Building']['BasementDevelopment']) ? $Property['Building']['BasementDevelopment'] : "",
                            'basement_type' => isset($Property['Building']['BasementType']) ? $Property['Building']['BasementType'] : "",
                            'constructed_date' => isset($Property['Building']['ConstructedDate']) ? $Property['Building']['ConstructedDate'] : "",
                            'construction_material' => isset($Property['Building']['ConstructionMaterial']) ? $Property['Building']['ConstructionMaterial'] : "",
                            'construction_style_attachment' => isset($Property['Building']['ConstructionStyleAttachment']) ? $Property['Building']['ConstructionStyleAttachment'] : "",
                            'cooling_type' => isset($Property['Building']['CoolingType']) ? $Property['Building']['CoolingType'] : "",
                            'exterior_finish' => isset($Property['Building']['ExteriorFinish']) ? $Property['Building']['ExteriorFinish'] : "",
                            'fireplace_present' => isset($Property['Building']['FireplacePresent']) ? $Property['Building']['FireplacePresent'] : "",
                            'fireplace_total' => isset($Property['Building']['FireplaceTotal']) ? $Property['Building']['FireplaceTotal'] : "",
                            'flooring_type' => isset($Property['Building']['FlooringType']) ? $Property['Building']['FlooringType'] : "",
                            'foundation_type' => isset($Property['Building']['FoundationType']) ? $Property['Building']['FoundationType'] : "",
                            'half_bath_total' => isset($Property['Building']['HalfBathTotal']) ? $Property['Building']['HalfBathTotal'] : "",
                            'heating_fuel' => isset($Property['Building']['HeatingFuel']) ? $Property['Building']['HeatingFuel'] : "",
                            'heating_type' => isset($Property['Building']['HeatingType']) ? $Property['Building']['HeatingType'] : "",
                            'rooms' => isset($Property['Building']['Rooms']) ? serialize($Property['Building']['Rooms']) : "",
                            'stories_total' => isset($Property['Building']['StoriesTotal']) ? $Property['Building']['StoriesTotal'] : "",
                            'total_finished_area' => isset($Property['Building']['TotalFinishedArea']) ? $Property['Building']['TotalFinishedArea'] : "",
                            'type' => isset($Property['Building']['Type']) ? $Property['Building']['Type'] : "",
                            'size_interior' => isset($Property['Building']['SizeInterior']) &&  !(is_array($Property['Building']['SizeInterior'])) ? $Property['Building']['SizeInterior'] : "",
                            'size_exterior' => isset($Property['Building']['SizeExterior']) && !(is_array($Property['Building']['SizeExterior'])) ? $Property['Building']['SizeExterior'] : "",
                            'amenities' => isset($Property['Building']['Amenities']) ? $Property['Building']['Amenities'] : "",
                            'fire_protection' => isset($Property['Building']['FireProtection']) ? $Property['Building']['FireProtection'] : "",
                            'age' => isset($Property['Building']['Age']) ? $Property['Building']['Age'] : "",
                            'utility_water' => isset($Property['Building']['UtilityWater']) ? $Property['Building']['UtilityWater'] : ""
                        );
                        if(count($data) > 199)
                        {
                            $PropertyModel->addBatchRecord($data);
                            $AddressModel->addBatchRecord($address_data);
                            $BuildingModel->addBatchRecord($building_data);
                            $data = array();
                            $address_data = array();
                            $building_data = array();
                        } 
                    }
                $i+=100;
                }
                while ($i < $TotalRecords);
            $response = [
                'status'   => 1,
                'message' => 'Data Inserted Successfully !'
            ];
            return $this->respondCreated($response);
        }
     // Returned Data API
        public function GetData()
        {
            $model = new PropertyModel();
            $data['properties'] = $model->orderBy('id', 'ASC')->findAll();
            return $this->respond($data);
        }
     // Property List for Sale (Latitude & Longitude Wise)
          public function GetFeatureItems_Sale()
        {
                if ($this->request->getVar('latitude') != "" && $this->request->getVar('longitude') != "")
                {
                    $pageNumber = $this->request->getVar('pageNumber') ? $this->request->getVar('pageNumber') : 1;
                    $rowperpage = $this->request->getVar('rowperpage') ? $this->request->getVar('rowperpage') : 30;
                    $offset = ($pageNumber - 1) * $rowperpage;
                    $myModel = new CommonModel();
                    $distance = $myModel->getRecord('system_option','option_slug','distance');
                    $distance = $distance->option_value;
                    $latitude = $this->request->getVar('latitude');
                    $longitude = $this->request->getVar('longitude');

                $data = array();
                $sl = 0;
                    $db = \Config\Database::connect();
                    $builder = $db->table('properties');
                    $builder->select("properties.last_updated,properties.entity_id,properties.id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
                    properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
                    buildings.bathroom_total,buildings.bedrooms_total,3956 * 2 * ASIN(SQRT(POWER(SIN((" . $latitude . " - latitude) * pi()/180/2), 2) +
                        COS(" . $latitude . " * pi()/180) * COS(latitude * pi()/180) *
                        POWER(SIN((" . $longitude . " - longitude) * pi()/180/2), 2))) as distance")
                    ->having("distance < " . $distance)
                    ->join('buildings', 'buildings.attribute_id = properties.entity_id')
                    ->join('addresses', 'addresses.attribute_id = properties.entity_id');
                    $builder->where('properties.transaction_type', "For sale");
                    $builder->where('properties.is_feature', 1);
                    $builder->limit($rowperpage,$offset);
                    $builder->distinct();
                    $properties =  $builder->get()->getResultArray();
                    foreach($properties as $key => $value)
                    {
                        $date = $value['last_updated'];
                        $date = new Carbon($date);
                        $now = Carbon::now();
                        $photo=unserialize($value['photo']);
                        $difference = ($date->diff($now)->days < 1)
                            ? 'today'
                            : $date->diffForHumans($now);
                            $data[] = array(
                                'sl' => ++$sl,
                                'id' => $value['id'],
                                'attribute_id' => $value['entity_id'],
                                'listing_id' => $value['listing_id'],
                                'price' => isset($value['price']) ? $value['price'] : "",
                                'address' => isset($value['street_address']) ?$value['street_address']  : "",
                                'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png',
                                'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "",
                                'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "",
                                'parking' => isset($value['parking'])? $value['parking'] : "",
                                'size_total' => isset($value['size_total']) ? $value['size_total'] : "",
                                'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "",
                                'distance' => $value['distance'],
                                'last_updated' => $difference,
                                // 'is_favourite' => 

                            );
                    }
                $response = [
                    'status'   => 1,
                    'data' => $data
                ];
                return $this->respondCreated($response);
             }
             else{
                $response = [
                    'status'   => -1,
                    'msg' => "Check Your Parameter"
                ];
                return $this->respondCreated($response);
             }
        }
     // Property List for Rent (Latitude & Longitude Wise)
        public function GetFeatureItems_Rent()
        {
            if ($this->request->getVar('latitude') != "" && $this->request->getVar('longitude') != "")
            {
                $pageNumber = $this->request->getVar('pageNumber') ? $this->request->getVar('pageNumber') : 1;
                $rowperpage = $this->request->getVar('rowperpage') ? $this->request->getVar('rowperpage') : 30;
                $offset = ($pageNumber - 1) * $rowperpage;
                $myModel = new CommonModel();
                $distance = $myModel->getRecord('system_option','option_slug','distance');
                $distance = $distance->option_value;
                $latitude = $this->request->getVar('latitude');
                $longitude = $this->request->getVar('longitude');
             $data = array();
             $sl = 0;
                $db = \Config\Database::connect();
                $builder = $db->table('properties');
                $builder->select("properties.last_updated,properties.entity_id,properties.id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
                properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
                buildings.bathroom_total,buildings.bedrooms_total,3956 * 2 * ASIN(SQRT(POWER(SIN((" . $latitude . " - latitude) * pi()/180/2), 2) +
                    COS(" . $latitude . " * pi()/180) * COS(latitude * pi()/180) *
                    POWER(SIN((" . $longitude . " - longitude) * pi()/180/2), 2))) as distance")
                ->having("distance < " . $distance)
                ->join('buildings', 'buildings.attribute_id = properties.entity_id')
                ->join('addresses', 'addresses.attribute_id = properties.entity_id');
                 $builder->where('properties.transaction_type', "For rent");
                 $builder->where('properties.is_feature', 1);
                 $builder->limit($rowperpage,$offset);
                 $builder->distinct();
                 $properties =  $builder->get()->getResultArray();
            foreach($properties as $key => $value)
            {
                $date = $value['last_updated'];
                $date = new Carbon($date);
                $now = Carbon::now();
                $photo=unserialize($value['photo']);
                $difference = ($date->diff($now)->days < 1)
                    ? 'today'
                    : $date->diffForHumans($now);
                    $data[] = array(
                        'sl' => ++$sl,
                        'id' => $value['id'],
                        'listing_id' => $value['listing_id'],
                        'attribute_id' => $value['entity_id'],
                        'price' => isset($value['price']) ? $value['price'] : "",
                        'address' => isset($value['street_address']) ?$value['street_address']  : "",
                        'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png',
                        'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "",
                        'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "",
                        'parking' => isset($value['parking'])? $value['parking'] : "",
                        'size_total' => isset($value['size_total']) ? $value['size_total'] : "",
                        'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "",
                        'distance' => $value['distance'],
                        'last_updated' => $difference,

                    );
            }
            $response = [
                'status'   => 1,
                'data' => $data
            ];
            return $this->respondCreated($response);
            }
            else{
            $response = [
                'status'   => -1,
                'msg' => "Check Your Parameter"
            ];
            return $this->respondCreated($response);
            }
        }
     // Property List for Construction (Latitude & Longitude Wise)
        public function GetFeatureItems_Construction() 
        {
            $PropertyModel = new PropertyModel();
            $data = array();
            if ($this->request->getVar('latitude') != "" && $this->request->getVar('longitude') != "")
            {
                $pageNumber = $this->request->getVar('pageNumber') ? $this->request->getVar('pageNumber') : 1;
                $rowperpage = $this->request->getVar('rowperpage') ? $this->request->getVar('rowperpage') : 30;
                $offset = ($pageNumber - 1) * $rowperpage;
                $myModel = new CommonModel();
                $distance = $myModel->getRecord('system_option','option_slug','distance');
                $distance = $distance->option_value;
                $latitude = $this->request->getVar('latitude');
                $longitude = $this->request->getVar('longitude');
                $properties = $PropertyModel->GetFeatureItems_Construction($latitude,$longitude,$distance,$rowperpage,$offset);
                $sl = 0;
                foreach($properties as $key => $value)
                {
                    $date = $value['last_updated'];
                    $date = new Carbon($date);
                    $now = Carbon::now();
                    $photo=unserialize($value['photo']);
                    $difference = ($date->diff($now)->days < 1)
                        ? 'today'
                        : $date->diffForHumans($now);
                        $data[] = array(
                            'sl' => ++$sl,
                            'id' => $value['id'],
                            'attribute_id' => $value['entity_id'],
                            'listing_id' => $value['listing_id'],
                            'price' => isset($value['price']) ? $value['price'] : "",
                            'address' => isset($value['street_address']) ?$value['street_address']  : "",
                            'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png',
                            'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "",
                            'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "",
                            'parking' => isset($value['parking'])? $value['parking'] : "",
                            'size_total' => isset($value['size_total']) ? $value['size_total'] : "",
                            'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "",
                            'distance' => $value['distance'],
                            'last_updated' => $difference,

                        );
                }
            $response = [
                'status'   => 1,
                'data' => $data
            ];
            return $this->respondCreated($response);
           }
            else{
                $response = [
                    'status'   => -1,
                    'data' => "Check Your Parameter"
                ];
                return $this->respondCreated($response);
            }
        }
     // Property List Search Data
        public function GetFeatureItems_Search() 
        {
            $myModel = new CommonModel();
            $distance = $myModel->getRecord('system_option','option_slug','distance');
            $distance = $distance->option_value;
            $PropertyModel = new PropertyModel();
            $pageNumber = $this->request->getVar('pageNumber') ? $this->request->getVar('pageNumber') : 1;
            $rowperpage = $this->request->getVar('rowperpage') ? $this->request->getVar('rowperpage') : 20;
            $offset = ($pageNumber - 1) * $rowperpage;
            $user_id = $this->request->getVar('user_id');
            $property_type = $this->request->getVar('type');
            $price_from = $this->request->getVar('price_from');
            $price_to = $this->request->getVar('price_to');
            $construction_style = $this->request->getVar('construction_style');
            $city = $this->request->getVar('city');
            $latitude = $this->request->getVar('latitude');
            $longitude = $this->request->getVar('longitude');
            $province = $this->request->getVar('province');
            $properties = $PropertyModel->Items_Search($property_type,$price_from,$price_to,$construction_style,$city,$province,$latitude,$longitude,$rowperpage,$offset);
            $sl = 0;
            $data = array();
            foreach($properties as $key => $value)
            {
                // $Address = unserialize($value['address']);
                $photo = unserialize($value['photo']);
                // $Buildings = unserialize($value['buildings']);
                $Land = unserialize($value['land']);
                    if($user_id)
                    {
                        $array = ['user_id' => $user_id, 'listing_id' => $value['listing_id']];
                        $fav = $myModel->getRecordArray('favourites',$array);
                    }
                    $data[] = array(
                        'sl' => ++$sl,
                        'id' => $value['id'],
                        'listing_id' => $value['listing_id'],
                        'attribute_id' => $value['attribute_id'],
                        'price' => isset($value['price']) ? $value['price'] : "",
                        'address' => isset($value['street_address']) ?$value['street_address']  : "",
                         'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png' ,
                        'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "",
                        'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "",
                        'parking' => isset($value['parking'])? $value['parking'] : "",
                        'size_total' => isset($value['size_total']) ? $value['size_total'] : "",
                        'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "",
                        'latitude' => isset($value['latitude']) ? $value['latitude'] : "",
                        'longitude' => isset($value['longitude']) ? $value['longitude'] : "",
                        'react' => isset($fav) ? $fav['react'] : 0,
                        'status' => $value['transaction_type'],
                        'isactive' => $value['status']
                    );
            }
            $response = [
                'status'   => 1,
                'data' => $data
            ];
            return $this->respondCreated($response);
        }
        // Get City API
        public function getCities()
        {
            $model = new CityModel();
            $data = $model->select('id,name,latitude,longitude,is_featured,status')->where('is_featured', 1)->where('status', 1)->orderBy('id', 'ASC')->findAll();
            $myModel = new CommonModel();
            $min_range = $myModel->getRecord('system_option','option_slug','price_min_value');
            $min_range = $min_range->option_value;
            $max_range = $myModel->getRecord('system_option','option_slug','price_max_value');
            $max_range = $max_range->option_value;
            $response = [
                'status'   => 1,
                'data' => $data,
                'min_price'   => $min_range,
                'max_price'   => $max_range,
            ];
            return $this->respondCreated($response);
        }
        // Get Slider API
        public function getSliders()
        {
            $promotion_data = array();
            $model = new SliderModel();
            $data = $model->select('id,image,status')->where('status', 1)->orderBy('id', 'ASC')->findAll();
            foreach ($data as $key => $value) {
                    $promotion_data[$key]['id'] = $value['id'];
                    $promotion_data[$key]['status'] = $value['status'];
                    $promotion_data[$key]['image'] = base_url().'uploads/slider/'.$value['image'];
            }
            $response = [
                'status'   => 1,
                'data' => $promotion_data
            ];
            return $this->respondCreated($response);
        }
         // Get Brand API
         public function getBrands()
         {
             $brand_data = array();
             $Brand = new BrandModel();
             $conditions = array();
             $data = $Brand->getRecord($conditions);
             foreach ($data as $key => $value) {
                     $brand_data[$key]['id'] = $value['id'];
                     $brand_data[$key]['name'] = $value['name'];
                     $brand_data[$key]['url'] = $value['url'];
                     $brand_data[$key]['image'] = base_url().'uploads/brand/'.$value['logo'];
                     $brand_data[$key]['status'] = $value['status'];
             }
             $response = [
                 'status'   => 1,
                 'data' => $brand_data
             ];
             return $this->respondCreated($response);
         }
        // Get Property Details API
       public function getPropertyDetails()
        {
         if($this->request->getVar('listing_id')){
            $listing_id = $this->request->getVar('listing_id');
            $Property = new PropertyModel();
            // $data = array();
            $property_details = $Property->getPropertyDetails($listing_id);
          
            foreach($property_details as $key => $value)
            {
                
                // $data['attribute_id'] = $property_details['entity_id'];
                // $data['listing_id'] = $property_details['listing_id'];
                // $data['bedrooms_total'] = $property_details['bedrooms_total'];
                // $data['bathroom_total'] = $property_details['bathroom_total'];
                // $data['parking'] = $property_details['parking'];
                // $data['street_address'] = $property_details['street_address'];
                // $data['price'] = $property_details['price'];
                $property_details[$key]['photo'] = unserialize($value['photo']);
                // $data['size_total'] = $property_details['size_total'];
                // $data['size_total_text'] = $property_details['size_total_text'];
                // $data['status'] = $property_details['status'];
                }
            $response = [
                'status'   => 1,
                'data' => count($property_details) > 1 ? $property_details : $property_details[0]
            ];
            return $this->respondCreated($response);
             }
            else{
                $response = [
                    'status'   => -1,
                    'data' => "Check Your Parameter"
                ];
                return $this->respondCreated($response);
            }
            
        }
        // Property List Search Data Lite Version
        public function GetFeatureItems_Search_lite() 
        {
            $PropertyModel = new PropertyModel();
            $UserID = $this->request->getVar('UserID');
            $property_type = $this->request->getVar('type');
            $price_from = $this->request->getVar('price_from');
            $price_to = $this->request->getVar('price_to');
            $construction_style = $this->request->getVar('construction_style');
            $city = $this->request->getVar('city');
            $latitude = $this->request->getVar('latitude');
            $longitude = $this->request->getVar('longitude');
            $province = $this->request->getVar('province');
            // Save The Search History of a User
                $SearchHistoryModel = new UserSearchHistory();
                $count = $SearchHistoryModel->where('user_id', $UserID)->countAllResults();
                $data = [
                    'user_id' => $UserID,
                    'type' => $property_type ? serialize($property_type) : "",
                    'price_from' => $price_from,
                    'price_to' => $price_to,
                    'construction_style' => $construction_style ? serialize($construction_style) : "",
                    'city' => $city,
                    'province' => $province,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if($count == 3)
                {
                    $firstEntry = $SearchHistoryModel
                            ->where('user_id', $UserID)
                            ->first('array');
                    $SearchHistoryModel->updateRecord($firstEntry['id'],$data);
                }
                else{
                   $SearchHistoryModel->addRecord($data);
                }
               
            $properties = $PropertyModel->Items_Search_Lite($property_type,$price_from,$price_to,$construction_style,$city,$province,$latitude,$longitude);
            $sl = 0;
            $data = array();
            foreach($properties as $key => $value)
            {
                $data[] = array(
                    'sl' => ++$sl,
                    'listing_id' => $value['listing_id'],
                    'attribute_id' => $value['entity_id'],
                    'latitude' => isset($value['latitude']) ? $value['latitude'] : "",
                    'longitude' => isset($value['longitude']) ? $value['longitude'] : "",
                );
            }
            $response = [
                'status'   => 1,
                'data' => $data
            ];
            return $this->respondCreated($response);
        }
         // Get Property Details description API
         public function getPropertyDescription()
         {
             $user_id = $this->request->getVar('user_id');
          if($this->request->getVar('listing_id') != ""){
             $listing_id = $this->request->getVar('listing_id');
             $attribute_id = $this->request->getVar('attribute_id');
             $Property = new PropertyModel();
             $property_details = $Property->getPropertyDescription($listing_id); 
                if($property_details)
                {
                    if(!($property_details['tax_annual_amount']))
                    {
                        $url = 'https://identity.crea.ca/connect/token';
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
                            'grant_type' => "client_credentials",
                            'client_id' => "twJ1BuSczeGuur8PQnRRUkVg",
                            'client_secret' => "aYbG4piQVdsJuYC2XqCiTcfm",
                            'scope' => "DDFApi_Read"
                        ]));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        if ($response === false) {
                            $error = curl_error($curl);
                        } else {
                            curl_close($curl);
                            $token = json_decode($response)->access_token;
                        }

                        $url = 'https://ddfapi.realtor.ca/odata/v1/Property/'.$attribute_id;
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $token
                        ]);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        if ($response === false) {
                            $error = curl_error($curl);
                            // Handle the error accordingly
                        } else {
                            curl_close($curl);
                            $ddata = json_decode($response);    
                        }
                        $property_details['tax_annual_amount'] = $ddata->TaxAnnualAmount ? $ddata->TaxAnnualAmount : null;
                        $property_details['lot_size_area'] = $ddata->LotSizeArea ? $ddata->LotSizeArea : null;
                    }
                    $date = new Carbon($property_details['last_updated']);
                    $now = Carbon::now();
                    $difference = ($date->diff($now)->days < 1)
                        ? 'today'
                        : $date->diffForHumans($now);
                    $property_details['last_updated'] = $difference;
                    $property_details['land']=unserialize($property_details['land']);
                    $property_details['rooms']=unserialize($property_details['rooms']);
                    $property_details['photo']=unserialize($property_details['photo']);
                    $property_details['agent_details']=unserialize($property_details['agent_details']);
                    $favourites = array();
                    if($user_id)
                    {
                        $myModel = new CommonModel();
                        $array = ['user_id' => $user_id, 'listing_id' => $listing_id];
                        $favourites = $myModel->getRecordArray('favourites',$array);
                       
                    }
                     $property_details['react'] = ($user_id != '') ? $favourites['react'] : 0;
                
                    $response = [
                        'status'   => 1,
                        'data' => $property_details
                    ];
                    return $this->respondCreated($response);
                }
                else{
                    $response = [
                        'status'   => -1,
                        'data' => "Listind ID doesnt exist"
                    ];
                    return $this->respondCreated($response);
                }
            
              }
             else{
                 $response = [
                     'status'   => -1,
                     'data' => "Check Your Parameter"
                 ];
                 return $this->respondCreated($response);
             }
             
         }
         // User Latest Search Property
        public function getLatestSearch() 
        {
            $UserID = $this->request->getVar('UserID');
            $SearchHistoryModel = new UserSearchHistory();
            $latestSearches = $SearchHistoryModel
            ->where('user_id', $UserID)
            ->findAll();
            if($latestSearches)
            {
                $response = [
                    'status'   => 1,
                    'data' => $latestSearches
                ];
            }
            else{
                $response = [
                    'status'   => -1,
                    'data' => 'No Search History!'
                ];
            }
           
            return $this->respondCreated($response);
        }
        // Property For Sale Add
        public function insertSaleProperty() 
        {
            $image = $this->request->getFile('image');
            if ($image->isValid() && !$image->hasMoved())
            {
                $timestamp = date('YmdHis'); // Get the current timestamp
                $directory = './uploads/sale_property'; // Specify the directory path with timestamp
                $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
                // Create the directory if it doesn't exist
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
                }
                $image->move($directory, $newName);
            }
                // Save the image data to the database
                $Property = new SaleProperty();
                $data = [
                'user_id' => $this->request->getVar('UserID'),
                'property_type' => $this->request->getVar('property_type'),
                'unit' => $this->request->getVar('unit'),
                'bedrooms' => $this->request->getVar('bedrooms'),
                'washrooms' => $this->request->getVar('washrooms'),
                'parkings' => $this->request->getVar('parkings'),
                'property_type' => $this->request->getVar('property_type'),
                'size' => $this->request->getVar('size'),
                'street_address' => $this->request->getVar('street_address'),
                'city' => $this->request->getVar('city'),
                'province' => $this->request->getVar('province'),
                'postal_code' => $this->request->getVar('postal_code'),
                'purchase_year' => $this->request->getVar('purchase_year'),
                'price' => $this->request->getVar('price'),
                'photo' =>  $newName,
                'status'  => 1
                ];
                $status = $Property->addRecord($data);
                if($status)
                {
                    $response = [
                        'status'   => 1,
                        'data' => 'Sale Property Added Successfully !'
                    ];
                }
                else{
                    $response = [
                        'status'   => -1,
                        'data' => 'Property Insertion Failed'
                    ];
                }
                return $this->respondCreated($response);
        }
         // Property For Rent Add
         public function insertRentProperty() 
         {
             $image = $this->request->getFile('image');
             if ($image->isValid() && !$image->hasMoved())
             {
                 $timestamp = date('YmdHis'); // Get the current timestamp
                 $directory = './uploads/rent_property'; // Specify the directory path with timestamp
                 $newName = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
                 // Create the directory if it doesn't exist
                 if (!file_exists($directory)) {
                     mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
                 }
                 $image->move($directory, $newName);
             }
                 // Save the image data to the database
                 $Property = new RentProperty();
                 $data = [
                 'user_id' => $this->request->getVar('UserID'),
                 'property_type' => $this->request->getVar('property_type'),
                 'unit' => $this->request->getVar('unit'),
                 'bedrooms' => $this->request->getVar('bedrooms'),
                 'washrooms' => $this->request->getVar('washrooms'),
                 'parkings' => $this->request->getVar('parkings'),
                 'property_type' => $this->request->getVar('property_type'),
                 'size' => $this->request->getVar('size'),
                 'street_address' => $this->request->getVar('street_address'),
                 'city' => $this->request->getVar('city'),
                 'province' => $this->request->getVar('province'),
                 'postal_code' => $this->request->getVar('postal_code'),
                 'purchase_year' => $this->request->getVar('purchase_year'),
                 'price' => $this->request->getVar('price'),
                 'photo' =>  $newName,
                 'status'  => 1
                 ];
                 $status = $Property->addRecord($data);
                 if($status)
                 {
                     $response = [
                         'status'   => 1,
                         'data' => 'Rent Property Added Successfully !'
                     ];
                 }
                 else{
                     $response = [
                         'status'   => -1,
                         'data' => 'Property Insertion Failed'
                     ];
                 }
                 return $this->respondCreated($response);
         }
         // Registration Mortgage Account
         public function insertMortgageProfile() 
         {
                 $Mortgage = new MortgageProfile();
                 $conditions = [
                    'user_id' => $this->request->getVar('UserID')
                 ];
                 $mortgage_data = $Mortgage->getSingleRow($conditions);
                 $data = [
                 'user_id' => $this->request->getVar('UserID'),
                 'home_buyer' => $this->request->getVar('home_buyer'),
                 'family_income' => $this->request->getVar('family_income'),
                 'credit_score' => $this->request->getVar('credit_score'),
                 'heating_cost' => $this->request->getVar('heating_cost'),
                 'monthly_installment' => $this->request->getVar('monthly_installment'),
                 'total_balance' => $this->request->getVar('total_balance'),
                 'qualification_rate' => $this->request->getVar('qualification_rate'),
                 'status'  => 1,
                 'created_at'  =>  date('Y-m-d H:i:s')

                 ];
                 if($mortgage_data)
                 {
                    
                    $status = $Mortgage->updateRecord($mortgage_data['id'],$data);
                            if($status)
                            {
                                $response = [
                                    'status'   => 1,
                                    'data' => 'Mortgage Account Updated Successfully !'
                                ];
                            }
                        else{
                            $response = [
                                'status'   => -1,
                                'data' => 'Account Update Failed'
                            ];
                        }
                 }
                 else{
                    $status = $Mortgage->addRecord($data);
                    if($status)
                        {
                            $response = [
                                'status'   => 1,
                                'data' => 'Mortgage Account Successfully !'
                            ];
                        }
                    else{
                        $response = [
                            'status'   => -1,
                            'data' => 'Account Creation Failed'
                        ];
                    }

                 }
                 
                 return $this->respondCreated($response);
         }

         // Mortgage Calculation
         public function gds_tds_Calculation() 
         {
                 $Mortgage = new MortgageProfile();
                 $user_id = $this->request->getVar('UserID');
                 $mortgage_amount = $this->request->getVar('mortgage_amount');
                 $tax = $this->request->getVar('tax') / 12;
                 $maintenance_fee = $this->request->getVar('maintenance_fee');
                 $conditions = [
                    'user_id' => $user_id
                 ];
                 $mortgage_data = $Mortgage->getSingleRow($conditions);
                 if($mortgage_data){
                    $Model = new CommonModel();
                    $gds = $Model->getRecord('system_option','option_slug','gds')->option_value;
                    $tds = $Model->getRecord('system_option','option_slug','tds')->option_value;
                    $heating_cost = $mortgage_data['heating_cost'];
                    $family_income = $mortgage_data['family_income'];
                    $monthly_installment = $mortgage_data['monthly_installment'];
                    $total_balance = $mortgage_data['total_balance'] * 0.03;
                    $gds_total = (($mortgage_amount + $tax + ($maintenance_fee * 0.5) + $heating_cost) / ($family_income / 12))*100;
                    $tds_total = (($mortgage_amount + $tax + ($maintenance_fee * 0.5) + $heating_cost + $monthly_installment + $total_balance) /  ($family_income / 12))*100;
                    $data = [
                        'gds' => number_format((float)$gds_total, 2, '.', ''),
                        'tds' => number_format((float)$tds_total, 2, '.', ''),
                        'gds_standard' => $gds,
                        'tds_standard' => $tds,
                        'status' => ($gds_total <= $gds && $tds_total <= $tds) ? 1 : 0
                    ];
                        $response = [
                            'status'   => 1,
                            'data' => $data ,
                        ];
                 }
                 else{
                     $response = [
                         'status'   => -1,
                         'data' => 'Account Not Found'
                     ];
                 }
                 return $this->respondCreated($response);
         }
         
          // Schedule Tour
          public function addScheduleTour() 
          {
                  $Tour = new TourModel();
                  $data = [
                  'user_id' => $this->request->getVar('UserID'),
                  'listing_id' => $this->request->getVar('listing_id'),
                  'schedule' => serialize($this->request->getVar('schedule')),
                  'status'  => 1,
 
                  ];
                  $Tour_ID = $Tour->addRecord($data);
                  foreach ($this->request->getVar('schedule') as $key => $value) {
                    if (!empty($value)) {

                        $add_data[] = array(
                            'tour_id' => $Tour_ID,
                            'date' => $value->date,
                            'shift' => $value->shift,
                            'status' => 1,
                            'created_at'=> Carbon::now()
                        );
                    }
                }
               
                $Tour->addBatchRecord($add_data,'tour_schedule_map');
                  if($Tour_ID)
                  {
                      $response = [
                          'status'   => 1,
                          'data' => 'Your Schedule Request is submitted, we will contact you soon !'
                      ];
                  }
                  else{
                      $response = [
                          'status'   => -1,
                          'data' => 'Tour Scheduled Failed'
                      ];
                  }
                  return $this->respondCreated($response);
          }

          // Get Similler Listing
          public function getSimillerListing()
          {
              $price = $this->request->getVar('price');
              $city = $this->request->getVar('city');
              $type = $this->request->getVar('type');
              $Property = new PropertyModel();
              $Similler_Listing = $Property->getSimillerListing($price,$city,$type);
              if($Similler_Listing)
              {
                  foreach($Similler_Listing as $key => $listing)
                {
                    $Similler_Listing[$key]['photo']=unserialize($listing['photo']);
                } 
                  $response = [
                        'status'   => 1,
                        'data' => $Similler_Listing,
                    ];
              }
              else{
                  $response = [
                    'status'   => 0,
                    'data' => null,
                ];
              }
                
                return $this->respondCreated($response);
          }
          // Get Feature Listing
          public function getFeaturesItems()
          {
              $Property = new PropertyModel();
              $Similler_Listing = $Property->getFeaturesItems();
              if($Similler_Listing)
              {
                  foreach($Similler_Listing as $key => $listing)
                {
                    $Similler_Listing[$key]['photo']=unserialize($listing['photo']);
                } 
                  $response = [
                        'status'   => 1,
                        'data' => $Similler_Listing,
                    ];
              }
              else{
                  $response = [
                    'status'   => 0,
                    'data' => null,
                ];
              }
                
                return $this->respondCreated($response);
          }
            public function getNotifications()
            {
                $user_id = $this->request->getVar('user_id');

                  if ($user_id) {
                    $Notification = new NotificationModel();
                    $all_notifications = $Notification->getNotifications($user_id);
                    // echo "<pre>";
                    // print_r($all_notifications);
                    // exit();
                    foreach ($all_notifications as $k => $v) {
                        $all_notifications[$k]['image'] =  $all_notifications[$k]['image'] ?  base_url() . "uploads/notification/" . $all_notifications[$k]['image'] : base_url().'assets/images/favicon.png';
                    }
                    $data['notifications'] = $all_notifications;
                    $data['count'] = count($all_notifications);
                    if ($data) {
                        $response = [
                            'notifications' => $data['notifications'],
                            'notificaion_count' => $data['count'],
                            'status' => 1,
                            'message' => "Data Found"
                        ];// OK (200) being the HTTP response code
                    } else {
                        $response = [

                            'status' => -1,
                            'message' => "Data not found"
                        ]; // NOT_FOUND (404) being the HTTP response code
                    }
                    } else {
                        $response = [
                            'status' => 0,
                            'message' => "Check your parameter"
                        ]; // NOT_FOUND (404) being the HTTP response code
                    }
                 return $this->respondCreated($response);
            }
            // Add Favourite Listing
          public function addFavourite() 
          {
            if($this->request->getVar('user_id') && $this->request->getVar('listing_id')){
                  $Common = new CommonModel();
                  $array = ['user_id' => $this->request->getVar('user_id'), 'listing_id' => $this->request->getVar('listing_id')];
                  $records = $Common->getRecordArray('favourites',$array);
                  if(!($records))
                  {
                    $data = [
                        'user_id' => $this->request->getVar('user_id'),
                        'listing_id' => $this->request->getVar('listing_id'),
                        'react' => 1,
                        ];
                    $Common->addRecord('favourites',$data);
                    $response = [
                        'status'   => 1,
                        'react' => 1,
                        'data' => 'Property Added to Favourites !'
                    ];
                  }
                  else{

                    $data = [
                        'react' => ($records['react'] == 0) ? 1: 0,
                        ];
                        
                        $Common->updateRecord('favourites',$data,['user_id' => $this->request->getVar('user_id'),'listing_id' => $this->request->getVar('listing_id')]);
                        $response = [
                            'status'   => 1,
                            'react' => ($records['react'] == 0) ? 1: 0,
                            'data' => $records['react'] == 0 ? 'Propert added to favourites !' : 'Property removed from favourites !'
                        ];
                    }
                }
                  else{
                      $response = [
                          'status'   => -1,
                          'data' => 'Check Your Parameter!'
                      ];
                  }
                  return $this->respondCreated($response);
          }
          // User Get Favourites Property
        public function getFavourites() 
        {
            $user_id = $this->request->getVar('user_id');
            if(!($user_id))
            {
                 $response = [
                            'status' => -1,
                            'message' => "Check your parameter"
                        ];
            }
            else{
                 $Common = new CommonModel();
            $favouriteItems = $Common->getFavourites($user_id);
            foreach($favouriteItems as $key => $value)
            {
                $photos = unserialize($value['photo']);
                $favouriteItems[$key]['photo'] = $photos['0'];
            }
            
            if($favouriteItems)
            {
                $response = [
                    'status'   => 1,
                    'data' => $favouriteItems
                ];
            }
            else{
                $response = [
                    'status'   => 0,
                    'data' => $favouriteItems
                ];
            }
            }
           
           
            return $this->respondCreated($response);
        }
        public function getPropertyFilter() 
        {
            if($this->request->getVar('city') != '')
            {
                $PropertyModel = new PropertyModel();
            $property_type = $this->request->getVar('type');
            $price_from = $this->request->getVar('price_from');
            $price_to = $this->request->getVar('price_to');
            $construction_style = $this->request->getVar('construction_style');
            $city = $this->request->getVar('city');
            $bedrooms = $this->request->getVar('bedrooms');
            $bathrooms = $this->request->getVar('bathrooms');
            $parkings = $this->request->getVar('parkings');
            $properties = $PropertyModel->getPropertyFilter($property_type,$price_from,$price_to,$construction_style,$city,$bedrooms,$bathrooms,$parkings);
            $sl = 0;
            $data = array();
            foreach($properties as $key => $value)
                {
                    $photo = unserialize($value['photo']);
                        $data[] = array(
                            'sl' => ++$sl,
                            'id' => $value['id'],
                            'listing_id' => $value['listing_id'],
                            'attribute_id' => $value['attribute_id'],
                            'price' => isset($value['price']) ? $value['price'] : "",
                            'address' => isset($value['street_address']) ?$value['street_address']  : "",
                             'photo' => isset($photo[0]) ? $photo[0] : base_url().'assets/images/favicon.png' ,
                            'bathrooms' => isset($value['bathroom_total']) ? $value['bathroom_total'] : "",
                            'bedrooms' => isset($value['bedrooms_total']) ? $value['bedrooms_total'] : "",
                            'parking' => isset($value['parking'])? $value['parking'] : "",
                            'size_total' => isset($value['size_total']) ? $value['size_total'] : "",
                            'size_total_text' => isset($value['size_total_text']) ? $value['size_total_text'] : "",
                            'latitude' => isset($value['latitude']) ? $value['latitude'] : "",
                            'longitude' => isset($value['longitude']) ? $value['longitude'] : "",
                            'status' => $value['status']
                    
                        );
                }
             $response = [
                'status'   => 1,
                'data' => $data
            ];
            }
            else{
                 $response = [
                'status'   => -1,
                'data' => "Check Your Parameter!"
            ];
            }
            
           
            return $this->respondCreated($response);
        }
        // Add Favourite Listing
          public function contactUs() 
          {
              $Common = new CommonModel();
                    $data = [
                        'name' => $this->request->getVar('name'),
                        'property_type' => $this->request->getVar('property_type'),
                        'area' => $this->request->getVar('area'),
                        'budget' => $this->request->getVar('budget'),
                        'message' => $this->request->getVar('message'),
                        ];
                     $ID = $Common->addRecord('contact_us',$data);
        
                    if($ID)
                    {
                        $response = [
                        'status'   => 1,
                        'data' => 'Thanks for Contact with us !'
                       ];
                    }
                    
                  else{
                      $response = [
                          'status'   => -1,
                          'data' => 'Check Your Parameter!'
                      ];
                  }
                  return $this->respondCreated($response);
          }
          // About Us Api
          public function getAboutUs()
          {
              $myModel = new CommonModel();
              $data = $myModel->getRecord('system_option','option_slug','about_us')->option_value;
              if($data)
              {
                $response = [
                    'status'   => 1,
                    'data' => $data,
                ];
              }
              else{
                $response = [
                    'status'   => 0,
                    'data' => "No Data Found!",
                ];
              }
              return $this->respondCreated($response);
          }
          // Privacy Policy Api
          public function getPrivacyPolicy()
          {
              $myModel = new CommonModel();
              $data = $myModel->getRecord('system_option','option_slug','privacy_policy')->option_value;
              if($data)
              {
                $response = [
                    'status'   => 1,
                    'data' => $data,
                ];
              }
              else{
                $response = [
                    'status'   => 0,
                    'data' => "No Data Found!",
                ];
              }
              return $this->respondCreated($response);
          }
          // Terms & Condition Api
          public function getTermsCondition()
          {
              $myModel = new CommonModel();
              $data = $myModel->getRecord('system_option','option_slug','terms_condition')->option_value;
              if($data)
              {
                $response = [
                    'status'   => 1,
                    'data' => $data,
                ];
              }
              else{
                $response = [
                    'status'   => 0,
                    'data' => "No Data Found!",
                ];
              }
              return $this->respondCreated($response);
          }
          // Contact Us Api
          public function getContactUs()
          {
              $myModel = new CommonModel();
              $data = $myModel->getRecord('system_option','option_slug','contact_us')->option_value;
              $latitude = $myModel->getRecord('system_option','option_slug','latitude')->option_value;
              $longitude = $myModel->getRecord('system_option','option_slug','longitude')->option_value;
              if($data)
              {
                $response = [
                    'status'   => 1,
                    'data' => $data,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                ];
              }
              else{
                $response = [
                    'status'   => 0,
                    'data' => $data,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                ];
              }
              return $this->respondCreated($response);
          }
          // Get Profile Data Api
          public function getProfileData()
                {
                    $User = new UserModel();
                    if ($this->request->getVar('user_id') != "")
                    {
                        $user_id = $this->request->getVar('user_id');
                            $conditions = [
                                'id' => $user_id,
                            ];
                            $UserData =$User->getSingleRow($conditions);
                                if(($UserData))
                                {
                                    $data = [
                                        'email' => $UserData['email'],
                                        'dob'  => $UserData['dob'],
                                        'gender'  => $UserData['gender'],
                                        'image' =>  $UserData['image'] ?  base_url() . "uploads/user/" . $UserData['image'] : base_url().'assets/images/human.png',
                                        'language'  => unserialize($UserData['language_slug']),
                                        'mobile' => $UserData['mobile'],
                                        'unit'  => $UserData['unit'],
                                        'street_address' => $UserData['street_address'],
                                        'city'  => $UserData['city'],
                                        'province'  => $UserData['province'],
                                    ];
                                        $response = [
                                            'status'   => 1,
                                            'data' => $data,
                                            'message' => 'Data Found !',
                                        ];
                                }
                                else
                                    {
                                            $response = [
                                            'status'   => 0,
                                            'message' => 'User Doesnt Exist !',
                                        ]; 
                                    }  
                    } 
                    else
                    {
                        $response = [
                            'status'   => -1,
                            'message' => 'Check Your Parameter !'

                        ];
                        
                    }      
                        return $this->respondCreated($response);
            }
            // User Update Profile Data APi
        public function updateProfileData()
        {
            $User = new UserModel();
            $UserID = $this->request->getVar('user_id');
            $Email = $this->request->getVar('email');
            $Dob = $this->request->getVar('dob');
            $Mobile = $this->request->getVar('mobile');
            $Street_Address = $this->request->getVar('street_address');
            $Gender = $this->request->getVar('gender');
            $Language = $this->request->getVar('language');
            $Unit = $this->request->getVar('unit');
            $City = $this->request->getVar('city');
            $Postal_Code = $this->request->getVar('postal_code');
            $Province = $this->request->getVar('province');
            if (!$UserID) 
            {
                
                $response = [
                    'status'   => -1,
                    'message' => 'Invalid Parameter'
                ];
                return $this->respondCreated($response);
            }
            else{
                $image = $this->request->getFile('image');
             if ($image->isValid() && !$image->hasMoved())
             {
                 $timestamp = date('YmdHis'); // Get the current timestamp
                 $directory = './uploads/user'; // Specify the directory path with timestamp
                 $Imagename = $timestamp . '_' . $image->getName(); // Concatenate timestamp with the original file name
                 // Create the directory if it doesn't exist
                 if (!file_exists($directory)) {
                     mkdir($directory, 0777, true); // Specify the directory permissions (e.g., 0777) as needed
                 }
                 $image->move($directory, $Imagename);
             }
                $data = [
                    'email'		=> $Email,
                    'gender'		=> $Gender,
                    'dob'		=> $Dob,
                    'street_address'		=> $Street_Address,
                    'unit'		=> $Unit,
                    'postal_code'		=> $Postal_Code,
                    'city'		=> $City,
                    'mobile'		=> $Mobile,
                    'province'		=> $Province,
                    'language_slug'		=> serialize($Language),
                    'image' => $Imagename
                ];    
                    if ($User->updateRecord($UserID, $data)) {
                        $response = [
                            'status'   => 1,
                            'message' => 'Successfully updated'
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
        }
          
}
