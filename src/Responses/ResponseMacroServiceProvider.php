<?php

namespace SmartContact\Responses;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($message, $data) {
            return Response::json([
                'message' => $message,
                'data' => $data,
            ]);
        });

        Response::macro('validationErrors', function ($errors) {
            return response::json([
                'message' => __('responses.errors.validation'),
                'errors' => $errors
            ], ResponseCode::HTTP_UNPROCESSABLE_ENTITY);
        });

        Response::macro('unauthorized', function () {
           return response::json([
               'message' => __('responses.errors.unauthorized')
           ], ResponseCode::HTTP_FORBIDDEN);
        });

        Response::macro('modelNotFound', function () {
            return response::json([
                'message' => __('responses.errors.model_not_found')
            ], ResponseCode::HTTP_NOT_FOUND);
        });
    }
}
