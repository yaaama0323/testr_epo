<link rel="stylesheet" href="style.css">
<?php
  $sql = "SELECT * FROM contacts;";
  require('db-conect.php');
  try{
    if(mysqli_connect_errno()){
      throw new Exception();
    }else{
      //DB接続成功
      mysqli_set_charset($link, "utf8");
      $res = mysqli_query($link, $sql);
      if ($res) {
        $num_rows = mysqli_num_rows($res);
      } else {
        die(mysqli_error($link));
      }
      mysqli_close($link);
    }
  }catch(Exception $e){
    echo  "接続失敗:" . mysqli_connect_error() . "\n";
  }
?>

<table>
  <?php if(!empty($num_rows) == 0): ?>
    <?php else : ?>
    <tr>
      <th>氏名</th>
      <th>フリガナ</th>
      <th>電話番号</th>
      <th>メールアドレス</th>
      <th>問い合わせ内容</th>
      <th></th>
      <th></th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($res)): ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['kana'] ?></td>
        <td><?= $row['tel'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= nl2br($row['body']) ?></td>
        <td>
          <form action="contact_edit.php" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button type="submit">編集</button>
          </form>
        </td>
        <td>
          <form action="delete_complete.php" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button class="delete" type="submit">削除</button>
          </form>
        </td>
      </tr>
    <?php endwhile ?>

  <?php endif; ?>


</table>

<script>
$('.delete').click(function(){
    if(!confirm('本当に削除しますか？')){
        /* キャンセルの時の処理 */
        return false;
    }else{
        /*　OKの時の処理 */
        location.href = 'delete_complete.php';
    }
});
</script>
