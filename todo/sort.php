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

$sql = 'UPDATE todos SET `order`=:order WHERE id=:id';
$statement = $pdo->prepare($sql);

foreach ($_POST['orderArray'] as $key => $orderArray){
  //參數化
  $statement -> bindValue(':order', $orderArray['newOrder'], PDO::PARAM_INT);
  $statement -> bindValue(':id', $orderArray['id'], PDO::PARAM_INT);
  $result = $statement -> execute();
}

// 回傳結果
if($result) {
  echo json_encode(['message' => 'success']);
} else {
  echo "ERROR";
}
?>