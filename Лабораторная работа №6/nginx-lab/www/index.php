<?php
require 'vendor/autoload.php';
use App\BlogManager;

$blog = new BlogManager();
$search = $_GET['search'] ?? '';

// Автоматически создаем тестовые посты
$samplePosts = [
    [
        'title' => 'Введение в Elasticsearch',
        'content' => 'Elasticsearch - это распределенный поисковый движок для полнотекстового поиска.',
        'author' => 'Иван Петров',
        'tags' => ['elasticsearch', 'поиск', 'базы данных'],
        'category' => 'технологии'
    ],
    [
        'title' => 'PHP и REST API',
        'content' => 'Guzzle HTTP Client позволяет легко работать с REST API из PHP.',
        'author' => 'Мария Сидорова',
        'tags' => ['php', 'guzzle', 'api'],
        'category' => 'программирование'
    ],
    [
        'title' => 'Современные базы данных',
        'content' => 'NoSQL базы данных предлагают гибкие схемы и горизонтальное масштабирование.',
        'author' => 'Алексей Иванов', 
        'tags' => ['nosql', 'базы данных', 'big data'],
        'category' => 'технологии'
    ]
];

foreach ($samplePosts as $post) {
    $blog->createPost($post);
}

echo "<h1>📝 Блог на Elasticsearch</h1>";
echo "<p>Посты восстановлены! Всего постов: " . count($samplePosts) . "</p>";

// Форма поиска
echo '
<form method="get" style="margin: 20px 0;">
    <input type="text" name="search" placeholder="Поиск по блогу..." value="'.htmlspecialchars($search).'">
    <button type="submit">🔍 Найти</button>
</form>';

if ($search) {
    // Поиск
    echo "<h2>Результаты поиска: '$search'</h2>";
    $results = $blog->searchPosts($search);
    
    foreach ($results as $result) {
        $post = $result['post'];
        echo "
        <div style='border:1px solid #ddd; padding:15px; margin:10px;'>
            <h3>{$post['title']}</h3>
            <p><strong>Автор:</strong> {$post['author']}</p>
            <p><strong>Релевантность:</strong> " . round($result['score'], 2) . "</p>
            <p>{$post['content']}</p>
            <p><strong>Теги:</strong> " . implode(', ', $post['tags']) . "</p>
        </div>";
    }
} else {
    // Все посты
    echo "<h2>Все посты блога</h2>";
    $allPosts = $blog->getAllPosts();
    
    foreach ($allPosts as $post) {
        echo "
        <div style='border:1px solid #eee; padding:10px; margin:5px;'>
            <h3>{$post['title']}</h3>
            <p><strong>👤 {$post['author']}</strong> | 📁 {$post['category']}</p>
            <p>{$post['content']}</p>
            <p><strong>🏷️ Теги:</strong> " . implode(', ', $post['tags']) . "</p>
        </div>";
    }
}