<?php


namespace SmartContact\Etl\modules\datawarehouse;


use SmartContact\Etl\models\ScDatawarehouse;
use SmartContact\Etl\exceptions\DatawarehouseServiceNotSet;
use SmartContact\Responses\Traits\HasResponses;

class Datawarehouse
{
    use HasResponses;

    protected $service = "";

    public function load($data)
    {
        if($this->service == "") {
            throw new DatawarehouseServiceNotSet();
        }

        ScDatawarehouse::create([
            'datawarehouse' => $this->service,
            'table' => $data->table,
            'data' => $data->data
        ]);

        return $this->response();
    }
}
