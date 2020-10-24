<?php
require_once("config/config.php");
require_once("model/User.php");
$user = new User($host, $dbname, $user, $pass);
$user->connectDb();
$members_id = $_SESSION["id"];
$result = $user->member_schedule($members_id);
if($_POST){
  $date = $_POST["date"];
  $s_time = $_POST["s_time"];
  $e_time = $_POST["e_time"];
  $created_at = $_POST["created_at"];
  $members_id = $_POST["members_id"];

  function h($str){
    if(is_array($str)){
       return array_map('h', $str);
    }else{
      return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
  }
  // tryにPDOの処理を記述
  try {
    //DB接続
    //登録処理
    if($_POST) {
      $user->add($_POST);
      flash('default', '　　予約しました');
      header('Location: http://localhost/myphp/index.php');
    }
  // エラー（例外）が発生した時の処理を記述
  }catch (PDOException $e) {
    require("disconnect.php");
  }
}

 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>

<!--css -->
<link rel="stylesheet" href="css/reserve.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="css/plugin/jquery-ui.theme.css">
<!--jq -->
<script type="text/javascript" src="js/plugin/jquery-ui.js"></script>
<script type="text/javascript" src="js/plugin/datepicker-ja.js"></script>
<script>
$(function(){
  calender();
  formcheck();
});
//カレンダー
function calender(){
  $("#datepicker").datepicker({
    minDate: +3,
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function(dateText, inst){
      $("#alternate, #choose_date").text(dateText);
      $("#date_set").val(dateText);
    }
  });
};
function formcheck(){
  $("#check").on('click', function(){
    var s_time = $("#timelist option:selected").val();
    var course = $("#courselist option:selected").val();
    var e_time;
    for(var i=0; i<9; i++){
      if(s_time == "09:00"){
        if(s_time == "09:00"){
          if(course == "30"){
            e_time = "09:30";
          } else if(course == "60"){
            e_time = "10:00";
          } else if(course == "90"){
            e_time = "10:30";
          } else if(course == "120"){
            e_time = "11:00";
          }
        }else{
        }
      } else if(s_time == i+9 +":00"){
        if(course == "30"){
          e_time = i+9 +":30";
        } else if(course == "60"){
          e_time = i+10 +":00";
        } else if(course == "90"){
          e_time = i+10 +":30";
        } else if(course == "120"){
          e_time = i+11 +":00";
        }
      }
    }
    $("#s_time_set").val(s_time);
    $("#s_time_check").text(s_time);
    $("#e_time_set").val(e_time);
    $("#e_time_check").text(e_time);
    if(s_time == ""){
    } else{
      $('.popup_form').addClass('show').fadeIn();
      $('#close').on('click',function(){
        $('.popup_form').fadeOut();
      });
    };
  });
};
</script>
</head>
<body>
  <main>
    <section id="reserve_sec1">
      <div id="reserve_menu">
        <div id="reserve_title">
          <p>《　ご予約　》</p>
        </div>
        <div id="calender">
          <div id="datepicker"></div>
            <div id="schedule">
              <p>ご予約日　:　<span id="alternate"><?php echo date('Y/m/d', strtotime('+3 day')); ?></span></p>
              <p>　 　　予約時間<span> 　　　　　　　時間</span></p>
              <div id="flex">
                <select name="timelist" id="timelist" class="form-control">
                	<option value=""> 選択してください</option>
                	<option value="09:00">09:00～</option>
                	<option value="10:00">10:00～</option>
                	<option value="11:00">11:00～</option>
                	<option value="13:00">13:00～</option>
                	<option value="14:00">14:00～</option>
                	<option value="15:00">15:00～</option>
                	<option value="16:00">16:00～</option>
                	<option value="17:00">17:00～</option>
              	</select>
              	<select name="courselist" id="courselist" class="form-control">
                	<option value="30">30分</option>
                	<option value="60" selected>60分</option>
                	<option value="90">90分</option>
                	<option value="120">120分</option>
              	</select>
              <button type="submit" id="check" class="btn btn-outline-success">予約</button>
            </div>
              <div class="popup_form">
                <div class="form_contents">
                  <form action="index.php" method="post">
                    <input type="hidden" name="date" id="date_set" value="<?php echo date('Y/m/d', strtotime('+3 day')); ?>"></input>
                    <input type="hidden" name="created_at" id="created_at" value="<?php echo date('Y/m/d'); ?>"></input>
                    <input type="hidden" name="s_time" id="s_time_set"></input>
                    <input type="hidden" name="e_time" id="e_time_set"></input>
                    <input type="hidden" name="members_id" id="members_id" value="<?php echo $_SESSION["id"]; ?>"></input>
                    <p>ご予約確認</p>
                    <div class="reserve_flex">
                      <p>日付　：</p>
                      <p id="choose_date"><?php echo date('Y/m/d', strtotime('+3 day')); ?></p>
                    </div>
                    <div class="reserve_flex">
                      <p>お時間：</p>
                      <p><span id="s_time_check"></span>～<span id="e_time_check"></span></p>
                    </div>
                    <div id="form_button">
                      <button type="submit" class="btn btn-success" id="reserve_button">予約確定</button>
                      <button type="button" class="btn btn-success" id="close">close</button>
                    </div><!-- /form_button -->
                  </form>
                </div>
              </div>
              <div id="reserve_comment">
                  <?php if($result == null) { ?>
                    <p>ご予約はございません。</p>
                  <?php } else { ?>
                  <p>あなたの直近のご予約は以下の通りです。</p>
                  <table class="table">
                    <tr><th><th><p class="center">日付</p></th><th><p class="center">開始時刻</p></th><th><p class="center">終了時刻</p></th></tr>
                  <?php foreach ($result as $val) { ?>
                    <?php if(date("Y-m-d") <= $val["date"]) {?>
                    <tr>
                      <td id="no">・</td>
                      <td><p class="center"><?php echo $val["date"]; ?></p></td>
                      <td><p class="center"><?php echo $val["s_time"]; ?></p></td>
                      <td><p class="center"><?php echo $val["e_time"]; ?></p></td>
                    </tr>
                    <?php } ?>
                  <?php } ?>
              </table>
            <?php } ?>
              </div><!-- /reserve_comment -->
            </div>
          </div><!-- /schedule -->
        </div>
      </div>
    </section><!-- /reserve_sec1 -->
  </main>
</body>
</html>
