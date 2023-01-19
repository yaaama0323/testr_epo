<?php
$dsn = 'mysql:host=localhost;dbname=cafe;chaeset=utf8';
$user = 'root';
$pass = 'root';
$sql = "SELECT * FROM `contacts`";
	$link = mysqli_connect('localhost', 'root', 'root', 'cafe');
try {
  $dbh = new PDO($dsn,$user,$pass,[
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
}catch(PDOException $e){
  echo "接続失敗". $e->getMessage();
  exit();
};
?>
