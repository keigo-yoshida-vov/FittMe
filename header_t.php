<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
<link rel="stylesheet" type="text/css" href="css/header_t.css">
<script>
//スムーズスクロール
$(function(){
  $("a[href^='#']").on("click",function(){
    var speed = 500;
    var href = $(this).attr("href");
    var target = $(href == "#" || href == ""?"html":href);
    var position = target.offset().top;
    $("html, body").animate({
      "scroll-top": position }, speed, "swing");
    return false;
  });
});
</script>
</head>
<body>
  <header>
    <div id="header_wrapper">
      <div id="header_main">
        <div id="header_main_area">
          <div id="header_title">
            <a href="index_t.php"><p>FittMe</p></a>
          </div><!-- /header_title -->
          <div id="header_subtitle">
            <p>～ご予約やカルテ管理に～</p>
          </div><!-- /header_subtitle -->
        </div><!-- /header_main_area -->
        <nav>
          <ul>
            <li><a href="#header_wrapper" class="btn btn-outline-primary">TOP</a></li>
            <li><a href="#index_sec1" class="btn btn-outline-primary">予約管理</a></li>
            <li><a href="#index_sec2" class="btn btn-outline-primary">カルテ</a></li>
            <li><a href="#index_sec3" class="btn btn-outline-primary">会員管理</a></li>
          </ul>
        </nav>
      </div><!-- /header_main -->
      <div id="header_sub">
        <div id="header_sub_area">
          <div id="header_status">
            <p>ステータス：<span>トレーナー</span></p>
          </div><!-- /header_status -->
          <div id="header_name">
            <p><?php echo $head_name; ?></p>
          </div><!-- /header_name -->
        </div><!-- /header_sub_area -->
        <div id="logout">
          <a href="login_t.php" class="btn btn-outline-warning">ログアウト</a>
        </div><!-- /logout -->
      </div><!-- /header_sub -->
    </div><!-- /header_wrapper -->
  </header>
</body>
</html>
