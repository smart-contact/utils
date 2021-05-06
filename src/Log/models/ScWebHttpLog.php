<?php


namespace SmartContact\Log\models;

use Illuminate\Database\Eloquent\Model;

class ScWebHttpLog extends Model
{
    public $timestamps = false;

    const CREATED_AT = 'request_at';
    const UPDATED_AT = NULL;

    protected $guarded = [];

    protected $casts = [
        'request' => 'array',
        'request_header' => 'array'
    ];
}
