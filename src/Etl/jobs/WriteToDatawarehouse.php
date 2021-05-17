<?php

namespace SmartContact\Etl\jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SmartContact\Etl\models\ScDatawarehouse;
use SmartContact\Etl\modules\datawarehouse\DatawarehouseInterface;

class WriteToDatawarehouse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var DatawarehouseInterface
     */
    private $datawarehouse;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->datawarehouse = app()->make(DatawarehouseInterface::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $items = ScDatawarehouse::where('inserted', false)->get();

        foreach ($items as $item) {
            $this->datawarehouse->init($item->table)->store($item['data']);
            $item->inserted = true;
            $item->save();
        }
    }
}
