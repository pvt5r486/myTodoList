<?php 
header('Content-Type: application/json; charset=utf-8');
include('../dbAccount.php');

try {
  $pdo = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
  echo "Database 連線失敗$e";
  exit;
}

$sql = 'SELECT * from todos ORDER BY `order` ASC';
$statement = $pdo->prepare($sql);
$result = $statement -> execute();
$todos = $statement -> fetchAll(PDO::FETCH_ASSOC);
if($result) {
  // 讓數字部分不會被轉換成文字
  echo json_encode($todos, JSON_NUMERIC_CHECK);
}
?>