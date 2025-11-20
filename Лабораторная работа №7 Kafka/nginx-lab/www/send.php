<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php';

if ($_POST) {
    $data = [
        'type' => 'create_post',
        'title' => $_POST['title'] ?? '',
        'content' => $_POST['content'] ?? '',
        'author' => $_POST['author'] ?? 'Аноним',
        'timestamp' => date('Y-m-d H:i:s')
    ];

    try {
        $qm = new QueueManager();
        $qm->publish($data);
        
        header('Location: index.php?success=1');
        exit;
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}