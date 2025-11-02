<?php
// エラーを見える化（開発中のみ）
error_reporting(E_ALL);
ini_set('display_errors', 1);

// タイムゾーン（Macはここがズレがち）
date_default_timezone_set('Asia/Tokyo');

header('Content-Type: application/json; charset=utf-8');

function respond($data, int $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

try {
    // --- DB接続情報 ---
    $host   = 'localhost';
    $dbname = 'testdb';
    $user   = 'root';
    $pass   = ''; // XAMPPのデフォルトは空
    $dsn    = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // デバッグ用ヘッダ（到達確認）
    header('X-Debug-Api', 'db-ok');

    // 簡単な読み取り（users 全件）
    $stmt = $pdo->query("SELECT id, name, email FROM users ORDER BY id ASC");
    $rows = $stmt->fetchAll();

    respond([
        'time' => date('c'),
        'count' => count($rows),
        'data' => $rows
    ]);

} catch (PDOException $e) {
    respond(['error' => 'DBエラー: ' . $e->getMessage()], 500);
} catch (Throwable $e) {
    respond(['error' => 'アプリエラー: ' . $e->getMessage()], 500);
}
