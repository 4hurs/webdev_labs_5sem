<?php
session_start();
require_once 'ApiClient.php';

header('Content-Type: application/json');

try {
    $api = new ApiClient();
    $apiData = $api->request('https://api.github.com/topics');
    
    if (isset($apiData['error'])) {
        echo json_encode(['success' => false, 'error' => $apiData['error']]);
        exit;
    }
    
    // Сохраняем в кеш
    file_put_contents('api_cache.json', json_encode($apiData, JSON_UNESCAPED_UNICODE));
    
    // Обновляем сессию
    $_SESSION['api_data'] = $apiData;
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>