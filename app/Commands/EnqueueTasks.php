<?php



use App\Models\AddressModel;
use App\Models\BuildingModel;
use App\Models\PropertyModel;
use Carbon\Carbon;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use GuzzleHttp\Client;

use GuzzleHttp\Promise\Utils;
set_time_limit(0);

class EnqueueTasks extends BaseCommand
{

    protected $group = 'custom';
    protected $name = 'enqueue-tasks';
    protected $description = 'Enqueues tasks for parallel processing';
    protected $batchSize = 1000;


    public function run(array $params)
    {
        $PropertyModel = new PropertyModel();

        $cookies = $this->digestAuth();
        $finalcookies = "";
        foreach ($cookies as $cookie)
        {
            $value = strtok($cookie, ';');
            $finalcookies .= $value .";";
        }

        $cookie = rtrim($finalcookies,";");
        $cookies = $cookie;



        // Fetch data from API and process in batches
        $TotalRecords=$this->getTotalRecords($PropertyModel, $cookies);
        //$TotalRecords=20000;
        $this->fetchAndProcessData($PropertyModel, $cookies, $TotalRecords);

        CLI::write('All tasks enqueued!', 'green');

    }
    protected function digestAuth()
    {
        $cookies = array();
        $url = 'https://data.crea.ca/Login.svc/Login'; // Replace with your target URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "");

        // Set the CURLOPT_HEADERFUNCTION callback to extract the cookies
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($curl, $header) use (&$cookies) {
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

//        $response = [
//            'status'   => 1,
//            'cookies' => $cookies
//        ];
        return $cookies;
        //return $cookies;
    }
    protected function fetchToken(){
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
        $token = json_decode($response)->access_token;
        return $token;
    }
    protected function getTotalRecords($PropertyModel,$cookies){
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

        $TotalRecords = $array['RETS-RESPONSE']['Pagination']['TotalRecords'];
//        $TotalRecords = 2000;

        return $TotalRecords;
    }


    protected function fetchAndProcessData($PropertyModel, $cookies, $TotalRecords)
    {

        $batches = ceil($TotalRecords / $this->batchSize);
        CLI::write("Total Record {$TotalRecords}");
        CLI::write("Total Batch {$batches}");

        $maxConcurrentRequests = 20; // Set the maximum number of concurrent requests
        $delayMicroseconds = 1000; // Set the delay in microseconds (1 second)
        $multiHandle = curl_multi_init();
        $handles = [];
        $batchData=[];

        $batchCounter = 1;
        $active = 0;

        for ($batch = 1; $batch <= $batches; $batch++) {
            $end = min($batch * $this->batchSize, $TotalRecords);

            CLI::write("Processing batch {$batch}...");

            $latest = $PropertyModel->orderBy('id', 'DESC')->first();
            $i = $latest ? $latest['id'] + 1 : 1;
            $token = $this->fetchToken();
            CLI::write("Fetching token for {$batch}...","blue");

            do {
                if (count($handles) < $maxConcurrentRequests) {
                    $handle = curl_init();
                    $url = 'https://data.crea.ca/Search.svc/Search?SearchType=Property&Class=Property&QueryType=DMQL2&Format=STANDARD-XML&ID=*&Offset=' . $i . '&Query=(LastUpdated=2023-01-01T22:00:17Z)';
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_COOKIE, $cookies);
                    curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
                    curl_setopt($handle, CURLOPT_USERPWD, 'twJ1BuSczeGuur8PQnRRUkVg:aYbG4piQVdsJuYC2XqCiTcfm'); // Replace with your username and password
                    curl_setopt($handle, CURLOPT_HEADER, true); // Include headers in the response
                 //   curl_setopt($handle, CURLOPT_VERBOSE, true);
                    curl_multi_add_handle($multiHandle, $handle);

                    $handles[$i] = ['handle' => $handle, 'batch' => $batch,'token'=>$token];
                    $active++;
                }

                $i += 100;
            } while ($i <= $end);

            if ($active >= $maxConcurrentRequests || $batch == $batches) {
                // Wait for the batch to complete before starting the next batch
                do {
                    $status = curl_multi_exec($multiHandle, $active);
                } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

                // Process responses and remove handles
                foreach ($handles as $i => $handleData) {
                    $handle = $handleData['handle'];
                    $batch = $handleData['batch'];
                    $tok = $handleData['token'];


                    $response = curl_multi_getcontent($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                    if ($httpCode === 200) {
                        CLI::write("Response for batch {$batch}:", 'green');
                        $batchData = array_merge($batchData, $this->extractPropertyDetails($response)); // Merge the new data with existing batchData



                        if (count($batchData) >= $this->batchSize) {
                            // Call the processResponseAsync function with accumulated data
                            $this->processResponseAsync($batchData, $PropertyModel, $batch, $tok);

                            // Clear the batch data array
                            $batchData = [];

                            //CLI::write("Inserted records for Batch: {$batchCounter}", 'green');
                            $batchCounter++;
                        }
                    } else {
                        CLI::write("Error in batch {$batch}, HTTP code: {$httpCode}", 'red');
                        CLI::write("Error response content: {$response}", 'red'); // Print the response content on error
                    }

                    curl_multi_remove_handle($multiHandle, $handle);
                    curl_close($handle);
                }

                $handles = [];
                $active = 0;
                $batchCounter++;

                if ($batchCounter <= $batches) {
                    CLI::write("Waiting for a delay of {$delayMicroseconds} microseconds before starting the next batch...");
                    usleep($delayMicroseconds);
                }
            }
        }

        curl_multi_close($multiHandle);
    }

    protected function processResponseAsync($PropertyDetails, $PropertyModel,$batch,$token)
    {

        $this->writeJsonToFile('properties.json', $PropertyDetails);

        CLI::write(count($PropertyDetails), 'green');


        $data = [];
        $address_data = [];
        $building_data = [];
        $propertyData = [];
        $multiHandle = curl_multi_init();
        $handles = [];
        foreach ($PropertyDetails as $Property) {
            if (isset($Property['@attributes']['ID'])) {
                $propertyId = $Property['@attributes']['ID'];
                // Prepare cURL handle for parallel fetching
                $curlHandle = $this->preparePropertyDataRequest($token,$propertyId);
                $handles[$propertyId] = $curlHandle;
                // Add cURL handle to multi-handle
                curl_multi_add_handle($multiHandle, $curlHandle);
            }

            // ... Rest of your loop code ...
        }

        do {
            curl_multi_exec($multiHandle, $running);
        } while ($running > 0);

        foreach ($handles as $propertyId => $curlHandle) {
            $response = curl_multi_getcontent($curlHandle);
            $ddata = json_decode($response);

            $propertyData[$propertyId] = [
                'tax_annual_amount' => isset($ddata->TaxAnnualAmount) ? $ddata->TaxAnnualAmount : "",
                'lot_size_area' => isset($ddata->LotSizeArea) ? $ddata->LotSizeArea : ""
            ];

            curl_multi_remove_handle($multiHandle, $curlHandle);
            curl_close($curlHandle);
        }
        curl_multi_close($multiHandle);

        foreach ($PropertyDetails as $Property) {
            $photo = [];
            if (isset($Property['Photo']['PropertyPhoto'])) {
                for ($i = 0; $i < 4; $i++) {
                    $photo[$i] = isset($Property['Photo']['PropertyPhoto'][$i]['PhotoURL']) ? $Property['Photo']['PropertyPhoto'][$i]['PhotoURL'] : "";
                }
            }
            $date = Carbon::parse($Property['@attributes']['LastUpdated']);

            $datework = $date->format('Y-m-d H:i:s');

            $propertyId = $Property['@attributes']['ID'];
            $propertyInfo = $propertyData[$propertyId];

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


            $data []= array(
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
                'tax_annual_amount' => isset($propertyInfo['tax_annual_amount']) ? $propertyInfo['tax_annual_amount'] : 0,
                'lot_size_area' => isset($propertyInfo['lot_size_area']) ? $propertyInfo['lot_size_area'] : 0,
                'address_data' => isset($address_data) ? json_encode($address_data) : "",
                'building_data' => isset($building_data) ? json_encode($building_data) : "",
                'last_updated' => $datework,
                'status' => 1,
            );

        }
        if (!empty($data)) {

            $PropertyModel->addBatchRecord($data);

            CLI::write("Inserted ". count($data) ."records for Batch {$batch}", 'green');
        }

    }


    protected function preparePropertyDataRequest($token, $propertyId)
    {
        $url = 'https://ddfapi.realtor.ca/odata/v1/Property/' . $propertyId;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return $curl;
    }

    protected function extractPropertyDetails($response)
    {
        $keyword = "<?xml";
        $position = strpos($response, $keyword);
        $xml_String = substr($response, $position);
        $xmlString = simplexml_load_string($xml_String);
        $json = json_encode($xmlString);
        $array = json_decode($json, TRUE);

        return $array['RETS-RESPONSE']['PropertyDetails'];
    }
    protected function writeJsonToFile($filename, $data) {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $jsonData);
    }

}

