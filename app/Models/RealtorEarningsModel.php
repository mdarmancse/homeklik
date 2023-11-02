<?php

namespace App\Models;

use CodeIgniter\Model;

class RealtorEarningsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'realtor_earnings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id","realtor_id","tour_id","month","year","earning","created_at","updated_at","deleted_at"];

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

    public function addRecord($data)
    {

        $this->insert($data);
        //echo "<pre>";print_r( $this->insertID());exit();

        return $this->insertID();
    }
    //Get Record of a City
    public function getSingleRow($conditions)
    {
        return $this->where($conditions)->get()->getFirstRow('array');
    }
    // Get Table Data
    public function getRecord($conditions)
    {
        return $this->where($conditions)->orderBy('id', 'ASC')->get()->getResultArray();
    }
    // Update Data
    public function updateRecord($id, $data)
    {
        return $this->update($id, $data);
    }
    // Delete Row
    public function deleteRow($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function getEarningsData($realtor_id)
    {
        $currentMonth = date('F');
        $currentYear = date('Y');


        $data = [];
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        $collapseThreshold = 5;

        $startMonthIndex = array_search('January', $months);
        $currentMonthIndex = array_search($currentMonth, $months);

        $startIndex = $startMonthIndex;
        $endIndex = $currentMonthIndex;


        if ($currentMonthIndex - $startMonthIndex + 1 > $collapseThreshold) {
            $startIndex = max($startMonthIndex, $currentMonthIndex - $collapseThreshold + 1);
           // $shortMonth = $this->shortFormMonth( $months[$startIndex - 1]);
            $range = $this->shortFormMonth($months[$startMonthIndex]) . '-' . $this->shortFormMonth( $months[$startIndex - 1]);
            //$range = $months[$startMonthIndex] . '-' . $months[$startIndex - 1];
            $totalEarning = $this->calculateTotalEarning($realtor_id, $currentYear, array_slice($months, $startMonthIndex, $startIndex - $startMonthIndex));

            $data[] = [
                'month' => $range,
                'value' => $totalEarning>0? round(($totalEarning/1000)) . 'K': '0K'
            ];
        }


        for ($i = $startIndex; $i <= $endIndex; $i++) {
            $month = $months[$i];

            $totalEarning = $this->calculateTotalEarning($realtor_id, $currentYear, [$month]);

            $shortMonth = $this->shortFormMonth($month);

            $formattedMonth = $shortMonth;
            if ($month === $currentMonth) {
                $formattedMonth .= ' (Current)';
            }

            // Add the data to the array
            $data[] = [
                'month' => $formattedMonth,
                'value' => $totalEarning>0? round(($totalEarning/1000)) . 'K': '0K'
            ];
        }

        return $data;
    }

    private function shortFormMonth($month) {
        $monthMapping = [
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'May',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Aug',
            'September' => 'Sep',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Dec'
        ];

        if (array_key_exists($month, $monthMapping)) {
            return $monthMapping[$month];
        }

        return $month; // Return the original month name if not found in mapping
    }

    private function calculateTotalEarning($realtor_id, $year, $months)
    {
        $totalEarningQuery = $this->db->table('realtor_earnings')
            ->selectSum('earning', 'total_earning')
            ->where('realtor_id', $realtor_id)
            ->where('year', $year)
            ->whereIn('month', $months)
            ->get();

        $queryResult = $totalEarningQuery->getRow();

        return $queryResult ? $queryResult->total_earning : 0;
    }


}
