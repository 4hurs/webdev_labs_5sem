<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'UserInfo.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница - Регистрация на онлайн-курс</title>
    <script>
        async function refreshApiData() {
            try {
                const response = await fetch('api_refresh.php');
                const data = await response.json();
                
                if (data.success) {
                    location.reload(); // Простая перезагрузка страницы
                } else {
                    alert('Ошибка при обновлении данных: ' + data.error);
                }
            } catch (error) {
                alert('Ошибка сети: ' + error);
            }
        }
    </script>
</head>
<body>
    <h1>Главная страница - Регистрация на онлайн-курс</h1>
    
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
            <h3>Ваши данные из сессии:</h3>
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
                <?php if(isset($_COOKIE['last_submission'])): ?>
                    <li>Время регистрации: <?= $_COOKIE['last_submission'] ?></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['api_data'])): ?>
        <div style="background-color: #e3f2fd; padding: 15px; margin: 10px 0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3>Данные из API (IT-курсы):</h3>
                <button onclick="refreshApiData()" style="padding: 5px 10px;">🔄 Обновить данные</button>
            </div>
            
            <?php if (isset($_SESSION['api_data']['names'])): ?>
                <h4>Доступные IT-темы:</h4>
                <ul>
                    <?php foreach ($_SESSION['api_data']['names'] as $topic): ?>
                        <li><?= htmlspecialchars($topic) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <h4>Полные данные API:</h4>
            <pre><?= htmlspecialchars(print_r($_SESSION['api_data'], true)) ?></pre>
        </div>
    <?php endif; ?>

    <?php
    $info = UserInfo::getInfo();
    echo "<div style='background-color: #f3e5f5; padding: 15px; margin: 10px 0;'>";
    echo "<h3>Информация о пользователе:</h3>";
    foreach ($info as $key => $val) {
        echo htmlspecialchars($key) . ': ' . htmlspecialchars($val) . '<br>';
    }
    echo "</div>";
    ?>

    <?php if(!isset($_SESSION['full_name']) && !isset($_COOKIE['full_name'])): ?>
        <p>Данных пока нет. <a href="form.html">Зарегистрируйтесь на курс</a></p>
    <?php endif; ?>

    <br>
    <a href="form.html">Заполнить форму регистрации</a> |
    <a href="view.php">Посмотреть все данные</a> |
    <a href="clear.php">Очистить данные</a>
</body>
</html>