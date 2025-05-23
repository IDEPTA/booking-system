<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class LogConsumer extends Command
{
    protected $signature = 'log:consume';
    protected $description = 'Consume logs from RabbitMQ topic exchange';

    public function handle()
    {
        Log::info("Запущен консюмер");
        echo "Начинаем слушать ВСЁ\n";
        Kafka::createConsumer()
            ->subscribe('booking-events')
            ->withConsumerGroupId('log-consumer')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $data = $message->getBody();

                // echo $data;
                echo "Пршила инфа\n";
                DB::table('activity_logs')->insert([
                    'ip_address' => $data['ip-address'],
                    'level' => 'info',
                    'message' => $data['message'],
                    'context' => json_encode($data),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                echo "Записали в БД\n";
            })
            ->build()
            ->consume();
    }
}
