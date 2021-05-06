<?php


namespace SmartContact\Log\logging;

use Monolog\Logger;

class MySQLCustomerLogger
{
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param  array  $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger($config["handler"]);
        return $logger->pushHandler(new $config['handler']);
    }
}