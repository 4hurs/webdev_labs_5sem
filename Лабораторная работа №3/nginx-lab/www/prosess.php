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

// Перенаправляем обратно на главную страницу
header("Location: index.php");
exit();
?>
[file content end]