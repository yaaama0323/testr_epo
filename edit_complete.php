<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>Lesson Sample Site</title>
  <link rel="stylesheet" href="style.css">
</head>


<?php include('db-conect.php'); ?>
<?php
	session_start();
	function e($str) {
		return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5, 'UTF-8');
	}
	$_SESSION['name'] = e($_POST['name']);
	$_SESSION['furiganaName'] = e($_POST['furiganaName']);
	$_SESSION['tel'] = e($_POST['tel']);
	$_SESSION['mail'] = e($_POST['mail']);
	$_SESSION['mes'] = e($_POST['mes']);

		try{
			if(mysqli_connect_errno()){
				throw new Exception();
			}else{
				mysqli_set_charset($link, "utf8");
				if($stmt = mysqli_prepare($link, "UPDATE contacts SET name = ?, kana = ?, tel = ?, email = ?, body = ? WHERE id = ?")){
					mysqli_stmt_bind_param($stmt, "sssssi", $name, $kana, $tel, $email, $body, $id);
					$name = $_SESSION['name'];
					$kana = $_SESSION['furiganaName'];
					$tel = $_SESSION['tel'];
					$email = $_SESSION['mail'];
					$body = $_SESSION['mes'];
					$id = $_SESSION['id'];
					mysqli_stmt_execute($stmt);
					mysqli_stmt_close($stmt);
					mysqli_close($link);
				}
			}
		}catch(Exception $e){
			header("Location: contact.php");
		}
		$_SESSION = array();
		session_destroy();
?>

<?php include("header.php"); ?>
<script>
    $(function(){
      $('.header').addClass('black-contact');
    });
</script>
<body>
  <div class="complete">
      <h4>お問い合わせ 編集完了</h4>
      <div class="completeForm">
          <p>編集が完了しました。</P>
          <a href="index.php">トップへ戻る</a>
      </div>
  </div>
    <?php include('footer.php'); ?>
  </div>
</body>
</html>
