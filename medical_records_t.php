<?php
require_once("config/config.php");
require_once("model/User.php");
try {
  //DB接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();
  $result = $user->find_member_All();
  // ②テーブルのデータをoptionタグに整形
  if($_POST){
    if(isset($_POST["member_id"])){
      $member_id = $_POST["member_id"];
      $day = $_POST["day"];
      $created_at = $_POST["created_at"];
      $tempfile = $_FILES['img']['tmp_name'];
      $file =  $_FILES['img']['name'];
      $filename = "img/" . $_FILES['img']['name'];
      if (is_uploaded_file($tempfile)) {
      	if ( move_uploaded_file($tempfile , $filename )) {
      	}else {
      	}
      }else {
      }
      function h($str){
        if(is_array($str)){
           return array_map('h', $str);
        }else{
          return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        }
      }
      if($filename == "img/"){
      }else{
        $user->mradd($member_id, $day, $filename, $created_at);

        flash('default', '　　更新しました');
        header('Location: http://localhost/myphp/index_t.php');
      }
    }
  }
}catch (PDOException $e) {
  require_once("disconnect.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>予約サイト - 会員様マイページ</title>
<link rel="stylesheet" type="text/css" href="css/medical_records_t.css">
<link rel="stylesheet" type="text/css" href="css/slick.css" />
<link rel="stylesheet" type="text/css" href="css/slick-theme.css" />
<script type="text/javascript" src="js/slick.min.js"></script>
<script>
$(function(){
  medicalcheck();
  dd();
  fileup();
  mediacheck();
});
function fileup(){
$(document).on('change', ':file', function() {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.parent().parent().next(':text').val(label);
    var files = !!this.files ? this.files : [];
    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
    if (/^image/.test( files[0].type)){ // only image file
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file
        reader.onloadend = function(){ // set image data as background of div
            input.parent().parent().parent().prev('.imagePreview').css("background-image", "url("+this.result+")");
        }
    }
});
};
function medicalcheck(){
  $("#userlist").on("click", function(){
    var upload_user = $("#userlist option:selected").val();
    $("#member_id_val").val(upload_user);
  });
};
function dd(){
  $("#datedate").datepicker();
};
function mediacheck(){
  $("#mediacheck").on('click', function(){
    $('.popup_media').addClass('show').fadeIn();
    $.ajax({
       // 送信方法
       type: "POST",
       // 送信先ファイル名
       url: "medical_records_t_ajax.php",
       // 受け取りデータの種類
       datatype: "json",
       // 送信データ
       data: {
           "members_id" : $('#member_id_val').val()
       },
       // 通信が成功した時
       success: function(datas) {
         if(datas == false){
           $('#records_get').html("</br><p>カルテは未登録です</p>");
         } else{
            $('#records_get').html("<li class='slick-item'><input type='hidden' class='tmp0'><p class='set_date'></p><a class='set_ref0'><img src='' class='set_img0'></a></li><li class='slick-item'><input type='hidden' class='tmp1'><p class='set_date'></p><a class='set_ref1'><img src='' class='set_img1'></a></li><li class='slick-item'><input type='hidden' class='tmp2'><p class='set_date'></p><a class='set_ref2'><img src='' class='set_img2'></a></li><li class='slick-item'><input type='hidden' class='tmp3'><p class='set_date'></p><a class='set_ref3'><img src='' class='set_img3'></a></li><li class='slick-item'><input type='hidden' class='tmp4'><p class='set_date'></p><a class='set_ref4'><img src='' class='set_img4'></a></li><li class='slick-item'><input type='hidden' class='tmp5'><p class='set_date'></p><a class='set_ref5'><img src='' class='set_img5'></a></li><li class='slick-item'><input type='hidden' class='tmp6'><p class='set_date'></p><a class='set_ref6'><img src='' class='set_img6'></a></li><li class='slick-item'><input type='hidden' class='tmp7'><p class='set_date'></p><a class='set_ref7'><img src='' class='set_img7'></a></li><li class='slick-item'><input type='hidden' class='tmp8'><p class='set_date'></p><a class='set_ref8'><img src='' class='set_img8'></a></li><li class='slick-item'><input type='hidden' class='tmp9'><p class='set_date'></p><a class='set_ref9'><img src='' class='set_img9'></a></li><li class='slick-item'><input type='hidden' class='tmp10'><p class='set_date'></p><a class='set_ref10'><img src='' class='set_img10'></a></li><li class='slick-item'><input type='hidden' class='tmp11'><p class='set_date'></p><a class='set_ref11'><img src='' class='set_img11'></a></li><li class='slick-item'><input type='hidden' class='tmp12'><p class='set_date'></p><a class='set_ref12'><img src='' class='set_img12'></a></li><li class='slick-item'><input type='hidden' class='tmp13'><p class='set_date'></p><a class='set_ref13'><img src='' class='set_img13'></a></li><li class='slick-item'><input type='hidden' class='tmp14'><p class='set_date'></p><a class='set_ref14'><img src='' class='set_img14'></a></li>");
           var i = 0; //インデックス用
            $.each(datas,function(key,item){
                //クラスセレクタのインデックスを明示してあげないと、同じ場所を何度も上書きしてしまうことになる。
                $(".set_date").eq(i).text(item.day);
                var path = '.tmp' + i;
                // console.log(path);
                $(path).val(item.img).eq(i);
                var img = $(path).val();
                // console.log(img);
                var set = ".set_img" + i;
                var ref = ".set_ref" + i;
                $(set).attr('src', img);
                $(ref).attr('href', img);
                i++; //インデックス用のインクリメント
            })
         }
             console.log(datas);

       },
        // 通信が失敗した時
       error: function(data) {
         $('#error_check1').html("<p>取得できませんでした。管理者に連絡してください<p>");
            console.log("通信失敗");
            console.log(datas);
       }
     });
    $('#close_media').on('click',function(){
      $('.popup_media').fadeOut();
    });
  });
};
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
          <div id="medical_records_comment">
            <p>会員を選択してください</p>
            <select id="userlist">
            <?php foreach ($result as $value) { ?>
              <option value="<?php
                echo htmlspecialchars($value["id"], ENT_QUOTES);
              ?>" selected>
              <?php
                echo htmlspecialchars($value["id"], ENT_QUOTES);
              ?>　<?php
                echo htmlspecialchars($value["name"], ENT_QUOTES);
              ?>　様
              </option>
           <?php } ?>
          </select>
          <form method="POST" action="index_t.php" enctype="multipart/form-data">
            <p>日付を選択してください<p>
            <input id="datedate" size="26" name="day" value="<?php echo date('Y/m/d'); ?>"></input>
          </div><!-- /medical_reserve_comment -->
            <div id="medical_records_up">
              <div class="imagePreview"></div>
              <div class="input-group">
                <label class="input-group-btn">
                  <span class="btn btn-primary">ファイルを選択<input type="file" id="input_file" name="img"></input></span>
                </label>
                <input type="text" class="form-control" readonly="">
              </div>
              <input type="hidden" name="member_id" id="member_id_val"></input>
              <input type="hidden" name="created_at" id="created_at" value="<?php echo date('Y/m/d'); ?>"></input>
              <button type="submit" class="btn btn-primary" id="upload" name="uplode">アップロード</button>
            </div><!-- /medical_records_slider -->
          </form>
        </div><!-- /medical_reserve_contents -->
        <form>
          <button type="button" id="mediacheck" class="btn btn-outline-success">このユーザのアップロード済画像を表示</button>
          <div class="popup_media">
            <div class="media_contents">
              <ul id="records_get" class="slider">
              </ul>
              <div id="closed">
                <button type="button" class="btn btn-success" id="close_media">close</button>
              </div>
            </div>
        </div>
        </div>
      </div><!-- /medical_records_menu -->
    </section><!-- /medical_records_sec1 -->
    <section id="medical_records_sec2">
    </section><!-- /medical_records_sec2 -->
  </main>
</body>
</html>
