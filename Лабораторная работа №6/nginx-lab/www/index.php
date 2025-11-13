<?php
require 'vendor/autoload.php';
use App\BlogManager;

$blog = new BlogManager();
$search = $_GET['search'] ?? '';

echo "<h1>Блог</h1>";
echo "<form><input name='search' value='$search'><button>🔍</button></form>";

if ($search) {
    foreach ($blog->searchPosts($search) as $result) {
        $p = $result['post'];
        echo "<h3>{$p['title']}</h3><p>{$p['content']}</p><hr>";
    }
} else {
    foreach ($blog->getAllPosts() as $post) {
        echo "<h3>{$post['title']}</h3><p>👤 {$post['author']}</p>";
    }
}