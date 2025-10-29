<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
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