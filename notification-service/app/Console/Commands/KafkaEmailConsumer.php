<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaEmailConsumer extends Command
{
    protected $signature = 'kafka:consume-emails';
    protected $description = 'Consume messages from Kafka topic and send emails';

    public function handle()
    {
        Log::info('Начинаем слушать топик');
        Kafka::createConsumer()
            ->subscribe('booking-events')
            ->withConsumerGroupId('notification-service-group')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $data = $message->getBody();
                Mail::raw($data['message'], function ($msg) use ($data) {
                    $msg->to($data['user_email'])
                        ->subject($data['subject']);
                });

                Log::info('Email отправлен на ' . $data['user_email']);
            })
            ->build()
            ->consume();
    }
}
