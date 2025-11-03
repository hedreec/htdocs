<?php
require_once __DIR__.'/db.php';

$q = trim($_GET['q'] ?? '');
$sql = 'SELECT * FROM contacts';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE name LIKE ? OR address LIKE ? OR email LIKE ? OR phone LIKE ?';
    $like = '%'.$q.'%';
    $params = [$like, $like, $like, $like];
}
$sql .= ' ORDER BY id DESC';

$rows = db()->prepare($sql);
$rows->execute($params);
$rows = $rows->fetchAll();
?><!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>一覧 - contactsdb</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin: 24px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border:1px solid #ddd; padding:8px; }
    th { background:#f6f6f6; text-align: left; }
    .row { display:flex; align-items:center; gap:8px; margin-bottom:12px; }
    input[type="text"]{ padding:8px; width: 240px; }
    a.button { display:inline-block; padding:6px 10px; border:1px solid #ccc; border-radius:8px; text-decoration:none; }
  </style>
</head>
<body>
  <h1>一覧</h1>
  <div class="row">
    <form method="get" action="list.php">
      <input type="text" name="q" value="<?= htmlspecialchars($q, ENT_QUOTES, 'UTF-8') ?>" placeholder="キーワード検索">
      <button type="submit">検索</button>
      <a class="button" href="index.php">メニューへ</a>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th><th>名前</th><th>郵便番号</th><th>住所</th><th>電話</th><th>メール</th><th>作成日</th><th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$rows): ?>
        <tr><td colspan="8" style="text-align:center;color:#666;">データがありません</td></tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= htmlspecialchars($r['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['postal_code'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['address'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['phone'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['email'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($r['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
              <a class="button" href="delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('削除しますか？');">削除</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
