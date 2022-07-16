<?php namespace App\Controllers\Api;

class Report extends BaseApiController
{

    public function index()
    {
        // nilai = sum(compliance) / total_rows * 100
    }

    public function filters()
    {
        return $this->respond($this->loadFilters());
    }

    private function loadFilters()
    {
        $filters = $this->request->getJSON();

        if (!$filters) {
            $filters = new \stdClass;
            $filters->areas = [];
            $filters->date_from = '2021-01-01';
            $filters->date_to = '2021-01-05';
        }
        
        if ($filters->date_from == '') {
            $filters->date_from = '2021-01-01';
        }

        if ($filters->date_to == '') {
            $filters->date_to = '2021-01-05';
        }

        return $filters;
    }

    public function chart()
    {
        $filters = $this->loadFilters();
        
        $builder = \Config\Database::connect()->table('report_product a');

        $builder->select('c.area_name');
        $builder->selectSum('a.compliance');
        $builder->selectCount('a.report_id', 'total_row');

        $builder->join('store b', 'b.store_id = a.store_id', 'left');
        $builder->join('store_area c', 'c.area_id = b.area_id', 'left');

        $builder->where('b.is_active', 1);
        $builder->groupBy('b.area_id');

        if ($filters->areas && count($filters->areas) > 0) {
            $builder->groupStart();
            foreach($filters->areas as $area) {
                    $builder->orWhere('c.area_id', intval($area->area_id));
            }
            $builder->groupEnd();
        }
       

        $builder->groupStart();
        // $date_from = $builder->db->escape($filters->date_from);
        // $date_to = $builder->db->escape($filters->date_to);
        // ^^ CI 4 Bug ^^

        // beware of sql injection of unescaped user input
        $between_date = "a.tanggal BETWEEN STR_TO_DATE('{$filters->date_from}', '%Y-%m-%d') AND STR_TO_DATE('{$filters->date_to}', '%Y-%m-%d')";

        $builder->where($between_date);
        $builder->groupEnd();

        $result = $builder->get()->getResult();

        $categories = [];
        $compliance_percentage = [];

        foreach($result as &$row) {
            array_push($categories, $row->area_name);
            array_push($compliance_percentage, (intval($row->compliance) / intval($row->total_row)) * 100);
        }

        $data = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Nilai',
                    'data' => $compliance_percentage
                ]
            ]
        ];

        return $this->respond($data);
    }

    public function table()
    {
        $filters = $this->loadFilters();
        $builder = \Config\Database::connect()->table('report_product a');

        $builder->select('e.brand_name, c.area_name');
        $builder->selectSum('a.compliance');
        $builder->selectCount('a.report_id', 'total_row');

        $builder->join('store b', 'b.store_id = a.store_id', 'left');
        $builder->join('store_area c', 'c.area_id = b.area_id', 'left');
        $builder->join('product d', 'd.product_id = a.product_id', 'left');
        $builder->join('product_brand e', 'e.brand_id = d.brand_id', 'left');

        $builder->where('b.is_active', 1);

        $builder->groupBy('b.area_id');
        $builder->groupBy('e.brand_id');

        if ($filters->areas && count($filters->areas) > 0) {
            $builder->groupStart();
            foreach($filters->areas as $area) {
                    $builder->orWhere('c.area_id', intval($area->area_id));
            }
            $builder->groupEnd();
        }
       

        $builder->groupStart();
        // $date_from = $builder->db->escape($filters->date_from);
        // $date_to = $builder->db->escape($filters->date_to);
        // ^^ CI 4 Bug ^^

        // beware of sql injection of unescaped user input
        $between_date = "a.tanggal BETWEEN STR_TO_DATE('{$filters->date_from}', '%Y-%m-%d') AND STR_TO_DATE('{$filters->date_to}', '%Y-%m-%d')";

        $builder->where($between_date);
        $builder->groupEnd();

        $result = $builder->get()->getResult();

        $data = [];
        $brand_map = [];

        foreach($result as &$row) {
            $brand = $row->brand_name;

            $index = array_search($brand, $brand_map);

            $percent = round((intval($row->compliance) / intval($row->total_row)) * 100);
            $percent = "{$percent}%";
            if ($index > -1) {
                $data[$index][$row->area_name] = $percent;
            } else {
                array_push($brand_map, $brand);
                
                $item = [
                    'Brand' => $row->brand_name
                ];
                $item[$row->area_name] = $percent;
                array_push($data, $item);
            }

        }

        return $this->respond($data);
    }
}
