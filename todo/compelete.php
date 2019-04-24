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

// 找出
$sql = 'SELECT isCompelete FROM todos WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement -> execute();
$todo =  $statement -> fetch(PDO::FETCH_ASSOC);

// 回存
$sql = 'UPDATE todos SET isCompelete=:isCompelete WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement -> bindValue(':isCompelete', !$todo['isCompelete'], PDO::PARAM_INT);
$statement -> bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement -> execute();

// 回傳結果
if($result) {
  echo json_encode(['message' => 'success']);
} else {
  echo "ERROR";
}
?>