<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require 'vendor/autoload.php';

class BlogManager {
    private string $storageFile = 'data/posts.json';

    public function __construct() {
        if (!is_dir('data')) mkdir('data', 0755, true);
        if (!file_exists($this->storageFile)) file_put_contents($this->storageFile, '[]');
    }

    public function createPost(array $data): void {
        $posts = json_decode(file_get_contents($this->storageFile), true) ?: [];
        $post = [
            'id' => uniqid(),
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        $posts[] = $post;
        file_put_contents($this->storageFile, json_encode($posts, JSON_PRETTY_PRINT));
    }

    public function getAllPosts(): array {
        return json_decode(file_get_contents($this->storageFile), true) ?: [];
    }
}

echo "👷 [Blog Worker] Запущен...\n";

$qm = new QueueManager();
$blog = new BlogManager();

$qm->consume(function($data) use ($blog) {
    echo "📥 [Получено] {$data['type']}: {$data['title']}\n";
    
    echo "   ⚙️ Обработка...\n";
    sleep(1);
    
    if ($data['type'] === 'create_post') {
        $blog->createPost($data);
        echo "✅ [Готово] Пост создан: {$data['title']}\n\n";
    }
});