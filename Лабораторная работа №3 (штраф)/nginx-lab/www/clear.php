<?php
session_start();

// Очищаем сессию
session_destroy();

// Очищаем куки
setcookie('full_name', '', time() - 3600);
setcookie('age', '', time() - 3600);
setcookie('course', '', time() - 3600);
setcookie('payment', '', time() - 3600);
setcookie('certificate', '', time() - 3600);

// Перенаправляем на главную
header("Location: index.php");
exit();
?>