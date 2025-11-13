<?php
require 'db.php';
require 'Student.php';

$student = new Student($pdo);
$student->createTable();

// Получаем данные из формы (правильные поля)
$full_name = htmlspecialchars($_POST['full_name']);
$age = intval($_POST['age']);
$course = htmlspecialchars($_POST['course'] ?? '');
$payment = htmlspecialchars($_POST['payment'] ?? '');
$certificate = isset($_POST['certificate']) ? 'Да' : 'Нет';

// Сохраняем в базу данных
$student->add($full_name, $age, $course, $payment, $certificate);

// Сохраняем данные в куки
setcookie('full_name', $full_name, time() + (30 * 24 * 60 * 60));
setcookie('age', $age, time() + (30 * 24 * 60 * 60));
setcookie('course', $course, time() + (30 * 24 * 60 * 60));
setcookie('payment', $payment, time() + (30 * 24 * 60 * 60));
setcookie('certificate', $certificate, time() + (30 * 24 * 60 * 60));

header("Location: index.php");
exit();
?>