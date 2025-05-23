<?php

namespace App\Handlers;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class MonitoringHandler
{
    /**
     * @param KafkaConsumerMessage $message
     *
     * @return void
     */
    public function __invoke(KafkaConsumerMessage $message): void
    {
        print_r($message->getBody());
    }
}
