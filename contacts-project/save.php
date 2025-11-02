<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ★ GETで開かれたら一覧にリダイレクト（リンク誤爆対策）
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ./list.php', true, 302);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

function respond($data, int $code = 200) {
  http_response_code($code);
  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  exit;
}

try {
  // 入力取得：JSON or 通常フォームの両対応
  $ctype = $_SERVER['CONTENT_TYPE'] ?? '';
  if (stripos($ctype, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $in  = json_decode($raw, true) ?: [];
  } else {
    $in = $_POST; // フォームPOSTでも保存可能に
  }

  if (!is_array($in)) respond(['error' => '不正な入力です'], 400);

  $name   = trim($in['name'] ?? '');
  $postal = trim($in['postal_code'] ?? '');
  $phone  = trim($in['phone'] ?? '');
  $email  = trim($in['email'] ?? '');

  // サーバ側バリデーション
  if ($name === '' || $postal === '' || $phone === '' || $email === '') {
    respond(['error' => '未入力の項目があります'], 422);
  }
  if (!preg_match('/^\d{3}-\d{4}$/', $postal)) {
    respond(['error' => '郵便番号の形式が不正です（例: 123-4567）'], 422);
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(['error' => 'メールアドレスの形式が不正です'], 422);
  }

  // DB接続
  $host = 'localhost';
  $db   = 'contactsdb';
  $user = 'root';
  $pass = ''; // XAMPPのデフォルト

  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

  // INSERT
  $stmt = $pdo->prepare('INSERT INTO contacts (name, postal_code, phone, email) VALUES (:name, :postal, :phone, :email)');
  $stmt->execute([
    ':name'   => $name,
    ':postal' => $postal,
    ':phone'  => $phone,
    ':email'  => $email,
  ]);

  respond(['ok' => true, 'id' => $pdo->lastInsertId()], 201);

} catch (Throwable $e) {
  respond(['error' => 'サーバエラー: ' . $e->getMessage()], 500);
}
