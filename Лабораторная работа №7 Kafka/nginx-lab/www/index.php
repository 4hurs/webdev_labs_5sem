<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php';

class BlogManager {
    private string $storageFile = 'data/posts.json';

    public function getAllPosts(): array {
        if (!file_exists($this->storageFile)) return [];
        return json_decode(file_get_contents($this->storageFile), true) ?: [];
    }
}

$blog = new BlogManager();
$posts = $blog->getAllPosts();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Минималистичный блог</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; line-height: 1.6; color: #1a1a1a; background: #fafafa; }
        .container { max-width: 600px; margin: 0 auto; padding: 2rem 1rem; }
        .header { text-align: center; margin-bottom: 3rem; }
        .header h1 { font-size: 2.5rem; font-weight: 300; margin-bottom: 0.5rem; }
        .header p { color: #666; font-size: 1.1rem; }
        
        .form-section { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 3rem; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #333; }
        input, textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; }
        textarea { height: 120px; resize: vertical; }
        button { background: #000; color: white; border: none; padding: 0.75rem 2rem; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        button:hover { background: #333; }
        
        .posts-section { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .post { border-bottom: 1px solid #eee; padding: 1.5rem 0; }
        .post:last-child { border-bottom: none; }
        .post-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; }
        .post-content { color: #555; margin-bottom: 1rem; line-height: 1.7; }
        .post-meta { color: #888; font-size: 0.9rem; }
        
        .alert { background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Блог</h1>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert">✅ Пост отправлен в очередь на создание</div>
        <?php endif; ?>

        <div class="form-section">
            <h2 style="margin-bottom: 1.5rem;">Новый пост</h2>
            <form method="POST" action="send.php">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Содержание</label>
                    <textarea id="content" name="content" required></textarea>
                </div>
                <div class="form-group">
                    <label for="author">Автор</label>
                    <input type="text" id="author" name="author" required>
                </div>
                <button type="submit">Опубликовать</button>
            </form>
        </div>

        <div class="posts-section">
            <h2 style="margin-bottom: 1.5rem;">Посты (<?= count($posts) ?>)</h2>
            <?php if (empty($posts)): ?>
                <p style="color: #888; text-align: center;">Пока нет постов</p>
            <?php else: ?>
                <?php foreach (array_reverse($posts) as $post): ?>
                    <div class="post">
                        <div class="post-title"><?= htmlspecialchars($post['title']) ?></div>
                        <div class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></div>
                        <div class="post-meta">
                            <?= htmlspecialchars($post['author']) ?> • <?= $post['created_at'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>