<?php

$users = [];

$dsn = 'mysql:host=db;port=3306;dbname=sample';
$username = 'root';
$password = 'secret';
try {
    $pdo = new PDO($dsn, $username, $password);

    $statement = $pdo->query('select * from user');
    $statement->execute();
    while ($row = $statement->fetch()) {
        $users[] = $row;
    }

    // 切断
    $pdo = null;
} catch (PDOException $e) {
//    echo 'データベースに接続できませんでした';
    echo 'データベースに接続できませんでした: ' . $e->getMessage();
}

// ユーザ情報を出力
foreach ($users as $user) {
    echo '<p>id: ' . $user['id'] . ', name: ' . $user['name'] . '</p>';
}

// メールを送信
$subject = 'テストメールです';
$message = 'Docker Hubはこちら → https://hub.docker.com/';
foreach ($users as $user) {
    $success = mb_send_mail($user['email'], $subject, $message);
    if ($success) {
        echo '<p>' . $user['name'] . 'にメールを送信しました</p>';
    } else {
        echo '<p>メール送信に失敗しました</p>';
    }
}