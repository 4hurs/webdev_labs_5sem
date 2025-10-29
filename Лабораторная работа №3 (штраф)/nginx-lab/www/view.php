<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все данные</title>
</head>
<body>
    <h2>Все сохранённые данные:</h2>
    <ul>
        <?php
        if(file_exists("data.txt")){
            $lines = file("data.txt", FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                list($name, $age, $course, $payment, $certificate, $datetime) = explode(";", $line);
                echo "<li><strong>$name</strong> (Возраст: $age лет, Курс: $course, Оплата: $payment, Сертификат: $certificate, Дата: $datetime)</li>";
            }
        } else {
            echo "<li>Данных нет</li>";
        }
        ?>
    </ul>
    <a href="index.php">На главную</a>
</body>
</html>