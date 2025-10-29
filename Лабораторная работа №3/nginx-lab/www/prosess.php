<?php
session_start();

// Получаем данные формы через $_POST
$full_name = htmlspecialchars($_POST['full_name'] ?? '');
$age = htmlspecialchars($_POST['age'] ?? '');
$course = htmlspecialchars($_POST['course'] ?? '');
$payment = htmlspecialchars($_POST['payment'] ?? '');
$certificate = isset($_POST['certificate']) ? 'Да' : 'Нет';

// Сохраняем данные в сессию
$_SESSION['full_name'] = $full_name;
$_SESSION['age'] = $age;
$_SESSION['course'] = $course;
$_SESSION['payment'] = $payment;
$_SESSION['certificate'] = $certificate;

// Сохраняем данные в файл data.txt
$line = $full_name . ";" . $age . ";" . $course . ";" . $payment . ";" . $certificate . ";" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

// Перенаправляем обратно на главную страницу
header("Location: index.php");
exit();
?>