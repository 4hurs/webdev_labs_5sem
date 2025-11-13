<?php
session_start();

// Подключаем API клиент
require_once 'src/ApiClient.php';

// Создаем экземпляр API клиента
$api = new ApiClient();

// Получаем 3 случайных пользователя из API
$apiData = $api->getRandomUsers(3);

// Сохраняем данные в сессии
$_SESSION['api_data'] = $apiData;

// Устанавливаем куку о времени последней регистрации
setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

// Перенаправляем на главную страницу
header('Location: index.php');
exit;
?>