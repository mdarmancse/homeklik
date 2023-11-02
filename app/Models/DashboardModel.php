<?php

namespace App\Models;

use CodeIgniter\Model;
use Carbon\Carbon;
class DashboardModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'dashboards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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
    public function getHighlightsData($Realtor_ID)
    {
        $first_day = new Carbon('first day of last month');
        $last_day = new Carbon('first day of last month');
        $start = $first_day->format('Y-m-d');
        $end = $last_day->format('Y-m-d');
        $currentDate = Carbon::now();
        $futureDate = $currentDate->addDays(30);
        $formattedFutureDate = $futureDate->format('Y-m-d');

         // Current Year Calculation
        $currentYear = $currentDate->year;
        $firstDayOfYear = Carbon::create($currentYear, 1, 1);
        $lastDateOfYear = Carbon::create($currentYear, 12, 31);
        $formattedFirstDayOfYear = $firstDayOfYear->format('Y-m-d');
        $formattedLastDateOfYear = $lastDateOfYear->format('Y-m-d');

        // Previous Year Calculation
        $formattedLastDayOfPreviousYear = $firstDayOfYear->subDays(1)->format('Y-m-d');
        $previousYear = $currentYear - 1;
        $formattedFirstDayOfPreviousYear = Carbon::create($previousYear, 1, 1);

         $conditions = ['tasks.realtor_id' => $Realtor_ID, 'task_status.slug' => "overdue"];
        $db = \Config\Database::connect();
        $builder = $db->table('tasks')
        ->select('tasks.id')
        ->join('task_status', 'task_status.id = tasks.task_status', 'left')
        ->where($conditions);
        $overdue =  $builder->countAllResults();

        $conditions = ['dob <=' => $end, 'dob >=' => $start];
        $builder = $db->table('users');
        $builder->where($conditions);
        $birthday =  $builder->countAllResults();

        $conditions = ['created_at <=' => $end, 'created_at >=' => $start];
        $builder = $db->table('tours');
        $builder->where($conditions);
        $enrolled_customer =  $builder->countAllResults();

        $conditions = ['visit_status.slug =' => 'bid_in_progress','tours.realtor_id' => $Realtor_ID];
        $builder = $db->table('tours')
        ->select('tours.id')
        ->join('visit_status', 'visit_status.id = tours.visit_id')
        ->groupBy('tours.user_id');
        $builder->where($conditions);
        $bid_in_progress =  $builder->countAllResults();

        $conditions = ['visit_status.slug =' => 'bid_success','tours.realtor_id' => $Realtor_ID];
        $builder = $db->table('tours')
        ->select('visit_status.id')
        ->join('visit_status', 'visit_status.id = tours.visit_id','left')
        ->where($conditions)
        ->groupBy('tours.user_id');
        $bid_closed =  $builder->countAllResults();

        $conditions = ['bid_closing_date <=' => $formattedFutureDate];
        $builder = $db->table('tours');
        $builder->where($conditions);
        $next_bidding_custmer =  $builder->countAllResults();

        $conditions = ['visit_status.slug =' => 'bid_success','tours.created_at <=' => $formattedLastDateOfYear, 'tours.created_at >=' => $formattedFirstDayOfYear];
        $builder = $db->table('tours')
        ->select('sum(tours.bid_price) as total_price')
        ->join('visit_status', 'visit_status.id = tours.visit_id','left');
        $builder->where($conditions);
        $current_year_value =  $builder->get()->getResultArray();

        $conditions = ['visit_status.slug =' => 'bid_success','tours.created_at <=' => $formattedLastDayOfPreviousYear, 'tours.created_at >=' => $formattedFirstDayOfPreviousYear];
        $builder = $db->table('tours')
        ->select('sum(tours.bid_price) as total_price')
        ->join('visit_status', 'visit_status.id = tours.visit_id','left');
        $builder->where($conditions);
        $previous_year_value =  $builder->get()->getResultArray();
        $data = array(
            'overdue' => $overdue,
            'birthday' => $birthday,
            'enrolled_customer'=> $enrolled_customer,
            'bid_in_progress' => $bid_in_progress,
            'bid_closed' => $bid_closed,
            'next_bidding_custmer'=>$next_bidding_custmer,
            'current_year_value'=> ($current_year_value[0]['total_price'] * 2.5) / 100,
            'previous_year_value'=> ($previous_year_value[0]['total_price'] * 2.5) / 100
        );
        return $data;
    }
    public function getCustomerProfilesData($Realtor_ID)
    {
        $db = \Config\Database::connect();
        $conditions = ['tours.realtor_id' => $Realtor_ID];

        $builder = $db->table('tours')
            ->select('
                SUM(CASE WHEN visit_status.slug = "bid_success" THEN 1 ELSE 0 END) as complete_customer,
                SUM(CASE WHEN visit_status.slug = "not_visited" THEN 1 ELSE 0 END) as leads_customer,
                SUM(CASE WHEN visit_status.slug = "bid_in_progress" THEN 1 ELSE 0 END) as active_customer
            ')
            ->join('visit_status', 'visit_status.id = tours.visit_id', 'left')
            ->where($conditions);
        
        $data = $builder->get()->getRowArray();
        return $data;
    }
     //Realtor Property List
     public function getPropertyList($realtor_id,$user_type,$property_type,$price_from,$price_to,$construction_style,$city,$bedrooms,$bathrooms,$parkings)
    {
        $Realtor = new RealtorModel();
        $db = \Config\Database::connect();
        if($user_type == 'brokerage')
        {
            $conditions = array(
                'id'=> $realtor_id
             );
            $realtor_data = $Realtor->getSingleRow($conditions);
            $brokerage_id = $realtor_data['brokerage_id'];
            $builder = $db->table('tours');
            $builder->select("properties.transaction_type,properties.status,properties.entity_id as attribute_id,properties.listing_id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
            properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
            buildings.bathroom_total,buildings.bedrooms_total")
            ->join('properties', 'properties.listing_id = tours.listing_id')
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
            $builder->where('tours.brokerage_id', $brokerage_id);
            return $builder->get()->getResultArray();
        }
        if($user_type == 'realtor')
        {
            $builder = $db->table('tours');
            $builder->select("realtor_favourites.favourite,properties.transaction_type,properties.status,properties.entity_id as attribute_id,properties.listing_id,properties.size_total,properties.size_total_text,properties.photo,properties.latitude,
            properties.longitude,properties.listing_id,properties.price,properties.parking,properties.land,addresses.street_address,
            buildings.bathroom_total,buildings.bedrooms_total")
            ->join('properties', 'properties.listing_id = tours.listing_id')
            ->join('buildings', 'buildings.attribute_id = properties.entity_id')
            ->join('addresses', 'addresses.attribute_id = properties.entity_id')
            ->join('realtor_favourites', 'realtor_favourites.listing_id = tours.listing_id','left');
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
            $builder->where('tours.realtor_id', $realtor_id);
            return $builder->get()->getResultArray();
        }
    }
}
