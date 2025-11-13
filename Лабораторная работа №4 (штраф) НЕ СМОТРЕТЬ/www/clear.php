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
setcookie('last_submission', '', time() - 3600);

// Очищаем кеш API
if (file_exists('api_cache.json')) {
    unlink('api_cache.json');
}

// Перенаправляем на главную
header("Location: index.php");
exit();
?>