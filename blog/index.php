<?php
require_once '../class/Post.php';
$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
try {
    if (isset($_POST['name'], $_POST['content'])) {
        $query = $pdo->prepare('INSERT INTO posts (name, content, created_at) VALUES (:name, :content, :created)');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'created' => time()
        ]);
        header('Location: /blog/edit.php?id=' . $pdo->lastInsertId());
        exit();

    }
    $query = $pdo->query('SELECT * FROM posts');
    /** @var Post[] */
    $posts = $query->fetchAll(PDO::FETCH_CLASS, 'Post');
} catch (PDOException $e) {
    $error = $e->getMessage();
}
require '../elements/header.php';
?>

<div class="container">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <h2><a href="/blog/edit.php?id=<?= $post->id ?>"><?= htmlentities($post->name) ?></a></h2>
            <p class="small text-muted">Written on <?= $post->created_at->format('d/m/Y H:i') ?></p>
            <p><?= nl2br(htmlentities($post->getExcerpt())) ?></p>
        <?php endforeach; ?>
    </ul>


    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Enter a title">
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control" name="content" placeholder="Enter a description"></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php endif; ?>

<?php
require '../elements/footer.php';
?>
