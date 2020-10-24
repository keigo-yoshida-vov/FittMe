<?php
session_start();

//ログインされていない場合はログインページへ
if (!isset($_SESSION["id"], $_SESSION["password"], $_SESSION["name"])) {
 header("Location: login_t.php");
  exit();
}

//ログインされている場合は表示用メッセージを編集
$head_name = $_SESSION['name']."　様";
$head_name = htmlspecialchars($head_name);

function flash($type, $message){
  global $flash;
  $_SESSION['flash'][$type] = $message;
  $flash[$type] = $message;
}
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
unset($_SESSION['flash']);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約サイト - トレーナーマイページ</title>
<link rel="icon" href="img/favicon.ico">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Kosugi+Maru&display=swap" rel="stylesheet">
<!--jq -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script>
$('head').append(
'<style>body{display:none;}'
);
$(window).on("load", function() {
$('body').delay(20).fadeIn("slow");
});
$(function(){
    $(".flash").css({
      opacity:'1'
    });
    setTimeout(function(){
        $(".flash").animate({
          opacity:'0',
          display:'none'
        },1000);
    },1000);
});
</script>
</head>
<body>
<!-- header -->
  <?php
    require_once("header_t.php");
  ?>
  <main>
    <div id="main_wrappar">
      <?php
      foreach(array('default', 'error', 'warning') as $key) {
          if(strlen(@$flash[$key])){
      ?>
            <div class="flash">
                <?php echo $flash[$key] ?>
            </div>
      <?php
          }
      }
      ?>
<!-- reserve -->
      <section id="index_sec1">
        <?php
          require_once("reserve_t.php");
        ?>
      </section><!-- /index_t_sec1 -->
<!-- records -->
      <section id="index_sec2">
        <?php
          require_once("medical_records_t.php");
        ?>
      </section><!-- /index_t_sec1 -->
<!-- info -->
      <section id="index_sec3">
        <?php
          require_once("info_t.php");
        ?>
      </section><!-- /index_t_sec3 -->
      <div id="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25931.462790494792!2d139.67756681537796!3d35.66634258264217!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e2f18b0690b83ff!2z44K544K_44K444Kq44Ki44O844OgIOODkeODvOOCveODiuODq-ODiOODrOODvOODi-ODs-OCsOOCuOODoCDmuIvosLc!5e0!3m2!1sja!2sjp!4v1602832447915!5m2!1sja!2sjp" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d21487.264790827423!2d139.68590366273267!3d35.68782697717507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8c9ca59d969e6b7a!2zWU9TSElEQSBHWU0g5paw5a6_5bqX!5e0!3m2!1sja!2sjp!4v1602832622763!5m2!1sja!2sjp" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>
    </div><!-- /main_wrapper -->
  </main>
<!-- footer -->
  <?php
    require_once("footer_t.php");
  ?>
</body>
</html>
