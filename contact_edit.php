<?php
	session_start();
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'null';

	if(preg_match("/contact.php$/", $referer)){
		$_SESSION = array();
		session_destroy();
		session_start();
		$_SESSION['id'] = $_POST['id'];
  }else if(preg_match("/contact_edit.php$/", $referer)){
    if(empty($_SESSION)){
      header("Location: contact.php");
    }
	}else{
    header("Location: contact.php");
    exit;
  }
  include('db-conect.php');
  try{
    if(mysqli_connect_errno()){
      throw new Exception();
    }else{
      mysqli_set_charset($link, "utf8");
      if($stmt = mysqli_prepare($link, "SELECT * FROM contacts WHERE id = ?")){
        mysqli_stmt_bind_param($stmt, "i", $id);
        $id = $_SESSION['id'];
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
      }
    }
  }catch(Exception $e){
    header("Location: contact.php");
  }

	if(!empty($_SESSION['name'])){
		$name = $_SESSION['name'];
	}else if(!empty($row['name'])){
		$name = $row['name'];
	}else{
    $name = "";
  }
	if(!empty($_SESSION['furiganaName'])){
		$furiganaName = $_SESSION['furiganaName'];
	}else if(!empty($row['kana'])){
		$furigana = $row['kana'];
	}else{
    $furigana = "";
  }
	if(!empty($_SESSION['tel'])){
		$tel = $_SESSION['tel'];
	}else if(!empty($row['tel'])){
		$tel = $row['tel'];
	}else{
    $tel = "";
  }
	if(!empty($_SESSION['mail'])){
		$email = $_SESSION['mail'];
	}else if(!empty($row['email'])){
		$email = $row['email'];
	}else{
    $email = "";
  }
	if(!empty($_SESSION['mes'])){
		$mes = $_SESSION['mes'];
	}else if(!empty($row['body'])){
		$mes = $row['body'];
	}else{
    $mes = "";
  }
?>

<?php include("header.php"); ?>
<script>
  $(function(){
    $('.header').addClass('black-contact');
  });

  $(function(){
    const button = document.getElementById('button');
    const form = document.getElementById("form")
    const name = document.getElementById('name');
    const furiganaName = document.getElementById('furiganaName');
    const tel = document.getElementById('tel');
    const mail = document.getElementById('mail');
    const mes = document.getElementById('mes');
    const reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}.[A-Za-z0-9]{1,}$/;

      button.addEventListener('click', function(event) {
        let message = [];
          if(name.value ==""){
            message.push("氏名は必須入力です。");
            }
          if(name.value.length>=10){
            message.push("10文字以内でご入力ください。");
          }
          if(furiganaName.value==""){
            message.push("\nフリガナは必須入力です。");
          }
          if(furiganaName.value.length>=11){
            message.push("10文字以内でご入力ください。");
          }


          if (!($("#tel").val()==="") && !($("#tel").val().match(/^[0-9]+$/))){
            message.push("\n電話番号は0-9の数字のみでご入力ください。");
          }




          if(!reg.test(mail.value) || mail.value==""){
            message.push("\nメールアドレスは正しくご入力ください。");
          }
          if(mes.value==""){
            message.push("\nお問い合わせ内容は必須入力です。");
          }
          if(message.length > 0){
            alert(message);
              return;
          }
          else{
            $("form").attr("action","edit_complete.php");
          }

        });
      });
</script>

<?php
    if (isset($_POST["submitted"])) {
        if($_POST['name'] == ''){
            $nameError1 = "氏名は必須入力です。10文字以内でご入力ください。";
            $nameError2 = '';
        }else if(mb_strlen($_POST['name'])>=10){
            $nameError1 = '';
            $nameError2 = "10文字以内でご入力ください。";
        }else{
            $nameError1 = '';
            $nameError2 = '';
        }

        if($_POST['furiganaName'] == ''){
            $furiganaNameError1 = "フリガナは必須入力です。10文字以内でご入力ください。";
            $furiganaNameError2 = '';
        }else if(mb_strlen($_POST['furiganaName'])>=10){
            $furiganaNameError1 = '';
            $furiganaNameError2 ="10文字以内でご入力ください。";
        }else{
            $furiganaNameError1 = '';
            $furiganaNameError2 = '';
        }

        if(!preg_match("/^[0-9]+$/",$_POST['tel']) && $_POST['tel'] !== ''    )    {
            $telError = "電話番号は0-9の数字のみでご入力ください。";
        }else{
            $telError = '';
        }

        if(!preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i',$_POST['mail'])){
            $mailError = "メールアドレスは正しくご入力ください。";
        }else{
            $mailError = '';
        }

        if($_POST['mes'] == ''){
            $messageError = "お問い合わせ内容は必須入力です。";
        }else{
            $messageError = '';
        }
    }
?>

<div class="contact">
    <h4>お問い合わせ 編集画面</h4>
    <div class="contentsForm">
        <p id="word">下記の項目を修正の上送信ボタンを押してください</p>
        <p>送信いただいた件につきましては、当社より折り返しのご連絡を差し上げます。</p>
        <p>なお、ご連絡までに、お時間をいただく場合もございますので予めご了承ください。</p>
        <p><span>*</span>は必須項目となります。</p>
        <div id="message"></div>
        <form id="form" action="" method="post" name="form" >
            <div>
                氏名<span>*</span><br>
                <?php
                    if (isset($_POST["submitted"])) {
                        echo '<font color="red">'.$nameError1 .'</font>';
                        echo '<font color="red">'.$nameError2 .'</font>';
                    }
                ?>
                <input id="name" type="text" name="name" value="<?= $name ?>"  placeholder="山田太郎">
            </div>
            <div>
                フリガナ<span>*</span><br>
                <?php
                    if (isset($_POST["submitted"])) {
                        echo '<font color="red">'.$furiganaNameError1 .'</font>';
                        echo '<font color="red">'.$furiganaNameError2 .'</font>';
                    }
                ?>
                <input id="furiganaName" type="text" name="furiganaName" value="<?= $furigana ?>" placeholder="ヤマダタロウ">
            </div>
            <div>
                電話番号<br>
                <?php
                    if (isset($_POST["submitted"])) {
                        echo '<font color="red">'.$telError .'</font>';
                    }
                ?>
                <input id="tel" type="tel" name="tel" value="<?= $tel ?>" placeholder="09012345678">
            </div>
            <div>
                メールアドレス<span>*</span><br>
                <?php
                    if (isset($_POST["submitted"])) {
                        echo '<font color="red">'.$mailError .'</font>';
                    }
                ?>
                <input id="mail" type="email" name="mail" value="<?= $email ?>"  placeholder="test@test.co.jp">
            </div>
            <div>
                <p id="word">お問い合わせ内容をご記入ください<span>*</span></p>
                <?php
                    if (isset($_POST["submitted"])) {
                        echo '<font color="red">'.$messageError .'</font>';
                    }
                ?>
                <textarea id="mes" name="mes" ><?= $mes ?></textarea>
            </div>
            <input type="hidden" name="submitted" value="true">
            <input id="button" class="button" type="submit" value="送信" >
        </form>
    </div>
</div>


</html>
