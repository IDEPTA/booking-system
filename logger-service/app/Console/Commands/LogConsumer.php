<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class LogConsumer extends Command
{
    protected $signature = 'log:consume';
    protected $description = 'Консюмер для логов kafka';

    public function handle()
    {
        Log::info("Запущен консюмер");
        echo "Начинаем слушать ВСЁ\n";
        Kafka::createConsumer()
            ->subscribe('booking-events')
            ->withHandler(function (KafkaConsumerMessage $message) {
                $data = $message->getBody();
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