<script>
        $(function(){
            $('.header').addClass('black-contact');
        });
</script>

 <?php
   session_start();
   $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'null';
   function e($str) {
     return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5, 'UTF-8');
   }
   $_SESSION['name'] = e($_POST['name']);
   $_SESSION['furiganaName'] = e($_POST['furiganaName']);
   $_SESSION['tel'] = e($_POST['tel']);
   $_SESSION['mail'] = e($_POST['mail']);
   $_SESSION['mes'] = e($_POST['mes']);
 ?>

<?php include("header.php"); ?>

<?php
if (empty($_SERVER["HTTP_REFERER"])) {
    //リダイレクト
    header('Location: contact.php');
  }
?>

<form action="complete.php" method="post" name="form">
    <div class="confirm">
      <h4>お問い合わせ</h4>
      <div class="confirmForm">
        <div id="word">
          <p>下記の内容をご確認の上送信ボタンを押してください</p>
          <p>内容を訂正する場合は戻るを押してください。</p>
        </div>
        <div id="contents">
          <label>氏名</label>
          <p><?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");?></p>
          <label>フリガナ</label>
          <p><?php echo htmlspecialchars($_POST['furiganaName'], ENT_QUOTES, "UTF-8");?></p>
          <label>電話番号</label>
          <p><?php echo htmlspecialchars($_POST['tel'], ENT_QUOTES, "UTF-8");?></p>
          <label>メールアドレス</label>
          <p><?php echo htmlspecialchars($_POST['mail'], ENT_QUOTES, "UTF-8");?></p>
          <label>お問い合わせ内容</label>
          <p style="white-space: pre-wrap;"><?php echo htmlspecialchars($_POST['mes'], ENT_QUOTES, "UTF-8");?></p>
        </div>
      </div>
      <input type="hidden" name="name" value=<?php echo $_POST['name'] ?>>
      <input type="hidden" name="furiganaName" value=<?php echo $_POST['furiganaName'] ?>>
      <input type="hidden" name="tel" value=<?php echo $_POST['tel'] ?>>
      <input type="hidden" name="mail" value=<?php echo $_POST['mail'] ?>>
      <textarea style="display:none" id="mes" name="mes" ><?php if( !empty($_POST['mes']) ){ echo $_POST['mes']; } ?></textarea>
      <div id="button">
        <input class="send" type="submit" VALUE="送信" name='send-button'>
        <input class="return" type="submit" VALUE="戻る" formaction="contact.php">
      </div>
    </div>
</form>

<?php include("footer.php"); ?>
