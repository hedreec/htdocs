// 新規作成
// Norifumi Konishi
<?php
// DB接続情報
$host = 'localhost';
$dbname = 'sampledb';
$user = 'root';
$pass = '';

try {
    // PDO接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ DB接続エラー: " . $e->getMessage());
}

// 登録処理
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if ($name === '' || $email === '') {
        $message = '⚠ 名前とメールアドレスを入力してください。';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            $message = '✅ 登録が完了しました！';
        } else {
            $message = '❌ 登録に失敗しました。';
        }
    }
}

// データ取得
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録フォーム</title>
    <style>
        body {
            font-family: "Hiragino Sans", sans-serif;
            margin: 40px;
            background-color: #f8f9fa;
        }
        h1 { color: #333; }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin: 10px 0;
            color: #333;
        }
        table {
            border-collapse: collapse;
            margin-top: 30px;
            width: 600px;
        }
        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h1>ユーザー登録フォーム</h1>

<form method="post" action="">
    <label>名前：</label><br>
    <input type="text" name="name" required><br>

    <label>メールアドレス：</label><br>
    <input type="email" name="email" required><br>

    <input type="submit" value="登録">
</form>

<div class="message"><?= htmlspecialchars($message) ?></div>

<h2>登録済みユーザー一覧</h2>
<table>
    <tr><th>ID</th><th>名前</th><th>メールアドレス</th><th>登録日時</th></tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['created_at'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
