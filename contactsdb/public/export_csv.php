<?php
require_once __DIR__.'/db.php';

$q = trim($_GET['q'] ?? '');
$sql = 'SELECT id,name,postal_code,address,phone,email,created_at FROM contacts';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE name LIKE ? OR address LIKE ? OR email LIKE ? OR phone LIKE ?';
    $like = '%'.$q.'%';
    $params = [$like, $like, $like, $like];
}
$sql .= ' ORDER BY id DESC';

$stmt = db()->prepare($sql);
$stmt->execute($params);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="contacts_export.csv"');

$out = fopen('php://output', 'w');
// 先頭にBOMを付与（Excel対策）
fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($out, ['ID','名前','郵便番号','住所','電話','メール','作成日']);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($out, $row);
}
fclose($out);
exit;
