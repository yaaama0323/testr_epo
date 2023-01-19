<?php
if (empty($_SERVER["HTTP_REFERER"])) {
    //リダイレクト
    header('Location: contact.php');
  }
?>

<?php
if (empty($_SERVER["HTTP_REFERER"])) {
    //リダイレクト
    header('Location: contact.php');
  }
	session_start();
	function e($str) {
		return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5, 'UTF-8');
	}

  include('db-conect.php');
  try{
    if(mysqli_connect_errno()){
      throw new Exception();
    }else{
      //DB接続成功
      mysqli_set_charset($link, "utf8");
      // プリペアドステートメントを作成
      if($stmt = mysqli_prepare($link, "INSERT INTO contacts (name, kana, tel, email, body) VALUES (?,?,?,?,?)")){
        // マーカにパラメータをバインド
        mysqli_stmt_bind_param($stmt, "sssss", $name, $kana, $tel, $email, $body);
        // パラメータの設定
        $name = $_SESSION['name'];
        $kana = $_SESSION['furiganaName'];
        $tel = $_SESSION['tel'];
        $email = $_SESSION['mail'];
        $body = $_SESSION['mes'];
        // クエリを実行
        mysqli_stmt_execute($stmt);
        // ステートメントを閉じる
        mysqli_stmt_close($stmt);
        // MySQLの切断
        mysqli_close($link);
        $_SESSION = array();
        session_destroy();
      }
		}
	}catch(Exception $e){
    header("Location: contact.php");
  }
?>

<?php include("header.php"); ?>

<script>
  $(function(){
    $('.header').addClass('black-contact');
  });
</script>
<div class="complete">
  <h4>お問い合わせ</h4>
  <div class="completeForm">
    <p>お問い合わせ頂きありがとうございます。</P>
    <p>送信頂いた件につきましては、当社より折り返しご連絡を差し上げます。</P>
    <p>なお、ご連絡までに、お時間を頂く場合もございますので予めご了承ください。</P>
    <a href="index.php">トップへ戻る</a>
  </div>
</div>

<?php include("footer.php"); ?>
