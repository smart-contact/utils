<?php

namespace SmartContact\Etl\models;

use Illuminate\Database\Eloquent\Model;
use SmartContact\Responses\Traits\HasResponses;

class ScDatawarehouse extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];

    public static function store($data)
    {
        $response = ScDatawarehouse::create($data);
        return response([
            'message' => 'ok'
        ]);
    }
}
