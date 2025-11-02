<?php
header('Content-Type: text/html; charset=utf-8');

try {
  $pdo = new PDO(
    "mysql:host=localhost;dbname=contactsdb;charset=utf8mb4",
    'root', '',
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
  );

  $rows = $pdo->query('SELECT id, name, postal_code, phone, email, created_at FROM contacts ORDER BY id DESC')->fetchAll();

} catch (Throwable $e) {
  echo "<p>エラー: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
  exit;
}
?>
<!doctype html>
<html lang="ja">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>連絡先一覧</title>
<style>
  body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; margin: 2rem; }
  a { text-decoration: none; color: #06c; }
  table { border-collapse: collapse; width: 100%; max-width: 960px; }
  th, td { border: 1px solid #ddd; padding: 8px; }
  th { background: #f9f9f9; text-align: left; }
  tr:nth-child(even) { background: #fafafa; }
</style>
<h1>連絡先一覧</h1>
<p><a href="./index.html">← 登録フォームへ戻る</a></p>

<?php if (!$rows): ?>
  <p>データがありません。まずは登録してください。</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>氏名</th><th>郵便番号</th><th>電話番号</th><th>メール</th><th>作成日時</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['id']) ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['postal_code']) ?></td>
          <td><?= htmlspecialchars($r['phone']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
</html>
