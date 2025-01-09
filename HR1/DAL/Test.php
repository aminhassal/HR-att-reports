<?php
 class DAL {
    public $StudentUID;
    public $RecordStatus;
    public $RecordDate;
    public $RecordTime;
public function deleteinfos(){
   require("config.php");
   $deletequery =
    "DELETE FROM `records`";
    $deleteresult = mysqli_query($con, $deletequery) or die(mysqli_error($con));
    }
 
public function sqlInserto($uid, $RecordStatus, $RecordDate,$RecordTime){
    require("config.php");
    $insertquery =
     "INSERT INTO`records`
     (`StudentUID`,
       `RecordStatus`,
        `RecordDate`,
         `RecordTime`)
     VALUES
      ($uid,'$RecordStatus','$RecordDate','$RecordTime');";
    $insertresult = mysqli_query($con, $insertquery) or die(mysqli_error($con));
    return $insertresult;
    }
  }

 class DAL_INF {
    public $ID;
    public $uid;
    public $Name;
    public $Role;
    public $Password;
public function sqlInsertoinfo($uid,$ID,$Name,$Password){
    require("config.php");
    $insertquery =
     "INSERT INTO`infostd`
        (`Uid`,
         `STD_id`,
         `Name`,
         `Password`)
     VALUES
      ($uid,$ID,'$Name','$Password');";
    $insertresult = mysqli_query($con, $insertquery) or die(mysqli_error($con));
    return $insertresult;
    }
 }
 
//  class SetUsers {
//   public $ID;
//   public $uid;
//   public $Name;
//   public $Role;
//   public $Password;
// public function SendToDevice($ID, $uid, $Name, $Password, $Role){
//   require("config.php");

//   $zk->setUser($ID, $uid, $Name, $Password,$Role);

// }
// }
?>