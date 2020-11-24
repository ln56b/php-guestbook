<?php
require_once 'class/Message.php';
$errors = null;
if (isset($_POST['username'], $_POST['comment'])) {
    $message = new Message($_POST['username'], $_POST['comment']);
    if ($message->isValid()) {

    } else {
        $errors = $message->getErrors();
    }
}
$title = 'Guest book';
require 'elements/header.php';
?>
<div class="container">
    <h1>Guest Book</h1>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            Invalid form
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username"
                   placeholder="enter your login"
                   class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <textarea name="comment" placeholder="enter your comment"
                      class="form-control <?= isset($errors['comment']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['comment'] ?? '') ?></textarea>
            <?php if (isset($errors['comment'])): ?>
                <div class="invalid-feedback"><?= $errors['comment'] ?></div>
            <?php endif; ?>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
require 'elements/footer.php';
?>
