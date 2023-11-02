<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['entity_id','listing_id', 'agent_details', 
    'land', 'photo','latitude', 'longitude','plan', 'price','building_type', 
    'property_type','transaction_type', 'parking','province', 'city','size_total','size_total_text',
    'maintenance_fee','public_remarks','features','ownership_type','tax_annual_amount','lot_size_area','listing_contract_date','last_updated','is_feature','status'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

     //Batch Data Entry
     public function addBatchRecord($data)
     {
         $this->insertBatch($data);
     }
    //Get Feature Items
    public function GetFeatureItems_Construction($latitude,$longitude,$distance,$rowperpage,$offset)
    {
             $db  = \Config\Database::connect();
           $builder = $db->table('properties');
                $builder->select("properties.last_updated,properties.id,properties.entity_id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
                properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
                buildings.bathroom_total,buildings.bedrooms_total,3956 * 2 * ASIN(SQRT(POWER(SIN((" . $latitude . " - latitude) * pi()/180/2), 2) +
                    COS(" . $latitude . " * pi()/180) * COS(latitude * pi()/180) *
                    POWER(SIN((" . $longitude . " - longitude) * pi()/180/2), 2))) as distance")
                ->having("distance < " . $distance)
                ->join('buildings', 'buildings.attribute_id = properties.entity_id')
                ->join('addresses', 'addresses.attribute_id = properties.entity_id');
                 $builder->where('properties.transaction_type', "For lease");
                 $builder->where('properties.is_feature', 1);
                 $builder->limit($rowperpage,$offset);
                 $builder->distinct();
                 return $builder->get()->getResultArray();

    }
    //Properties Search Items
     public function Items_Search($property_type,$price_from,$price_to,$construction_style,$city,$province,$latitude,$longitude,$rowperpage,$offset)
    {
        $myModel = new CommonModel();
        $distance = $myModel->getRecord('system_option','option_slug','distance');
        $distance = $distance->option_value;
        $db = \Config\Database::connect();
        $builder = $db->table('properties');
        $builder->select("properties.transaction_type,properties.status,properties.id,properties.entity_id as attribute_id,properties.listing_id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
        properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
        buildings.bathroom_total,buildings.bedrooms_total")
        ->join('buildings', 'buildings.attribute_id = properties.entity_id')
        ->join('addresses', 'addresses.attribute_id = properties.entity_id');
        if(count($property_type) > 0){
            $builder->whereIn('properties.transaction_type', $property_type);
        }
        if(count($construction_style) > 0){
            $builder->whereIn('properties.building_type', $construction_style);
        }
        if($province){
            $builder->where('properties.province', $province);
        }
        if($city){
            $builder->where('properties.city', $city);
        }
        if($price_from){
            $builder->where('properties.price >=', $price_from);
        }
        if($price_to){
            $builder->where('properties.price <=', $price_to);
        } 
        $builder->limit($rowperpage,$offset);
        $builder->distinct();
         return $builder->get()->getResultArray();
    }
     // Get Table Data
     public function GetData($rowperpage, $start)
     {
          $db  = \Config\Database::connect();
           $builder = $db->table('properties');
                $builder->select("properties.is_feature,properties.status,properties.last_updated,properties.id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
                properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
                buildings.bathroom_total,buildings.bedrooms_total")
                ->join('buildings', 'buildings.attribute_id = properties.entity_id','left')
                ->join('addresses', 'addresses.attribute_id = properties.entity_id','left');
                $builder->limit($rowperpage,$start);
                 return $builder->get()->getResultArray();
       // return $this->orderBy('id', 'ASC')->limit($rowperpage, $start)->get()->getResultArray();
     }
     // Update Data
    public function updateRecord($id, $data)
    {
        return $this->update($id, $data);
    }
    // Get Property Details
   public function getPropertyDetails($listing_id)
    {
            $db = \Config\Database::connect();
            $builder = $db->table('properties');
            $builder->select("properties.entity_id as attribute_id,properties.listing_id,buildings.bedrooms_total,
             buildings.bathroom_total,properties.parking,addresses.street_address,properties.photo,properties.price,
             properties.size_total,properties.size_total_text,properties.status")
             ->join('buildings', 'buildings.listing_id = properties.listing_id', 'left')
                     ->join('addresses', 'addresses.listing_id = properties.listing_id', 'left');

            if(is_array($listing_id)){
                $builder->whereIn('properties.listing_id', $listing_id);
            }
           else{
            $builder->where('properties.listing_id', $listing_id);
           }
            $builder->distinct();
             return $builder->get()->getResultArray();

        //  return $this->select('properties.entity_id,properties.listing_id,buildings.bedrooms_total,
        //  buildings.bathroom_total,properties.parking,addresses.street_address,properties.photo,properties.price,
        //  properties.size_total,properties.size_total_text,properties.status')
        //             ->join('buildings', 'buildings.listing_id = properties.listing_id', 'left')
        //             ->join('addresses', 'addresses.listing_id = properties.listing_id', 'left')
        //             ->where('properties.listing_id', $listing_id)
        //             ->first();              
    }
    //Properties Search Items Lite
    public function Items_Search_Lite($property_type,$price_from,$price_to,$construction_style,$city,$province,$latitude,$longitude)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('properties');
        $builder->select("properties.entity_id,properties.listing_id,properties.latitude,properties.longitude");
        if(count($property_type) > 0){
            $builder->whereIn('properties.transaction_type', $property_type);
        }
        if(count($construction_style) > 0){
            $builder->whereIn('properties.building_type', $construction_style);
        }
        if($province){
            $builder->where('properties.province', $province);
        }
        if($city){
            $builder->where('properties.city', $city);
        }
        if($price_from){
            $builder->where('properties.price >=', $price_from);
        }
        if($price_to){
            $builder->where('properties.price <=', $price_to);
        } 
        $builder->distinct();
         return $builder->get()->getResultArray();
    }
    // Get Property Details Description
    public function getPropertyDescription($listing_id)
    {
        return $this->select('properties.entity_id as attribute_id,properties.listing_id,properties.photo,properties.price,
        properties.last_updated,addresses.street_address,properties.city,properties.province,addresses.postal_code,
        buildings.bedrooms_total,buildings.bathroom_total,properties.parking,properties.latitude,properties.longitude,
        properties.size_total,properties.size_total_text,
        properties.building_type,buildings.architectural_style,addresses.unit_number,properties.maintenance_fee,
        properties.agent_details,buildings.constructed_date,properties.public_remarks,buildings.fireplace_present,
        properties.land,buildings.exterior_finish,buildings.heating_fuel,buildings.heating_type,
        buildings.rooms,properties.tax_annual_amount,buildings.cooling_type,properties.status')
                   ->join('buildings', 'buildings.listing_id = properties.listing_id', 'left')
                   ->join('addresses', 'addresses.listing_id = properties.listing_id', 'left')
                   ->where('properties.listing_id', $listing_id)
                   ->first('array');              
    }
    // Get Similler Listing
    public function getSimillerListing($price,$city,$type)
    {
        $price_from = $price > 500000 ?  ($price - 500000) : 0;
        $price_to = $price + 500000;
         $db = \Config\Database::connect();
        $builder = $db->table('properties');
        $builder->select("properties.listing_id,properties.photo,
        properties.price,addresses.street_address,buildings.bedrooms_total,buildings.bathroom_total,properties.parking,
        properties.size_total,properties.size_total_text,
        properties.transaction_type,properties.status")
        ->join('buildings', 'buildings.attribute_id = properties.entity_id')
        ->join('addresses', 'addresses.attribute_id = properties.entity_id');
        if($city){
            $builder->where('properties.city', $city);
        }
         if($type){
            $builder->where('properties.transaction_type', $type);
        }
        if($price_from){
            $builder->where('properties.price >=', $price_from);
        }
        if($price_to){
            $builder->where('properties.price <=', $price_to);
        } 
        $builder->distinct();
         return $builder->get()->getResultArray();            
    }
    // Get Features Items
    public function getFeaturesItems()
    {
         $db = \Config\Database::connect();
        $builder = $db->table('properties');
        $builder->select("properties.listing_id,properties.photo,
        properties.price,addresses.street_address,buildings.bedrooms_total,buildings.bathroom_total,properties.parking,
        properties.size_total,properties.size_total_text,
        properties.transaction_type,properties.status")
        ->join('buildings', 'buildings.attribute_id = properties.entity_id')
        ->join('addresses', 'addresses.attribute_id = properties.entity_id');
            $builder->where('properties.is_feature', 1);
            $builder->distinct();
         return $builder->get()->getResultArray();            
    }
    //Properties Search Items
     public function getPropertyFilter($property_type,$price_from,$price_to,$construction_style,$city,$bedrooms,$bathrooms,$parkings)
    {
        $myModel = new CommonModel();
        $distance = $myModel->getRecord('system_option','option_slug','distance');
        $distance = $distance->option_value;
        $db = \Config\Database::connect();
        $builder = $db->table('properties');
        $builder->select("properties.status,properties.id,properties.entity_id as attribute_id,properties.listing_id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
        properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
        buildings.bathroom_total,buildings.bedrooms_total")
        ->join('buildings', 'buildings.attribute_id = properties.entity_id')
        ->join('addresses', 'addresses.attribute_id = properties.entity_id');
        if($property_type){
            $builder->where('properties.transaction_type', $property_type);
        }
        if(count($construction_style) > 0){
            $builder->whereIn('properties.building_type', $construction_style);
        }
        if($city){
            $builder->where('properties.city', $city);
        }
        if($price_from){
            $builder->where('properties.price >=', $price_from);
        }
        if($price_to){
            $builder->where('properties.price <=', $price_to);
        } 
        if($bedrooms){
            $builder->where('buildings.bedrooms_total', $bedrooms);
        }
        if($bathrooms){
            $builder->where('buildings.bathroom_total', $bathrooms);
        }
        if($parkings){
            $builder->where('properties.parking', $parkings);
        }
        $builder->distinct();
         return $builder->get()->getResultArray();
    }
   

}
