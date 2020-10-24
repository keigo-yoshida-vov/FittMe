<?php
require("config/config.php");
// PDOインスタンスを生成
$db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $user, $pass,
  array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ));
?>
