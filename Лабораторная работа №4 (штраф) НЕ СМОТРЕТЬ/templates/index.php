<?php
session_start();
require_once __DIR__ . '/../src/UserInfo.php';

$userInfo = UserInfo::getInfo();
$lastSubmission = UserInfo::getLastSubmission();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Шахматный Клуб</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { background: #2c3e50; color: white; padding: 20px; text-align: center; margin-bottom: 20px; }
        .card { background: white; padding: 20px; margin-bottom: 20px; }
        .btn { background: #27ae60; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .member-card { background: #f8f9fa; padding: 15px; margin: 10px 0; }
        .member-photo { width: 60px; height: 60px; border-radius: 50%; }
        pre { background: #2c3e50; color: white; padding: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>♟ Шахматный Клуб</h1>
        </div>

        <div class="card" style="text-align: center;">
            <form action="../save.php" method="POST">
                <button type="submit" class="btn">Найти шахматистов</button>
            </form>
        </div>

        <?php if (isset($_SESSION['api_data'])): ?>
            <div class="card">
                <h2>Новые шахматисты</h2>
                
                <?php if (isset($_SESSION['api_data']['results'])): ?>
                    <?php foreach ($_SESSION['api_data']['results'] as $user): ?>
                        <div class="member-card">
                            <img src="<?= htmlspecialchars($user['picture']['large']) ?>" class="member-photo">
                            <h3><?= htmlspecialchars($user['name']['first']) ?> <?= htmlspecialchars($user['name']['last']) ?></h3>
                            <p><strong>Страна:</strong> <?= htmlspecialchars($user['location']['country']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                            <p><strong>Телефон:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                            <p><strong>Возраст:</strong> <?= htmlspecialchars($user['dob']['age']) ?> лет</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <details>
                    <summary>Данные API</summary>
                    <pre><?= htmlspecialchars(print_r($_SESSION['api_data'], true)) ?></pre>
                </details>
            </div>
            <?php unset($_SESSION['api_data']); ?>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="card">
                <h3>Ваша информация</h3>
                <?php foreach ($userInfo as $key => $val): ?>
                    <p><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($val) ?></p>
                <?php endforeach; ?>
            </div>

            <div class="card">
                <h3>Активность</h3>
                <p><strong>Последний поиск:</strong><br><?= htmlspecialchars($lastSubmission) ?></p>
            </div>
        </div>
    </div>
</body>
</html>