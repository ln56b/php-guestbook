<?php

use General\Post;

require_once '../vendor/autoload.php';
require 'config.php';
$error = null;
try {
    if (isset($_POST['name'], $_POST['content'])) {
        if (isset($pdo)) {
            $query = $pdo->prepare('INSERT INTO posts (name, content, created_at) VALUES (:name, :content, :created)');
        }
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'created' => time()
        ]);
        header('Location: /blog/edit.php?id=' . $pdo->lastInsertId());
        exit();

    }
    if (isset($pdo)) {
        $query = $pdo->query('SELECT * FROM posts');
    }
    /** @var Post[] */
    // Post::class returns the class name as a string
    $posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
} catch (PDOException $e) {
    $error = $e->getMessage();
}
require '../elements/header.php';
?>

<div class="container">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>

    <h2 class="mt-5 mb-5 text-center">Add a post</h2>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Enter a title">
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control" name="content" placeholder="Enter a description"></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>

    <h2 class="mt-5 mb-5 text-center">All posts</h2>
    <ul>
        <?php foreach ($posts as $post): ?>
            <div class="card mb-5">
                <div class="card-header"><a
                            href="/blog/edit.php?id=<?= $post->id ?>"><?= htmlentities($post->name) ?></a></div>
                <div class="card-body">
                    <p class="card-subtitle mb-2 text-muted">Written on <?= $post->created_at->format('d/m/Y H:i') ?></p>
                    <div class="card-text"><?= nl2br(htmlentities($post->getExcerpt())) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<?php
require '../elements/footer.php';
?>
