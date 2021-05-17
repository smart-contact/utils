<?php


namespace SmartContact\Etl\modules\datawarehouse\google;


use Google\Cloud\BigQuery\BigQueryClient;
use SmartContact\Etl\exceptions\BigQueryInvalidRowException;
use SmartContact\Etl\modules\datawarehouse\DatawarehouseInterface;
use SmartContact\Etl\modules\datawarehouse\Datawarehouse;

class BigQuery extends Datawarehouse implements DatawarehouseInterface
{
    private $bigQuery;
    private $table;
    protected $service = 'google';

    public function init($tableId)
    {
        $this->bigQuery = new BigQueryClient([
            'projectId' => config('sc_datawarehouse.google.project_id'),
            'keyFilePath' => config('sc_datawarehouse.google.credentials')
        ]);

        $dataset = $this->bigQuery->dataset(config('sc_datawarehouse.google.dataset_id'));
        $this->table = $dataset->table($tableId);
        return $this;
    }

    public function store($item)
    {
        $insertResponse = $this->table->insertRows([
            ['data' => $item],
        ]);

        if (! $insertResponse->isSuccessful()) {
            foreach ($insertResponse->failedRows() as $row) {
                foreach ($row['errors'] as $error) {
                    throw new BigQueryInvalidRowException($error);
                }
            }
        }
    }
}
