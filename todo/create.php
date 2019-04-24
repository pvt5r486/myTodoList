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

//參數化
$sql = 'INSERT INTO todos (content, isCompelete, createdDate, `order`)
        VALUES (:content, :isCompelete, :createdDate, :order)';
$statement = $pdo->prepare($sql);
// 參數, 對映內容, 設定格式
$statement -> bindValue(':content', $_POST['content'], PDO::PARAM_STR);
$statement -> bindValue(':isCompelete', 0, PDO::PARAM_INT);
$statement -> bindValue(':createdDate', getDatetime("Asia/Taipei"), PDO::PARAM_STR);
$statement -> bindValue(':order', $_POST['order'], PDO::PARAM_INT);
// 執行
$result = $statement -> execute();

// 回傳結果
if($result) {
  // 一定要有回傳東西 ajax 的 function 才會執行
  echo json_encode(['id' => $pdo->lastInsertId()]);
}
function getDatetime($setTimeZone){
  date_default_timezone_set($setTimeZone);
  return date("Y/m/d H:i:s");
}
?>