# Лабораторная работа №5: PHP + MySQL + Docker

![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Adminer](https://img.shields.io/badge/Adminer-gray?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNiAxNiI+PHBhdGggZmlsbD0id2hpdGUiIGQ9Ik04IDBDMy41OCA1LjU1IDEuNDUgOCAwIDh2MmMxLjQ1IDAgMy41OC01LjU1IDgtOHptMCA4Yy00LjQyLTUuNTUtNi41NS04LTgtOHYyYzEuNDUgMCAzLjU4IDUuNTUgOCA4ek0zIDdsMi0yLjVMMi41IDJoLTFsMyA0ek0xMyA3bC0yLTIuNUwxMy41IDJoMWwtMyA0eiIvPjwvc3ZnPg==)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)


## 👩‍💻 Автор
Чепурнова Аделина, группа 3МО-1

---

## 📌 Описание задания
Переход от хранения данных в текстовых файлах к использованию реляционной базы данных **MySQL**. Для этого в Docker-окружение были добавлены контейнеры `mysql` и **Adminer** (веб-интерфейс для управления БД). Вся логика работы с данными была инкапсулирована в новый PHP-класс-модель.
  
Результат доступен по адресам:
- Главная страница (с выводом из БД): [http://localhost:8080](http://localhost:8080)
- Форма для заполнения: [http://localhost:8080/form.html](http://localhost:8080/form.html)
- Веб-интерфейс для БД: [http://localhost:8081](http://localhost:8081)
---

## ⚙️ Как запустить проект

1.  Клонировать репозиторий:
    ```bash
    git clone https://github.com/4hurs/webdev_labs_5sem.git
    cd webdev_labs_5sem
    ```
2.  Запустить контейнеры с пересборкой:
    ```bash
    docker-compose up -d --build
    ```
3.  Открыть сайт в браузере. При первом запуске необходимо создать таблицу в БД.

---

## 📂 Новое в проекте

*   `Dockerfile` — **Новый файл** для сборки кастомного образа PHP с расширениями `pdo` и `pdo_mysql`.
*   *Изменения в `docker-compose.yml`*: Добавлены сервисы `db` (MySQL) и `adminer`. Сервис `php` теперь использует `build` вместо `image`.
*   `db.php` — **Новый файл** для установления соединения с базой данных с помощью PDO.
*   `Student.php` — **Новый класс-модель**, который инкапсулирует всю логику SQL-запросов (добавление и получение заявок).
*   *Изменения в `process.php`*: Теперь скрипт не пишет в файл, а использует класс `Student` для сохранения данных в MySQL.
*   *Изменения в `index.php`*: Страница теперь не использует сессии для вывода данных, а напрямую запрашивает все заявки из БД с помощью `Student` и отображает их.
*   *Удалены*: `view.php` и `data.txt`, так как их функциональность полностью заменена связкой `index.php` + MySQL.
---

## 📸 Скриншоты работы

### 1. Структура таблицы в Adminer
Таблица `online_courses` была создана в базе данных `lab5_db` с помощью SQL-запроса через веб-интерфейс Adminer.

![Структура таблицы](screenshots/table_structure.png)
*Структура таблицы `online_courses` в Adminer*

### 2. Вывод данных из MySQL на главной странице
Главная страница `index.php` теперь напрямую читает данные из таблицы `online_courses` и отображает их в виде отформатированной таблицы.

![Вывод из БД](screenshots/php-mysql.png)
*Все заявки, полученные из базы данных MySQL*


---

## ✅ Результат

Проект успешно переведен на использование базы данных MySQL в Docker-окружении. Вся логика работы с данными инкапсулирована в класс-модель, что соответствует современным практикам разработки. Файловое хранилище полностью заменено, что повысило надежность и масштабируемость приложения.
