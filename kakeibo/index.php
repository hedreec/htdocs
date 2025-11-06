
<?php
require_once __DIR__ . '/db.php';
$ok = isset($_GET['ok']);
$ng = isset($_GET['ng']) ? $_GET['ng'] : '';
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>かんたん家計簿（最小・レイアウト修正版）</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
  <h1>かんたん家計簿（最小）</h1>
  <?php if ($ok): ?><div class="ok">保存しました。</div><?php endif; ?>
  <?php if ($ng): ?><div class="ng"><?= h($ng) ?></div><?php endif; ?>

  <div class="card">
    <form method="post" action="save.php">
      <div class="grid head">
        <div>日付</div><div>カテゴリ</div><div>場所</div><div>金額</div><div></div>
      </div>
      <div id="rows">
        <div class="grid row">
          <div><input type="date" name="event_date[]" required value="<?= h(date('Y-m-d')) ?>"></div>
          <div>
            <select name="category[]">
              <option>交通費</option><option>飲食</option><option>買い物</option><option>その他</option>
            </select>
          </div>
          <div><input type="text" name="place[]" required placeholder="例：バス / 牛丼 など"></div>
          <div><input type="number" name="amount[]" min="1" step="1" required></div>
          <div><button type="button" class="btn remove" title="行を削除">−</button></div>
        </div>
      </div>

      <div class="action-bar">
        <button type="button" id="add" class="btn">＋ 行を追加</button>
        <button type="submit" class="btn">登録</button>
        <a href="list.php" class="to-list">一覧を見る →</a>
      </div>
      <div class="small">※ すべての行をまとめて保存します</div>
    </form>
  </div>
</div>
<script src="app.js"></script>
</body>
</html>
