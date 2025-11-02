<?php
// DB接続情報
$host = 'localhost';
$dbname = 'sampledb';
$user = 'root';  // XAMPPの場合はrootでOK
$pass = '';      // パスワードは空欄が多い（環境による）

try {
    // PDOで接続
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ データベースに接続しました！<br>";

    // データ取得
    $stmt = $pdo->query("SELECT * FROM users");
    echo "<h3>登録ユーザー一覧:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['id'] . ": " . htmlspecialchars($row['name']) . "（" . htmlspecialchars($row['email']) . "）<br>";
    }

    // 新規登録サンプル
    $newName = "田中一郎";
    $newEmail = "ichiro@example.com";
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->bindParam(':name', $newName);
    $stmt->bindParam(':email', $newEmail);
    $stmt->execute();
    echo "<br>✅ 新規ユーザーを追加しました！";

} catch (PDOException $e) {
    echo "❌ エラー: " . $e->getMessage();
}
?>
