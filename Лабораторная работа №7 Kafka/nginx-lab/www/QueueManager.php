<?php
use Kafka\Producer;
use Kafka\ProducerConfig;
use Kafka\Consumer;
use Kafka\ConsumerConfig;

class QueueManager {
    private string $topic = 'blog_operations';
    private string $brokerList = 'kafka:9092';

    public function publish(array $data): void {
        try {
            $config = ProducerConfig::getInstance();
            $config->setMetadataBrokerList($this->brokerList);

            $producer = new Producer(function() use ($data) {
                return [[
                    'topic' => $this->topic,
                    'value' => json_encode($data),
                    'key' => '',
                ]];
            });

            $producer->send(true);
        } catch (Exception $e) {
            throw new Exception("Kafka publish error: " . $e->getMessage());
        }
    }

    public function consume(callable $callback): void {
        try {
            $config = ConsumerConfig::getInstance();
            $config->setMetadataBrokerList($this->brokerList);
            $config->setGroupId('blog_group');
            $config->setTopics([$this->topic]);
            $config->setOffsetReset('earliest');

            $consumer = new Consumer();
            $consumer->start(function($topic, $part, $message) use ($callback) {
                try {
                    $data = json_decode($message['message']['value'], true);
                    if ($data) {
                        $callback($data);
                    }
                } catch (Exception $e) {
                    echo "❌ [Ошибка обработки сообщения]: " . $e->getMessage() . "\n";
                }
            });
        } catch (Exception $e) {
            echo "❌ [Ошибка потребителя Kafka]: " . $e->getMessage() . "\n";
            // Перезапускаем потребление через 5 секунд при ошибке
            sleep(5);
            $this->consume($callback);
        }
    }
}