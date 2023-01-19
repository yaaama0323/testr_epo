<?php
	include('db-conect.php');
  try{
    if(mysqli_connect_errno()){
      throw new Exception();
    }else{
			//DB接続成功
			mysqli_set_charset($link, "utf8");
			// プリペアドステートメントを作成
			if($stmt = mysqli_prepare($link, "DELETE FROM contacts WHERE id = ?")){
				// マーカにパラメータをバインド
				mysqli_stmt_bind_param($stmt, "i", $id);
				// パラメータの設定
				$id = $_POST['id'];
				// クエリを実行
				mysqli_stmt_execute($stmt);
				// ステートメントを閉じる
				mysqli_stmt_close($stmt);
				// MySQLの切断
				mysqli_close($link);
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
<body>
  <div class="complete">
      <h4>お問い合わせ 削除完了</h4>
      <div class="completeForm">
          <p>削除が完了しました。</P>
          <a href="index.php">トップへ戻る</a>
      </div>
  </div>
    <?php include('footer.php'); ?>
</body>

</html>
