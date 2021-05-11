<?php


namespace SmartContact\Log\logging;

use Monolog\Handler\AbstractProcessingHandler;
use SmartContact\Log\models\ScSystemLog;

class SystemLoggingHandler extends AbstractProcessingHandler
{
    public function __construct($level = 'DEBUG', $bubble = true)
    {
        $this->table = 'sc_system_logs';
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        ScSystemLog::create([
            'incident_code' => $record['context']['incidentCode'],
            'message' => $record['message'],
            'formatted_message' => $record['formatted'],
            'trace' => $record['context']['trace'],
            'level' => $record['level'],
            'level_name' => $record['level_name'],
        ]);
    }

}
