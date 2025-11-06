
<?php
require_once __DIR__ . '/db.php';

$rows = db()->query('SELECT * FROM records ORDER BY event_date DESC, id DESC LIMIT 200')->fetchAll();

$total = 0;
foreach ($rows as $r) $total += (int)$r['amount'];
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>一覧 - かんたん家計簿</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1>一覧（最新200件）</h1>
  <div class="card">
    <div>合計：<?= number_format($total) ?> 円</div>
    <table style="margin-top:8px">
      <thead>
        <tr><th>日付</th><th>カテゴリ</th><th>場所</th><th>金額</th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= h($r['event_date']) ?></td>
            <td><?= h($r['category']) ?></td>
            <td><?= h($r['place']) ?></td>
            <td><?= number_format((int)$r['amount']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div style="margin-top:8px"><a href="index.php">← 入力に戻る</a></div>
  </div>
</div>
</body>
</html>
