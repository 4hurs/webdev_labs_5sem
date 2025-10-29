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
        <p>Данные из сессии:</p>
        <ul>
            <li>Имя: <?= $_SESSION['full_name'] ?></li>
            <li>Возраст: <?= $_SESSION['age'] ?> лет</li>
            <li>Курс: <?= $_SESSION['course'] ?></li>
            <li>Форма оплаты: <?= $_SESSION['payment'] ?></li>
            <li>Сертификат: <?= $_SESSION['certificate'] ?></li>
        </ul>
    <?php else: ?>
        <p>Данных пока нет.</p>
    <?php endif; ?>

    <br>
    <a href="form.html">Заполнить форму</a> |
    <a href="view.php">Посмотреть все данные</a>
</body>
</html>