<?php

namespace SmartContact\Log\middleware;

use App\Models\Log\HttpLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SmartContact\Log\models\ScApiHttpLog;
use SmartContact\Log\models\ScWebHttpLog;

class ScWebHttpRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $device = new \Jenssegers\Agent\Agent();
        $browser = $device->browser();
        $platform = $device->platform();

        $this->log = ScWebHttpLog::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'url' => $request->url(),
            'user_agent' => $device->getUserAgent(),
            'browser' => $browser ?? null,
            'browser_version' => $device->version($browser) ?? null,
            'platform' => $platform ?? null,
            'platform_version' => null,
            'ip' => $this->getClientIpAddress(),
            'request_method' => $request->method(),
            'request_header' => $request->header(),
            'request' => $request->all()
        ]);

        return $next($request);
    }

    private function getClientIpAddress()
    {
        return request()->server->get('HTTP_X_FORWARDED_FOR') ?
            explode(',', request()->server->get('HTTP_X_FORWARDED_FOR'))[0] :
            request()->server->get('REMOTE_ADDR');
    }
}
