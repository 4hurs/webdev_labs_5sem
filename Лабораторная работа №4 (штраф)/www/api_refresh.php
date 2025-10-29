<?php
session_start();
require_once 'vendor/autoload.php';

header('Content-Type: application/json');

try {
    $api = new ApiClient();
    $url = 'https://api.github.com/topics';
    
    $apiData = $api->request($url);
    
    // Обновляем кеш
    $cacheFile = 'api_cache.json';
    file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
    
    $_SESSION['api_data'] = $apiData;
    
    echo json_encode([
        'success' => true,
        'api_data' => $apiData
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>