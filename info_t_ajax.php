<?php
require_once("config/config.php");
require_once("model/User.php");
// GETメソッドでリクエストした値を取得
if(isset($_POST['id'])){
  $id = $_POST['id'];

  // データベース接続クラスPDOのインスタンス$dbhを作成する
  try {
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    $result = $user->findByMember_id($id);

  // PDOExceptionクラスのインスタンス$eからエラーメッセージを取得
  } catch (PDOException $e) {
      var_dump($e);
      // 接続できなかったらvar_dumpの後に処理を終了する
      require("disconnect.php");
  }
  // ヘッダーを指定することによりjsonの動作を安定させる
  header('Content-type: application/json');
    // htmlへ渡す配列$productListをjsonに変換する
  echo json_encode($result);
}

if(isset($_POST['delete_id'])){
  $id = $_POST['delete_id'];

  // データベース接続クラスPDOのインスタンス$dbhを作成する
  try {
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    $result = $user->findByMember_id($id);

  // PDOExceptionクラスのインスタンス$eからエラーメッセージを取得
  } catch (PDOException $e) {
      var_dump($e);
      // 接続できなかったらvar_dumpの後に処理を終了する
      require("disconnect.php");
  }
  // ヘッダーを指定することによりjsonの動作を安定させる
  header('Content-type: application/json');
    // htmlへ渡す配列$productListをjsonに変換する
  echo json_encode($result);
}
