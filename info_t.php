<?php
require("config/config.php");
require_once("model/User.php");
if($_GET){
  if(isset($_GET['new_name'])) {
    $name = $_GET["new_name"];
    $kana = $_GET["new_kana"];
    $tel = $_GET["new_tel"];
    $mail = $_GET["new_mail"];
    $password = $_GET["new_password"];
    $place_id = $_GET["new_place"];
    $created_at = $_GET["new_create"];
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

      //登録処理
      if($_GET) {
        $user->Memberadd($_GET);
        flash('default', '　　登録しました');
        header('Location: http://localhost/myphp/index_t.php');
      }
    // エラー（例外）が発生した時の処理を記述
    }catch (PDOException $e) {
      require_once("disconnect.php");
    }
  }
}
if($_POST){
  if(isset($_POST['delete_member_id'])) {
    $id = $_POST["delete_member_id"];
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

      //登録処理
      if($_POST) {
        $user->delete($id);
        flash('default', '　　削除しました');
        header('Location: http://localhost/myphp/index_t.php');
      }
    // エラー（例外）が発生した時の処理を記述
    }catch (PDOException $e) {
      require_once("disconnect.php");
    }
  }
}
if($_POST){
  if(isset($_POST['change_member_id'])) {
    $id = $_POST["change_member_id"];
    $name = $_POST["change_member_name"];
    $kana = $_POST["change_member_kana"];
    $tel = $_POST["change_member_tel"];
    $mail = $_POST["change_member_mail"];
    $place_id = $_POST["change_member_place"];
    $updated_at = $_POST["updated_at"];
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
      if($_POST){
        $user->update($id);
        flash('default', '　　変更しました');
        header('Location: http://localhost/myphp/index_t.php');
      }
    // エラー（例外）が発生した時の処理を記述
    }catch (PDOException $e) {
      require_once("disconnect.php");
    }
  }
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約サイト - 会員情報</title>
<link rel="stylesheet" type="text/css" href="css/info_t.css">
<script>
$(function(){
  info_form();
  infonew();
  infocheck();
  infodelete();
});
function info_form(){
  $("#userlist_info1").on("click", function(){
    var update_user = $("#userlist_info1 option:selected").val();
    $("#member_id_vali").val(update_user);
  });
  $("#userlist_info2").on("click", function(){
    var delete_user = $("#userlist_info2 option:selected").val();
    $("#member_id_delete").val(delete_user);
  });
};
function infonew(){
  $("#infonew").on('click', function(){
    $('.popup_info1').addClass('show_new').fadeIn();
    $('#close_info1').on('click',function(){
      $('.popup_info1').fadeOut();
    });
  });
};
function infocheck(){
  $("#infocheck").on('click', function(){
    $('.popup_info2').addClass('show_change').fadeIn();

    $.ajax({
       // 送信方法
       type: "POST",
       // 送信先ファイル名
       url: "info_t_ajax.php",
       // 受け取りデータの種類
       datatype: "json",
       // 送信データ
       data: {
           "id" : $('#member_id_vali').val()
       },
       // 通信が成功した時
       success: function(data) {
         $('#ajax_id_text1').html("<p>" + data.id + "</p>");
         $('#ajax_id').html("<input type='hidden' value='" + data.id + "' name='change_member_id'></input>");
         $('#ajax_name').html("<input value='" + data.name + "' name='change_member_name'></input>");
         $('#ajax_kana').html("<input value='" + data.kana + "' name='change_member_kana'></input>");
         $('#ajax_tel').html("<input value='" + data.tel + "' name='change_member_tel'></input>");
         $('#ajax_mail').html("<input value='" + data.mail + "' name='change_member_mail'></input>");
         $('#ajax_place').html("<input value='" + data.place_id + "' name='change_member_place'></input>");
           // console.log("通信成功");
           // console.log(data);
       },
        // 通信が失敗した時
       error: function(data) {
         $('#error_check1').html("<p>取得できませんでした。管理者に連絡してください<p>");
           // console.log("通信失敗");
           // console.log(data);
       }
    });
    $('#close_info2').on('click',function(){
      $('.popup_info2').fadeOut();
    });
  });
};
function infodelete(){
  $("#infodelete").on('click', function(){
    $('.popup_info3').addClass('show_delete').fadeIn();

    $.ajax({
       // 送信方法
       type: "POST",
       // 送信先ファイル名
       url: "info_t_ajax.php",
       // 受け取りデータの種類
       datatype: "json",
       // 送信データ
       data: {
           "delete_id" : $('#member_id_delete').val()
       },
       // 通信が成功した時
       success: function(data) {
         $('#ajax_id_text2').html("<input type='hidden' value='" + data.id + "' name='delete_member_id'></input>");
         $('#ajax_id_delete').html("<p>" + data.id + "</p>");
         $('#ajax_name_delete').html("<p>" + data.name + "</p>");
         $('#ajax_kana_delete').html("<p>" + data.kana + "</p>");
         $('#ajax_tel_delete').html("<p>" + data.tel + "</p>");
         $('#ajax_mail_delete').html("<p>" + data.mail + "</p>");
         $('#ajax_place_delete').html("<p>" + data.place_id + "</p>");
           console.log("通信成功");
           console.log(data);
       },
        // 通信が失敗した時
       error: function(data) {
         $('#error_check2').html("<p>取得できませんでした。管理者に連絡してください<p>");
           console.log("通信失敗");
           console.log(data);
       }
    });
    $('#close_info3').on('click',function(){
      $('.popup_info3').fadeOut();
    });
  });
};
</script>
</head>
<body>
  </header>
  <main>
    <section id="info_sec1">
      <div id="info_menu">
        <div id="info_title">
          <p>《　会員管理　》</p>
        </div><!-- /medical_records_title -->
        <div id="info_menu_title">
          <p>・新規会員登録</p>
          <button type="button" id="infonew" class="btn btn-success">新規会員登録</button>
        </div>
          <div id="info_change">
          <p>・会員情報変更</p>
          <select id="userlist_info1">
              <option>選択してください</option>
            <?php foreach ($result as $value) { ?>
              <option name="member_id_p" value="<?php echo htmlspecialchars($value["id"], ENT_QUOTES); ?>":selected>
              <?php echo htmlspecialchars($value["id"], ENT_QUOTES); ?>　<?php echo htmlspecialchars($value["name"], ENT_QUOTES); ?>　様
              </option>
            <?php } ?>
          </select>
          <input type="hidden" id=member_id_vali></input>
          <button type="button" id="infocheck" class="btn btn-warning">会員情報変更</button>
        </div>
        <div id="info_delete">
          <p>・会員情報削除</p>
          <select id="userlist_info2">
              <option>選択してください</option>
            <?php foreach ($result as $value) { ?>
              <option name="member_id_p" value="<?php echo htmlspecialchars($value["id"], ENT_QUOTES); ?>":selected>
              <?php echo htmlspecialchars($value["id"], ENT_QUOTES); ?>　<?php echo htmlspecialchars($value["name"], ENT_QUOTES); ?>　様
              </option>
            <?php } ?>
          </select>
          <input type="hidden" id=member_id_delete></input>
          <button type="button" id="infodelete" class="btn btn-outline-danger">会員情報削除</button>
        </div>
          <div class="popup_info1">
            <div class="info_contents1">
              <form action="index_t.php" method="">
                <p>新規会員登録を行います。</p>
                <div class="cont">
                  <p>お名前　　　　　　：</p>
                  <input name="new_name"></input>
                </div>
                <div class="cont">
                  <p>フリガナ　　　　　：</p>
                  <input name="new_kana"></input>
                </div>
                <div class="cont">
                  <p>お電話番号　　　　：</p>
                  <input name="new_tel"></input>
                </div>
                <div class="cont">
                  <p>メールアドレス　　：</p>
                  <input name="new_mail"></input>
                </div>
                <div class="cont">
                  <p>パスワード　　　　：</p>
                  <input type="password" name="new_password"></input>
                </div>
                <div class="cont">
                  <p>活動拠点　　　　　：</p>
                  <input name="new_place"></input>
                  <p>　1:新宿フィットネス , 2:渋谷ジム</p>
                </div>
                <input type="hidden" name="new_create" value="<?php echo date('Y/m/d'); ?>"></input>
                <div id="button_field">
                  <button type="submit" class="btn btn-success" id="new_info">登録する</button>
              </form>
                  <button type="button" class="btn btn-success" id="close_info1">close</button>
                </div>
            </div>
          </div>
          <div class="popup_info2">
            <div class="info_contents2">
              <form method="post" action="index_t.php">
                <p>会員情報を変更してください。</p>
                <div id="error_check1"></div>
                <div class="result">
                  <p>お客様ID　　　　：　</p>
                  <div id="ajax_id_text1"></div>
                  <div id="ajax_id"></div>
                </div>
                <div class="result">
                  <p>お名前　　　　　：　</p>
                  <div id="ajax_name"></div>
                </div>
                <div class="result">
                  <p>フリガナ　　　　：　</p>
                  <div id="ajax_kana"></div>
                </div>
                <div class="result">
                  <p>お電話番号　　　：　</p>
                  <div id="ajax_tel"></div>
                </div>
                <div class="result">
                  <p>メールアドレス　：　</p>
                  <div id="ajax_mail"></div>
                </div>
                <div class="result">
                  <p>活動拠点　　　　：　</p>
                  <div id="ajax_place"></div>
                  <p>　1:新宿フィットネス , 2:渋谷ジム</p>
                </div>
                <input type="hidden" name="updated_at" value="<?php echo date('Y/m/d'); ?>"></input>
              <div id="button_area">
                <button type="submit" class="btn btn-success" id="change_info">変更する</button>
              </form>
                <button type="button" class="btn btn-success" id="close_info2">close</button>
              </div>
            </div>
          </div>
          <div class="popup_info3">
            <div class="info_contents3">
                <p>会員削除を行います。</p>
                <div class="result">
                  <p>お客様ID　　　　：　</p>
                  <div id="ajax_id_delete"></div>
                </div>
                <div class="result">
                  <p>お名前　　　　　：　</p>
                  <div id="ajax_name_delete"></div>
                </div>
                <div class="result">
                  <p>フリガナ　　　　：　</p>
                  <div id="ajax_kana_delete"></div>
                </div>
                <div class="result">
                  <p>お電話番号　　　：　</p>
                  <div id="ajax_tel_delete"></div>
                </div>
                <div class="result">
                  <p>メールアドレス　：　</p>
                  <div id="ajax_mail_delete"></div>
                </div>
                <div class="result">
                  <p>活動拠点　　　　：　</p>
                  <div id="ajax_place_delete"></div>
                </div>
              <div id="button_field">
                <form method="post" action="index_t.php">
                  <button type="submit" class="btn btn-success" id="delete_info">この会員を削除する</button>
                  <div id="ajax_id_text2"></div>
                </form>
                <button type="button" class="btn btn-success" id="close_info3">close</button>
              </div>
            </div>
          </div>
      </div><!-- /info_menu -->
    </section><!-- /info_sec1 -->
  </main>
</body>
</html>
