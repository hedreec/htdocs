<?php
require_once __DIR__.'/db.php';

// 受け取り & 簡易バリデーション
$name = trim($_POST['name'] ?? '');
$postal = trim($_POST['postal_code'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];
if ($name === '') $errors[] = '名前は必須です。';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'メールの形式が正しくありません。';

if ($errors) {
    http_response_code(400);
    echo '<h2>入力エラー</h2><ul>';
    foreach ($errors as $e) echo '<li>'.htmlspecialchars($e, ENT_QUOTES, 'UTF-8').'</li>';
    echo '</ul><p><a href="new.php">戻る</a></p>';
    exit;
}

try {
    $sql = 'INSERT INTO contacts(name, postal_code, address, phone, email) VALUES(?,?,?,?,?)';
    $stmt = db()->prepare($sql);
    $stmt->execute([$name, $postal, $address, $phone, $email]);
} catch (Throwable $e) {
    http_response_code(500);
    echo '保存に失敗しました: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

header('Location: list.php');
