<?php
require_once("config/config.php");
require_once("model/User.php");
// $user = new User($host, $dbname, $user, $pass);
// $user->connectDb();
$member_id = $_SESSION["id"];
$result = $user->rs($member_id);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約サイト - 会員様マイページ</title>
<link rel="stylesheet" type="text/css" href="css/medical_records.css">
<link rel="stylesheet" type="text/css" href="css/slick.css" />
<link rel="stylesheet" type="text/css" href="css/slick-theme.css" />
<script type="text/javascript" src="js/slick.min.js"></script>
<script>
// $(function() {

</script>
</head>
<body>
  <main>
    <section id="medical_records_sec1">
      <div id="medical_records_menu">
        <div id="medical_records_title">
          <p>《　カルテ　》</p>
        </div><!-- /medical_records_title -->
        <div id="medical_records_contents">
          <div id="medical_records_slider">
            <?php if($result == null){ ?>
              <p>カルテは未登録です</p>
            <?php }else { ?>
                <ul class="slider">
              <?php foreach ($result as $value) { ?>
                <li class="slick-item"><p>　<?php echo $value["day"]; ?></p><a href="<?php echo $value["img"]; ?>"><img src="<?php echo $value["img"]; ?>" class="medical_img"></img></a></li>
              <?php } ?>
            </ul>
            <?php } ?>
              </div>
          </div><!-- /medical_records_slider -->
        </div><!-- /medical_reserve_contents -->
      </div><!-- /medical_records_menu -->
    </section><!-- /medical_records_sec1 -->
    <section id="medical_records_sec2">
    </section><!-- /medical_records_sec2 -->
  </main>
</body>
</html>
