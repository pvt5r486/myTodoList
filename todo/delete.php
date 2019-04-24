<?php 
// 必須設定header 否則會被當成 HTML
header('Content-Type: application/json; charset=utf-8');
include('../dbAccount.php');
// 測試連線
try {
  $pdo = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
  echo "Database 連線失敗$e";
  exit;
}

if($_POST['id']) {
  $sql = 'DELETE FROM todos WHERE id=:id';
  $statement = $pdo->prepare($sql);
  $statement -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);
} else {
  $sql = 'DELETE FROM todos';
  $statement = $pdo->prepare($sql);
}
$result = $statement -> execute();

// 回傳結果
if($result) {
  echo json_encode(['message' => 'success']);
} else {
  echo 'error';
}
?>