<?php
session_start();

require_once 'ApiClient.php';
require_once 'UserInfo.php';

$full_name = htmlspecialchars(trim($_POST['full_name'] ?? ''));
$age = htmlspecialchars(trim($_POST['age'] ?? ''));
$course = htmlspecialchars(trim($_POST['course'] ?? ''));
$payment = htmlspecialchars(trim($_POST['payment'] ?? ''));
$certificate = isset($_POST['certificate']) ? 'Да' : 'Нет';

$errors = [];
if(empty($full_name)) $errors[] = "Имя не может быть пустым";
if(empty($age) || $age < 0 || $age > 100) $errors[] = "Возраст должен быть от 0 до 100 лет";
if(empty($course)) $errors[] = "Курс должен быть выбран";

if(!empty($errors)){
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сохраняем данные в сессию
$_SESSION['full_name'] = $full_name;
$_SESSION['age'] = $age;
$_SESSION['course'] = $course;
$_SESSION['payment'] = $payment;
$_SESSION['certificate'] = $certificate;

// Сохраняем данные в куки (на 30 дней)
setcookie('full_name', $full_name, time() + (30 * 24 * 60 * 60));
setcookie('age', $age, time() + (30 * 24 * 60 * 60));
setcookie('course', $course, time() + (30 * 24 * 60 * 60));
setcookie('payment', $payment, time() + (30 * 24 * 60 * 60));
setcookie('certificate', $certificate, time() + (30 * 24 * 60 * 60));

// Кука времени последней отправки
setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");

// Получаем данные из API GitHub Topics с кешированием
$api = new ApiClient();
$cacheFile = 'api_cache.json';
$cacheTtl = 300; // 5 минут

if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheTtl) {
    $cached = json_decode(file_get_contents($cacheFile), true);
    $_SESSION['api_data'] = $cached;
} else {
    $apiData = $api->request('https://api.github.com/topics');
    file_put_contents($cacheFile, json_encode($apiData, JSON_UNESCAPED_UNICODE));
    $_SESSION['api_data'] = $apiData;
}

// Сохраняем информацию о пользователе
$_SESSION['user_info'] = UserInfo::getInfo();

// Сохраняем данные в файл data.txt
$line = $full_name . ";" . $age . ";" . $course . ";" . $payment . ";" . $certificate . ";" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

header("Location: index.php");
exit();
?>