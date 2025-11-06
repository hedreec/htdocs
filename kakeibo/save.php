
<?php
require_once __DIR__ . '/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$dates = $_POST['event_date'] ?? [];
$cats  = $_POST['category'] ?? [];
$places= $_POST['place'] ?? [];
$amts  = $_POST['amount'] ?? [];
$cnt = min(count($dates), count($cats), count($places), count($amts));
if ($cnt === 0) { header('Location: index.php?ng=' . urlencode('行がありません。')); exit; }
$pdo = db(); $pdo->beginTransaction();
try {
  $stmt = $pdo->prepare('INSERT INTO records(event_date, category, place, amount) VALUES (?,?,?,?)');
  $n=0;
  for ($i=0;$i<$cnt;$i++) {
    $d=$dates[$i]??''; $c=$cats[$i]??''; $p=trim($places[$i]??''); $a=$amts[$i]??'';
    if (!$d || !preg_match('/^\d{4}-\d{2}-\d{2}$/',$d)) continue;
    if (!in_array($c,['交通費','飲食','買い物','その他'],true)) continue;
    if ($p==='') continue;
    if (!ctype_digit((string)$a) || (int)$a<=0) continue;
    $stmt->execute([$d,$c,$p,(int)$a]); $n++;
  }
  $pdo->commit();
  header('Location: index.php' . ($n? '?ok=1' : '?ng=' . urlencode('有効な行がありませんでした。')));
} catch (Throwable $e) {
  $pdo->rollBack(); header('Location: index.php?ng=' . urlencode('保存に失敗: ' . $e->getMessage()));
}
