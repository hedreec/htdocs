<?php
?><!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>新規登録 - contactsdb</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin: 24px; }
    form { display:grid; gap:12px; max-width: 520px; }
    label { display:grid; gap:6px; }
    input, button { padding:10px; font-size:16px; }
    .row { display:flex; gap:8px; }
    .hint { color:#666; font-size: 12px; }
  </style>
</head>
<body>
  <h1>新規登録</h1>
  <form action="create.php" method="post" novalidate>
    <label>名前（必須）
      <input type="text" name="name" required>
    </label>

    <div class="row">
      <label style="flex:1">郵便番号（ハイフン可）
        <input type="text" name="postal_code" id="postal_code" placeholder="1000001 または 100-0001">
      </label>
      <button type="button" id="zipToAddr">住所自動</button>
    </div>
    <div class="hint">※ 「住所自動」はZipCloud APIを利用（オンライン環境で動作）</div>

    <label>住所
      <input type="text" name="address" id="address">
    </label>
    <label>電話
      <input type="text" name="phone" placeholder="090-xxxx-xxxx">
    </label>
    <label>メール
      <input type="email" name="email" placeholder="example@example.com">
    </label>

    <div class="row">
      <button type="submit">保存</button>
      <a href="index.php" style="padding:10px 14px; border:1px solid #ccc; border-radius:8px; text-decoration:none;">戻る</a>
    </div>
  </form>

<script>
document.getElementById('zipToAddr').addEventListener('click', async () => {
  const zip = document.getElementById('postal_code').value.replace(/[^0-9]/g, '');
  if (zip.length !== 7) { alert('郵便番号は7桁で入力してください'); return; }
  try {
    const res = await fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + zip);
    const data = await res.json();
    if (data && data.results && data.results[0]) {
      const r = data.results[0];
      const addr = r.address1 + r.address2 + r.address3;
      document.getElementById('address').value = addr;
    } else {
      alert('住所が見つかりませんでした');
    }
  } catch (e) {
    alert('住所検索に失敗しました：' + e);
  }
});
</script>
</body>
</html>
