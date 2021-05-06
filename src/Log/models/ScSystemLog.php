<?php


namespace SmartContact\Log\models;

use Illuminate\Database\Eloquent\Model;

class ScSystemLog extends Model
{
    protected $guarded = [];

    const CREATED_AT = 'log_at';
    const UPDATED_AT = NULL;

    protected $casts = [
        'trace' => 'array'
    ];
}
