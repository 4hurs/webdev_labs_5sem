<?php
session_start();
require_once 'UserInfo.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
    <script>
        function refreshApiData() {
            fetch('api_refresh.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Ошибка обновления данных: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Ошибка сети: ' + error);
                });
        }
    </script>
</head>
<body>
    <h1>Главная страница</h1>
    
    <?php if(isset($_SESSION['errors'])): ?>
        <ul style="color:red;">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <!-- Информация о пользователе -->
    <?php $info = UserInfo::getInfo(); ?>
    <div style="background-color: #f0f8ff; padding: 15px; margin: 10px 0;">
        <h3>Информация о пользователе:</h3>
        <?php foreach ($info as $key => $val): ?>
            <?= htmlspecialchars($key) ?>: <?= htmlspecialchars($val) ?><br>
        <?php endforeach; ?>
        
        <!-- Время последней отправки формы -->
        <?php if(isset($_COOKIE['last_submission'])): ?>
            <br>Последняя отправка формы: <?= htmlspecialchars($_COOKIE['last_submission']) ?>
        <?php endif; ?>
    </div>

    <!-- Данные из API -->
    <?php if(isset($_SESSION['api_data'])): ?>
        <div style="background-color: #f0f0f0; padding: 15px; margin: 10px 0;">
            <h3>Данные из API (GitHub Topics):</h3>
            <button onclick="refreshApiData()">Обновить данные API</button>
            <?php if(isset($_SESSION['api_data']['error'])): ?>
                <p style="color: red;">Ошибка API: <?= htmlspecialchars($_SESSION['api_data']['error']) ?></p>
            <?php elseif(isset($_SESSION['api_data']['names'])): ?>
                <ul>
                    <?php foreach($_SESSION['api_data']['names'] as $topic): ?>
                        <li><?= htmlspecialchars($topic) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Нет данных для отображения</p>
            <?php endif; ?>
            
            <!-- Информация о кеше -->
            <?php 
            $cacheFile = 'api_cache.json';
            if(file_exists($cacheFile)): 
                $cacheTime = filemtime($cacheFile);
                $currentTime = time();
                $diff = $currentTime - $cacheTime;
            ?>
                <p><small>Кеш обновлен: <?= date('Y-m-d H:i:s', $cacheTime) ?> (<?= floor($diff/60) ?> минут назад)</small></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['full_name'])): ?>
        <div style="background-color: #e8f5e8; padding: 15px; margin: 10px 0;">
            <h3>Данные из сессии:</h3>
            <ul>
                <li>Имя: <?= $_SESSION['full_name'] ?></li>
                <li>Возраст: <?= $_SESSION['age'] ?> лет</li>
                <li>Курс: <?= $_SESSION['course'] ?></li>
                <li>Форма оплаты: <?= $_SESSION['payment'] ?></li>
                <li>Сертификат: <?= $_SESSION['certificate'] ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(isset($_COOKIE['full_name'])): ?>
        <div style="background-color: #fff3cd; padding: 15px; margin: 10px 0;">
            <h3>Данные из куки (последняя регистрация):</h3>
            <ul>
                <li>Имя: <?= $_COOKIE['full_name'] ?></li>
                <li>Возраст: <?= $_COOKIE['age'] ?> лет</li>
                <li>Курс: <?= $_COOKIE['course'] ?></li>
                <li>Форма оплаты: <?= $_COOKIE['payment'] ?></li>
                <li>Сертификат: <?= $_COOKIE['certificate'] ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(!isset($_SESSION['full_name']) && !isset($_COOKIE['full_name'])): ?>
        <p>Данных пока нет.</p>
    <?php endif; ?>

    <br>
    <a href="form.html">Заполнить форму</a> |
    <a href="view.php">Посмотреть все данные</a> |
    <a href="clear.php">Очистить данные</a>
</body>
</html>