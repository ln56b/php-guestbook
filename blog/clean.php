<?php
$pdo = new PDO('sqlite:../data.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$pdo->beginTransaction();
$pdo->exec('UPDATE posts SET name = "demo" WHERE id = 1');
$pdo->exec('UPDATE posts SET content = "demo content" WHERE id = 1');
$post = $pdo->query('SELECT * FROM posts WHERE id = 1')->fetch();
var_dump($post);
$pdo->rollback();