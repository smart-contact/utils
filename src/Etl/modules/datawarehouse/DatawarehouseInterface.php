<?php

namespace SmartContact\Etl\modules\datawarehouse;

interface DatawarehouseInterface
{
    public function store($item);
}
