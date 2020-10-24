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
});
//カレンダー
function calender(){
  $("#datepicker").datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function(dateText, inst){
      $("#alternate").text(dateText);

      //セレクトした日付をPOST→ajaxで参照　scheduleテーブルの中身を出力
      $.ajax({
         // 送信方法
         type: "POST",
         // 送信先ファイル名
         url: "reserve_t_ajax.php",
         // 受け取りデータの種類
         datatype: "json",
         // 送信データ
         data: {
             "date" : $('#alternate').text()
         },
         // 通信が成功した時
         success: function(datas) {
           if(datas == false){
             $('#get_schedule').html("</br><p>ご予約はありません</p>");
           } else{
              $('#get_schedule').html("</br><table class='table'><tr><td>お客様id</td><td>開始時刻</td><td>終了時刻</td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr>");
             var i = 0; //インデックス用
              $.each(datas,function(key,item){
                  //クラスセレクタのインデックスを明示してあげないと、同じ場所を何度も上書きしてしまうことになる。
                  $(".set_name").eq(i).text(item.members_id);
                  $(".set_s_time").eq(i).text(item.s_time);
                  $(".set_e_time").eq(i).text(item.e_time);
                  i++; //インデックス用のインクリメント
              })
           }
               console.log(datas);

         },
          // 通信が失敗した時
         error: function(data) {
           $('#error_check1').html("<p>取得できませんでした。管理者に連絡してください<p>");
              console.log("通信失敗");
              console.log(data);
         }
       });

    }
  });
};
$(document).ready(function(){
  //セレクトした日付をPOST→ajaxで参照　scheduleテーブルの中身を出力
  $.ajax({
     // 送信方法
     type: "POST",
     // 送信先ファイル名
     url: "reserve_t_ajax.php",
     // 受け取りデータの種類
     datatype: "json",
     // 送信データ
     data: {
         "date" : $('#alternate').text()
     },
     // 通信が成功した時
     success: function(datas) {
       if(datas == false){
         $('#get_schedule').html("</br><p>ご予約はありません</p>");
       } else{
          $('#get_schedule').html("</br><table class='table'><tr><td>お客様id</td><td>開始時刻</td><td>終了時刻</td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr><tr><td class='set_name'></td><td class='set_s_time'></td><td class='set_e_time'></td></tr></tr>");
         var i = 0; //インデックス用
          $.each(datas,function(key,item){
              //クラスセレクタのインデックスを明示してあげないと、同じ場所を何度も上書きしてしまうことになる。
              $(".set_name").eq(i).text(item.members_id);
              $(".set_s_time").eq(i).text(item.s_time);
              $(".set_e_time").eq(i).text(item.e_time);
              i++; //インデックス用のインクリメント
          })
       }
           console.log(datas);

     },
      // 通信が失敗した時
     error: function(data) {
       $('#error_check1').html("<p>取得できませんでした。管理者に連絡してください<p>");
          console.log("通信失敗");
          console.log(data);
     }
   });
 });
</script>
</head>
<body>
  <main>
    <section id="reserve_sec1">
      <div id="reserve_menu">
        <div id="reserve_title">
          <p>《　予約管理　》</p><br>
        </div>
        <div id="calender">
          <div id="datepicker"></div>
          <div id="schedule">
            <p>ご予約日　:　<span id="alternate"><?php echo date('Y/m/d'); ?></span>　のご予約</p>
            <div id="get_schedule"></div>
            <div>
            </div>
          </div>
        </div><!-- /schedule -->
      </div>
    </section><!-- /reserve_sec1 -->
  </main>
</body>
</html>
