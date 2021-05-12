<?php

namespace SmartContact\Log\middleware;

use App\Models\Log\HttpLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SmartContact\Log\models\ScApiHttpLog;

class ScApiHttpRequest
{
    public $log;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestAll = array_map(function($r) {
            return is_string($r) && Str::length($r) > 1000 ? Str::limit($r, 1000) : $r;
        }, $request->all());

        $this->log = ScApiHttpLog::create([
            'request_referer' => $request->server->get('HTTP_REFERER'),
            'request_method' => $request->getMethod(),
            'request_header' => $request->header(),
            'request' => $requestAll
        ]);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->log->update([
            'response_code' => $response->getStatusCode(),
            'response' => $response
        ]);
    }
}
