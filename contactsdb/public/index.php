<?php
?><!doctype html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>contactsdb</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; margin: 24px; }
    a.button { display:inline-block; padding:10px 14px; border:1px solid #ccc; border-radius:8px; text-decoration:none; }
    .stack { display:flex; gap:12px; flex-wrap: wrap; }
  </style>
</head>
<body>
  <h1>contactsdb</h1>
  <div class="stack">
    <a class="button" href="new.php">＋ 新規登録</a>
    <a class="button" href="list.php">📋 一覧を見る</a>
    <a class="button" href="export_csv.php">⬇️ CSVエクスポート</a>
  </div>
  <p style="margin-top:16px;color:#555;">学習用の最小サンプルです。まずは「新規登録」からどうぞ。</p>
</body>
</html>
