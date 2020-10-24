<?php
require_once("DB.php");

class User extends DB{

  // idで参照 - Member
  public function findByM($id) {
    $sql = 'SELECT * FROM members WHERE id = :id';
    $sth = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $sth->execute($params);
    $result = $sth->fetch();
    return $result;
  }
  // idで参照 - trainer
  public function findByT($id) {
    $sql = 'SELECT * FROM trainers WHERE id = :id';
    $sth = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $sth->execute($params);
    $result = $sth->fetch();
    return $result;
  }
  // 日付で参照 - trainer
  public function findByDay($date) {
    $sql = 'SELECT * FROM schedules WHERE date = :date order by date,s_time asc';
    $sth = $this->connect->prepare($sql);
    $params = array(':date'=>$date);
    $sth->execute($params);
    $result = $sth->fetchAll();
    return $result;
  }
  // 登録 - Shedule
  public function add($arr) {
    $sql = "INSERT INTO schedules (date, s_time, e_time, created_at, members_id ) VALUES (:date, :s_time, :e_time, :created_at, :members_id)";
    $sth = $this->connect->prepare($sql);
    $params = array(
      ':date'=>$arr['date'],
      ':s_time'=>$arr['s_time'],
      ':e_time'=>$arr['e_time'],
      ':created_at'=>$arr['created_at'],
      ':members_id'=>$arr['members_id']
    );
    $sth->execute($params);
  }
  //登録処理 - medicalrecords_t
  public function mradd($member_id, $day, $filename, $created_at) {
    $sql = "INSERT INTO medical_records (member_id, day, img, created_at ) VALUES (:member_id, :day, :img, :created_at )";
    $sth = $this->connect->prepare($sql);
    $sth->bindValue(':member_id', $member_id, PDO::PARAM_STR);
    $sth->bindValue(':day', $day, PDO::PARAM_STR);
    $sth->bindValue(':img', $filename, PDO::PARAM_STR);
    $sth->bindValue(':created_at', $created_at, PDO::PARAM_STR);
    $sth->execute();
  }
  // 登録 - member
  public function Memberadd($arr) {
    $sql = "INSERT INTO members (name, kana, tel, mail, pass, place_id, created_at) VALUES (:name, :kana, :tel, :mail, :pass, :place_id, :created_at)";
    $sth = $this->connect->prepare($sql);
    $params = array(
      ':name'=>$arr['new_name'],
      ':kana'=>$arr['new_kana'],
      ':tel'=>$arr['new_tel'],
      ':mail'=>$arr['new_mail'],
      ':pass'=>$arr['new_password'],
      ':place_id'=>$arr['new_place'],
      ':created_at'=>$arr['new_create'],
    );
    $sth->execute($params);
  }
  // 参照 - medicalrecords_t
  public function find_member_All() {
    $sql = "SELECT * FROM members";
    $sth = $this->connect->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;
  }
  // 参照 - info_t
  public function find_member_Allinfo() {
    $sql = "SELECT * FROM members";
    $sth = $this->connect->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll();
    return $result;
  }
  //参照 -info_t idで
  public function findByMember_id($id) {
    $sql = 'SELECT * FROM members WHERE id = :id';
    $sth = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $sth->execute($params);
    $result = $sth->fetch();
    return $result;
  }
  //参照 -info idで
  public function Member_idfind($id) {
    $sql = 'SELECT * FROM members WHERE id = :id';
    $sth = $this->connect->prepare($sql);
    $params = array(':id'=>$id);
    $sth->execute($params);
    $result = $sth->fetch();
    return $result;
  }
  // 更新 - info_t 会員情報変更
  public function update($arr) {
    $sql = "UPDATE members SET name = :name, kana = :kana, tel = :tel, mail = :mail, place_id = :place_id, updated_at = :updated_at WHERE id = :id";
    $sth = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$_POST['change_member_id'],
      ':name'=>$_POST['change_member_name'],
      ':kana'=>$_POST['change_member_kana'],
      ':tel'=>$_POST['change_member_tel'],
      ':mail'=>$_POST['change_member_mail'],
      ':place_id'=>$_POST['change_member_place'],
      ':updated_at'=>$_POST['updated_at']
    );
    $sth->execute($params);
  }
  // 更新 - info 会員情報変更
  public function updateM($arr) {
    $sql = "UPDATE members SET name = :name, kana = :kana, tel = :tel, mail = :mail, place_id = :place_id, updated_at = :updated_at WHERE id = :id";
    $sth = $this->connect->prepare($sql);
    $params = array(
      ':id'=>$_GET['change_id'],
      ':name'=>$_GET['change_name'],
      ':kana'=>$_GET['change_kana'],
      ':tel'=>$_GET['change_tel'],
      ':mail'=>$_GET['change_mail'],
      ':place_id'=>$_GET['change_place'],
      ':updated_at'=>$_GET['updated']
    );
    $sth->execute($params);
  }
  // 削除 - info_t - 会員情報削除
  public function delete($id = null) {
    if(isset($id)) {
      $sql = "DELETE FROM members WHERE id = :id";
      $sth = $this->connect->prepare($sql);
      $params = array(':id'=>$id);
      $sth->execute($params);
    }
  }
  //参照 - reserve
  public function member_schedule($members_id) {
    $sql = "SELECT * FROM schedules WHERE members_id = :members_id order by date,s_time asc";
    $sth = $this->connect->prepare($sql);
    $params = array(':members_id'=>$members_id);
    $sth->execute($params);
    $result = $sth->fetchAll();
    return $result;
  }
  //参照 - medical_records
  public function rs($member_id) {
    $sql = "SELECT * FROM medical_records WHERE member_id = :member_id order by day desc";
    $sth = $this->connect->prepare($sql);
    $params = array(':member_id'=>$member_id);
    $sth->execute($params);
    $result = $sth->fetchAll();
    return $result;
  }
}
//以下使ってない奴


  // // idで参照
  // public function findById($id) {
  //   $sql = 'SELECT * FROM schedules WHERE id = :id';
  //   $sth = $this->connect->prepare($sql);
  //   $params = array(':id'=>$id);
  //   $sth->execute($params);
  //   $result = $sth->fetch();
  //   return $result;
  // }
  //
  // // 削除
  // public function delete($id = null) {
  //   if(isset($id)) {
  //     $sql = "DELETE FROM schedules WHERE id = :id";
  //     $sth = $this->connect->prepare($sql);
  //     $params = array(':id'=>$id);
  //     $sth->execute($params);
  //   }
  // }
