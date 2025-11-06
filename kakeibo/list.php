
<?php
require_once __DIR__ . '/db.php';
$rows = db()->query('SELECT * FROM records ORDER BY event_date DESC, id DESC LIMIT 200')->fetchAll();
$total = 0; foreach ($rows as $r) $total += (int)$r['amount'];
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
    <div class="grid head" style="margin-top:8px">
      <div>日付</div><div>カテゴリ</div><div>場所</div><div>金額</div><div></div>
    </div>
    <?php foreach ($rows as $r): ?>
      <div class="grid row">
        <div><?= h($r['event_date']) ?></div>
        <div><?= h($r['category']) ?></div>
        <div><?= h($r['place']) ?></div>
        <div><?= number_format((int)$r['amount']) ?></div>
        <div></div>
      </div>
    <?php endforeach; ?>
    <div style="margin-top:8px"><a href="index.php">← 入力に戻る</a></div>
  </div>
</div>
</body>
</html>
