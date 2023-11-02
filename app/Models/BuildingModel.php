<?php

namespace App\Models;

use CodeIgniter\Model;

class BuildingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'buildings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['attribute_id','listing_id', 'bathroom_total','bedrooms_total', 'bedrooms_above_ground',
    'bedrooms_below_ground', 'appliances','architectural_style','basement_development', 'basement_type','constructed_date', 'construction_material',
    'construction_style_attachment', 'cooling_type','exterior_finish','fireplace_present', 'fireplace_total','flooring_type'
    ,'foundation_type', 'half_bath_total','heating_fuel','heating_type','rooms', 'stories_total','total_finished_area', 'type',
    'size_interior','size_exterior', 'amenities','fire_protection', 'age','utility_water'];

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
}
