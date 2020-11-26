<?php
$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$error = null;
$success = null;
$id = $pdo->quote($_GET['id']);

try {
    if (isset($_POST['name']) && isset($_POST['content'])) {
        $query = $pdo->prepare('UPDATE posts SET name = :name, content = :content WHERE id = :id');
        $query->execute([
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'id' => $_GET['id']
        ]);
        $success = 'Your post has been updated';
    }
    // Request prepation to limit risks against SQLi.
    $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
    $query->execute([
        'id' => $_GET['id']]);
    $post = $query->fetch();
} catch (PDOException $e) {
    $error = $e->getMessage();
}
require '../elements/header.php';
?>

<div class="container">
    <p>
        <a href="/blog">Back to post list</a>
    </p>
    <?php if ($success) : ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="<?= htmlentities($post->name) ?>">
        </div>
        <div class="form-group">
            <textarea type="text" class="form-control" name="content"><?= htmlentities($post->content) ?></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php endif; ?>

<?php
require '../elements/footer.php';
?>
