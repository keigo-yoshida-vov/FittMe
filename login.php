<?php
session_start();
$_SESSION = array();
session_destroy();
//セッションを使うことを宣言
session_start();
require_once("config/config.php");
require_once("model/User.php");
//ログイン状態の場合ログイン後のページにリダイレクト
if (isset($_SESSION["login"])) {
  session_regenerate_id(TRUE);
  header("Location: index.php");
  exit();
}
//postされて来なかったとき
if (count($_POST) === 0) {
  $message = "";
}
//postされて来た場合
else {
  $id = $_POST["id"];
  $hash_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
  //ユーザー名またはパスワードが送信されて来なかった場合
  if(empty($_POST["id"]) || empty($_POST["password"])) {
    $message = "IDとパスワードを入力してください";
  }else {
    //post送信されてきたユーザー名がデータベースにあるか検索
    try {
      $user = new User($host, $dbname, $user, $pass);
      $user->connectDb();

      $result = $user->findByM($id);
    }catch (PDOExeption $e) {
      require("disconnect.php");
    }
  //検索したユーザー名に対してパスワードが正しいかを検証
  //正しくないとき
    if (!password_verify($result['pass'], $hash_pass)) {
      $message="ユーザーIDかパスワードが違います";
    }else {
      session_regenerate_id(TRUE); //セッションidを再発行
      $_SESSION["id"] = $_POST['id'];
      $_SESSION["password"] = $_POST['password']; //セッションにパスワードを登録
      $_SESSION["name"] = $result["name"];
      header("Location: index.php"); //マイページへリダイレクト
      exit();
    }
  }
}

$message = htmlspecialchars($message);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログインページ</title>
<link rel="icon" href="img/favicon.ico">
<link href="css/login.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Kosugi+Maru&display=swap" rel="stylesheet">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$('head').append(
'<style>body{display:none;}',
'<style>#load1{display:none;}',
'<style>#load2{display:none;}',
'<style>#load3{display:none;}',
'<style>#load4{display:none;}',
'<style>#load5{display:none;}',
'<style>#load6{display:none;}'
);
$(window).on("load", function() {
$('body').delay(50).fadeIn("slow");
$('#load1').delay(100).fadeIn("slow");
$('#load2').delay(400).fadeIn("slow");
$('#load3').delay(600).fadeIn("slow");
$('#load4').delay(800).fadeIn("slow");
$('#load5').delay(1000).fadeIn("slow");
$('#load6').delay(1200).fadeIn("slow");
});
</script>
</head>
<body>
  <div id="change_form">
    <a href="login_t.php"><button class="btn btn-outline-primary">トレーナーはこちら</button></a>
  </div>
  <div id="title">
    <p id="load1">F</p><p id="load2">i</p><p id="load3">t</p><p id="load4">t</p><p id="load5">M</p><p id="load6">e</p>
  </div>
<div class="message"><p><?php echo $message;?></p></div>
<div class="loginform">
  <form action="login.php" method="post">
    <ul>
    <li>ユーザーID：<input name="id" type="text"></li>
    <li>パスワード：<input name="password" type="password"></li>
    </ul>
    <div id="bu">
      <button name="送信" type="submit" class="btn btn-primary" id="buu">ログイン</button>
    </div>
  </form>
</div>
</body>
</html>
