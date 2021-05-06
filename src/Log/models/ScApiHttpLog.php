<?php


namespace SmartContact\Log\models;

use Illuminate\Database\Eloquent\Model;

class ScApiHttpLog extends Model
{
    const CREATED_AT = 'request_at';
    const UPDATED_AT = 'response_at';

    protected $guarded = [];

    protected $casts = [
        'response' => 'array',
        'request' => 'array',
        'request_header' => 'array'
    ];
}
