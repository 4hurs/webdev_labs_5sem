<?php
session_start();

// Получаем данные формы через $_POST
$full_name = htmlspecialchars(trim($_POST['full_name'] ?? ''));
$age = htmlspecialchars(trim($_POST['age'] ?? ''));
$course = htmlspecialchars(trim($_POST['course'] ?? ''));
$payment = htmlspecialchars(trim($_POST['payment'] ?? ''));
$certificate = isset($_POST['certificate']) ? 'Да' : 'Нет';

// Проверка корректности данных
$errors = [];
if(empty($full_name)) $errors[] = "Имя не может быть пустым";
if(empty($age) || $age < 0 || $age > 100) $errors[] = "Возраст должен быть от 0 до 100 лет";
if(empty($course)) $errors[] = "Курс должен быть выбран";

// Если есть ошибки, сохраняем их в сессию и перенаправляем обратно
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

// Сохраняем данные в файл data.txt
$line = $full_name . ";" . $age . ";" . $course . ";" . $payment . ";" . $certificate . ";" . date('Y-m-d H:i:s') . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

// Перенаправляем обратно на главную страницу
header("Location: index.php");
exit();
?>