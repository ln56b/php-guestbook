<?php
// PHP searches dynamically for the class and import it. No need of require.
require 'vendor/autoload.php';
use General\{
    Guestbook,
    Message
};
use General\Contact\Message as ContactMessage;

$errors = null;
$success = false;
$demoAlias = new ContactMessage();
$guestbook = new Guestbook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');

if (isset($_POST['username'], $_POST['comment'])) {
    $message = new Message($_POST['username'], $_POST['comment']);
    if ($message->isValid()) {
        $guestbook->addMessage($message);
        $success = true;
        $_POST = [];
    } else {
        $errors = $message->getErrors();
    }
}
$messages = $guestbook->getMessages();
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

    <?php if ($success): ?>
        <div class="alert alert-success">
            Thank you for your message
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

    <?php if (!empty($messages)): ?>
        <h1>Your messages</h1>
        <?php foreach ($messages as $message): ?>
            <?= $message->toHTML();  ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php
require 'elements/footer.php';
?>
