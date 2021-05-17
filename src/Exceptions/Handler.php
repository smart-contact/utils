<?php

namespace SmartContact\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    protected $override = false;
    protected $incidentCode;

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function __construct(Container $container)
    {
        $this->incidentCode = Str::uuid();
        parent::__construct($container);
    }

    public function render($request, Throwable $e)
    {
        $excludedExceptions = [
            'Illuminate\Auth\AuthenticationException',
        ];

        $exceptionClass = get_class($e);

        if (!in_array($exceptionClass, $excludedExceptions)) {
            $response = $this->retrieveResponse($e);

            if($e instanceof ModelNotFoundException) {
                return response()->modelNotFound($this->incidentCode);
            }

            if($e instanceof AuthorizationException) {
                return response()->unauthorized($this->incidentCode);
            }

            if($e instanceof ValidationException) {
                return response()->validationErrors($e->errors(), $this->incidentCode);
            }

            if(! $this->override) {
                return response($response, 500);
            }
        }

        return parent::render($request, $e);
    }

    public function report(Throwable $e)
    {
        Log::channel('system_log')->error($e->getMessage(), $this->getContext($e));
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function setOverride($value)
    {
        $this->override = $value;
    }

    protected function retrieveResponse($e)
    {
        if (config('app.debug')) {
            return [
                'incidentCode' => $this->incidentCode ?? null,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ];
        }
        return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'incidentCode' => $this->incidentCode ?? null
        ];
    }

    private function getContext($exception)
    {
        return [
            'trace' => $exception->getTrace(),
            'incidentCode' => $this->incidentCode
        ];
    }
}
