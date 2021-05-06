<?php

namespace SmartContact\Responses\Traits;

use Illuminate\Support\Str;

trait HasResponses
{
    protected $baseGate = null;
    protected $responseMessage = null;
    protected $withoutMessage = false;

    /**
     * @param mixed|null $data
     * @return mixed
     */
    public function response($data = null)
    {
        $message = ($this->withoutMessage === false) ? $this->setResponseMessage() : null;
        return response()->success($message, $data);
    }

    protected function withMessage($message)
    {
        $this->responseMessage = $message;

        return $this;
    }

    protected function withoutMessage()
    {
        $this->withoutMessage = true;

        return $this;
    }

    /**
     * @return string
     */
    private function setResponseMessage()
    {
        if(!$this->responseMessage) {
            $route = explode('.', request()->route()->getName());
            [$resource, $action] = array_slice($route, -2);

            $resource = $this->baseGate ?? Str::singular($resource);

            if (is_null($this->responseMessage)) {
                $this->responseMessage = __("responses.{$resource}.{$action}");
            }
        }

        return $this->responseMessage;
    }
}
