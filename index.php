<?php
require_once 'class/Message.php';
$errors = null;
if (isset($_POST['username'], $_POST['comment'])) {
    $message = new Message($_POST['username'], $_POST['comment']);
    if ($message->isValid()) {

    } else {
        $errors = 'Invalid form';
    }
}
$title = 'Guest book';
require 'elements/header.php';
?>
<div class="container">
    <h1>Guest Book</h1>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?= $errors ?>
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" name="username" placeholder="enter your login" class="form-control">
        </div>
        <div class="form-group">
            <textarea name="comment" placeholder="enter your comment" class="form-control"></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
require 'elements/footer.php';
?>
