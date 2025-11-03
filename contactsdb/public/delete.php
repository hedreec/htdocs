<?php
require_once __DIR__.'/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    echo '不正なIDです';
    exit;
}

try {
    $stmt = db()->prepare('DELETE FROM contacts WHERE id = ?');
    $stmt->execute([$id]);
} catch (Throwable $e) {
    http_response_code(500);
    echo '削除に失敗しました: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

header('Location: list.php');
