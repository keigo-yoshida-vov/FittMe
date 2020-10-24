<?php
require("config/config.php");
require_once("model/User.php");
if(isset($_GET['change_id'])) {
  $id = $_GET["change_id"];
  $name = $_GET["change_name"];
  $kana = $_GET["change_kana"];
  $tel = $_GET["change_tel"];
  $mail = $_GET["change_mail"];
  $place_id = $_GET["change_place"];
  $updated_at = $_GET["updated"];
  function h($str){
    if(is_array($str)){
       return array_map('h', $str);
    }else{
      return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
  }
  // tryにPDOの処理を記述
  try {
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    //更新処理
      $user->updateM($id);
      flash('default', '　　変更しました');
      header('Location: http://localhost/myphp/index.php');
  // エラー（例外）が発生した時の処理を記述
  }catch (PDOException $e) {
    require_once("disconnect.php");
  }
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約サイト - 会員情報</title>
<link rel="stylesheet" type="text/css" href="css/info.css">
<script>
$(function(){
  user_check();
});
function user_check(){
  $("#userinfo_change").on('click', function(){
    $('.popup_userinfo').addClass('show_user').fadeIn();
    $.ajax({
       // 送信方法
       type: "POST",
       // 送信先ファイル名
       url: "info_ajax.php",
       // 受け取りデータの種類
       datatype: "json",
       // 送信データ
       data: {
           "id" : $("#userid").val()
       },
       // 通信が成功した時
       success: function(data) {
         $('#info_id_text1').html("<p>" + data.id + "</p>");
         $('#info_id').html("<input type='hidden' value='" + data.id + "' name='change_id'></input>");
         $('#info_name').html("<input value='" + data.name + "' name='change_name'></input>");
         $('#info_kana').html("<input value='" + data.kana + "' name='change_kana'></input>");
         $('#info_tel').html("<input value='" + data.tel + "' name='change_tel'></input>");
         $('#info_mail').html("<input value='" + data.mail + "' name='change_mail'></input>");
         $('#info_place').html("<input value='" + data.place_id + "' name='change_place'></input>");
           // console.log("通信成功");
           // console.log(data);
       },
        // 通信が失敗した時
       error: function(data) {
         $('#error_check2').html("<p>取得できませんでした。管理者に連絡してください<p>");
           // console.log("通信失敗");
           // console.log(data);
       }
    });
    $('#user_close').on('click',function(){
      $('.popup_userinfo').fadeOut();
    });
  })
};
</script>
</head>
<body>
  </header>
  <main>
    <section id="info_sec1">
      <div id="info_menu">
        <div id="info_title">
          <p>《　会員情報変更　》</p>
        </div><!-- /info_menu_title -->
        <div id="userinfo_ce">
          <input type="button" class="btn btn-success" id="userinfo_change" value="詳細を確認する"></input>
        </div>
        <p id="error_info"></p>
        <input type="hidden" id="userid" value="<?php echo $_SESSION["id"]; ?>"></input>
        <div class="popup_userinfo">
          <div class="userinfo_contents">
            <form method="get" action="index.php">
              <p>会員情報を変更してください。</p>
              <div id="error_check2"></div>
              <div class="result">
                <p>お客様ID　　　　：　</p>
                <div id="info_id_text1"></div>
                <div id="info_id"></div>
              </div>
              <div class="result">
                <p>お名前　　　　　：　</p>
                <div id="info_name"></div>
              </div>
              <div class="result">
                <p>フリガナ　　　　：　</p>
                <div id="info_kana"></div>
              </div>
              <div class="result">
                <p>お電話番号　　　：　</p>
                <div id="info_tel"></div>
              </div>
              <div class="result">
                <p>メールアドレス　：　</p>
                <div id="info_mail"></div>
              </div>
              <div class="result">
                <p>活動拠点　　　　：　</p>
                <div id="info_place"></div>
                <p>　1:新宿フィットネス , 2:渋谷ジム<p>
              </div>
              <input type="hidden" name="updated" value="<?php echo date('Y/m/d'); ?>"></input>
            <div id="button_area">
              <button type="submit" class="btn btn-success" id="change">変更する</button>
            </form>
              <button type="button" class="btn btn-success" id="user_close">close</button>
            </div>
          </div>
        </div>
      </div><!-- /info_menu -->
    </section><!-- /info_sec1 -->
    <section id="info_sec2">
    </section><!-- /info_sec2 -->
  </main>
</body>
</html>
