<?php
require 'db.php';
require 'Student.php';

$student = new Student($pdo);
$student->createTable();

// Получаем данные через класс Student (правильная таблица)
$all = $student->getAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница - Регистрации на курсы</title>
    <style>
        body { font-family: Arial; max-width: 1200px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .nav { margin: 20px 0; }
        .nav a { color: #007bff; text-decoration: none; margin-right: 15px; }
        .cookie-info { background: #fff3cd; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <h1>Регистрации на онлайн-курсы</h1>
    
    <div class="nav">
        <a href="form.html">Новая регистрация</a>
        <a href="view.php">Подробный просмотр</a>
        <a href="clear.php">Очистить данные</a>
    </div>

    <?php if(isset($_COOKIE['full_name'])): ?>
        <div class="cookie-info">
            <h3>Последняя регистрация:</h3>
            <p><strong>Имя:</strong> <?= $_COOKIE['full_name'] ?></p>
            <p><strong>Возраст:</strong> <?= $_COOKIE['age'] ?> лет</p>
            <p><strong>Курс:</strong> <?= $_COOKIE['course'] ?></p>
            <p><strong>Оплата:</strong> <?= $_COOKIE['payment'] ?></p>
            <p><strong>Сертификат:</strong> <?= $_COOKIE['certificate'] ?></p>
        </div>
    <?php endif; ?>

    <h2>Все регистрации:</h2>
    
    <?php if(empty($all)): ?>
        <p>Нет зарегистрированных участников.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Возраст</th>
                    <th>Курс</th>
                    <th>Оплата</th>
                    <th>Сертификат</th>
                    <th>Дата регистрации</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($all as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td><?= htmlspecialchars($row['payment']) ?></td>
                    <td><?= $row['certificate'] ?></td>
                    <td><?= $row['registration_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Всего регистраций:</strong> <?= count($all) ?></p>
    <?php endif; ?>
</body>
</html>