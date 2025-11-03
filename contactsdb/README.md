# contactsdb（PHP + MySQL サンプル）

このサンプルは、**名前・郵便番号・住所・電話・メール**を登録して一覧表示する最小構成の学習用プロジェクトです。  
**PDO** を使った安全なDB接続、簡単な入力バリデーション、削除、CSVエクスポートを含みます。

## 1. セットアップ（XAMPP を例に）
1. MySQL を起動（XAMPPの「Start」）
2. `schema.sql` を **phpMyAdmin** などで実行し、DBとテーブルを作成
3. `public/config.php` のDB接続情報をあなたの環境に合わせて編集
4. `public` フォルダを XAMPP のドキュメントルート（例: `/Applications/XAMPP/xamppfiles/htdocs/contactsdb`）に配置
5. ブラウザで `http://localhost/contactsdb/index.php` を開く

> 既定の接続情報（必要に応じて編集）:
> - ホスト: `127.0.0.1`
> - データベース: `contactsdb`
> - ユーザー: `root`
> - パスワード: 空（XAMPPの既定）
> - 文字コード: `utf8mb4`

## 2. 構成
```
contactsdb/
├─ schema.sql            # DBとテーブル作成
└─ public/
   ├─ config.php         # DB接続設定
   ├─ db.php             # PDO生成の共通関数
   ├─ index.php          # メニュー
   ├─ new.php            # 登録フォーム
   ├─ create.php         # 登録処理
   ├─ list.php           # 一覧表示（検索付）
   ├─ delete.php         # 削除
   └─ export_csv.php     # CSVエクスポート
```

## 3. 住所自動補完（任意）
郵便番号から住所を自動補完するために、総務省系の **ZipCloud API** を利用しています。  
オフラインでも使えるように手入力は可能です。ネット接続がない環境では自動補完は動作しません。

## 4. よくあるエラー
- **`SQLSTATE[HY000] [1049] Unknown database 'contactsdb'`** → `schema.sql` を実行してDBを作ってください
- **`Access denied for user`** → `config.php` のユーザー/パスワードを環境に合わせてください
- 一覧が空 → まずは `new.php` から登録してください

学習の狙い：
- フォーム → バリデーション → DB保存 → 一覧の基本動線
- PDOの基本（プリペアドステートメント/例外）
- 文字コード・タイムゾーンの取り扱い
