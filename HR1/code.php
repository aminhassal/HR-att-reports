<?php
session_start();
require 'config.php';
header('Content-Type: text/html; charset=utf-8');

//                     
//Course Insert
if(isset($_POST['savecourses']))
{
    $ClassID_FK =mysqli_real_escape_string($con, $_POST['ClassID']);
    $NameCourse = mysqli_real_escape_string($con, $_POST['fname']);
    $Date = date("d-m-Y");

    $query = "INSERT INTO courses
    (CourseName,OpenDate,ClassID_FK)VALUE
    ('$NameCourse','$Date',$ClassID_FK)";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "تمت العملية";
        header("Location: class_view.php?ClassID=$ClassID_FK");////////////////////////////////
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "x فشلت العملية";
        header("Location: class_view.php?ClassID=$ClassID_FK");////////////////////////////////////
        exit(0);
    }
}
//Delete Student From Class \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ <<<<<
// select `hrr`.`infostd`.`Uid` AS `Uid`,
// `hrr`.`infostd`.`Name` AS `Name`,
// `hrr`.`infostd`.`InRollNumber` AS `InRollNumber`
// ,`hrr`.`studentclass`.`ClassID` AS `ClassID`
//  from (((`hrr`.`class` join `hrr`.`subjects` on(`hrr`.`class`.`SubjectID_FK` = `hrr`.`subjects`.`SubjectID_PK`))
//   join `hrr`.`studentclass` on(`hrr`.`class`.`ClassID` = `hrr`.`studentclass`.`ClassID`))
//  join `hrr`.`infostd` on(`hrr`.`studentclass`.`StdUid_FK` = `hrr`.`infostd`.`Uid`))

if(isset($_POST['delete_studentInClassID']))
{
    $student = mysqli_real_escape_string($con, $_POST['delete_studentInClassID']);
    $ClassID = mysqli_real_escape_string($con, $_POST['ClassID']);
    $query = "DELETE FROM `studentclass` WHERE StudentClassID = $student";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "  تم حذف الطالب  ";
        header("Location: Students_InClass.PHP?ClassID=$ClassID");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "  فشلت العملية  ";
        header("Location: Students_InClass.PHP?ClassID=$ClassID");
        exit(0);
    }
}
//
if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['delete_student']);

    $query = "DELETE FROM infostd WHERE Uid=$student_id";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "تم حذف الطالب";
        header("Location: register.PHP");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "     فشلت العملية";
        header("Location: register.PHP");
        exit(0);
    }
}
//update_student
if(isset($_POST['update_student']))
{
    $student_id = mysqli_real_escape_string($con,$_POST['Uid']);
    $name =  mysqli_real_escape_string($con,$_POST['Name']);
    $Phone = mysqli_real_escape_string($con,$_POST['Phone']);
    $Password = mysqli_real_escape_string($con,$_POST['Password']);
    $inroll = mysqli_real_escape_string($con,$_POST['InRollNumber']);

    $query = "UPDATE infostd SET
     Name='$name', 
     Phone ='$Phone',
     Password='$Password', 
     InRollNumber='$inroll' WHERE Uid ='$student_id'";
    $query_run = mysqli_query($con,$query);

    if($query_run)
    {
        $_SESSION['message'] = "تم التعديل";
        header("Location: register.PHP");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "فشلت العملية";
        header("Location: register.PHP");
        exit(0);
    }

}

//student
if(isset($_POST['save_student']))
{
    $name = mysqli_real_escape_string($con, $_POST['Name']);
    $InRollNumber = mysqli_real_escape_string($con, $_POST['InRollNumber']);
    $Phone = mysqli_real_escape_string($con, $_POST['Phone']);
    $Password = mysqli_real_escape_string($con, $_POST['Password']);   

    $query = "INSERT INTO infostd (Name,InRollNumber,Phone,Password) 
    VALUES ('$name','$InRollNumber','$Phone','$Password')";
    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "تم تسجيل الطالب";
        header("Location: student-create.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = " لم يتم التسجيل";
        header("Location: student-create.php");
        exit(0);
    }
}
//class

if(isset($_POST['save_class']))
{
    $SubjectID_PK =mysqli_real_escape_string($con, $_POST['SubjectID_PK']);
    $Nameclass = mysqli_real_escape_string($con, $_POST['Nameclass']);
    $Namelecture = mysqli_real_escape_string($con, $_POST['Namelecture']);
    $tod =date("ymd");

    $query = "INSERT INTO `class`
    (`SubjectID_FK`, `OpenDate`, `IsActive`, `classname`, `LectureName`)
     VALUES ('$SubjectID_PK',$tod,1,'$Nameclass','$Namelecture')";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "تمت إضافة";
        header("Location: courses.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = " فشلت العملية";
       header("Location: courses.php");
       exit(0);
    }
}
// insert student in SubSTD table : 
if(isset($_POST['save_StudentInStudentclass']))
{
    $StdUid_FK  =mysqli_real_escape_string($con, $_POST['Uid']);
    $ClassID = mysqli_real_escape_string($con, $_POST['ClassID']);

    $query = "INSERT INTO `studentclass`(`StdUid_FK`, `ClassID`)
    VALUES
    ('$StdUid_FK','$ClassID')
         ON DUPLICATE KEY UPDATE
        `StdUid_FK`='$StdUid_FK',`ClassID`='$ClassID';";

    //  $query = "INSERT INTO `studentclass`(`StdUid_FK`, `ClassID`)
    //  VALUES
    // ('$StdUid_FK','$ClassID')";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        header("Location: Students_InsertToClass.php?ClassID=$ClassID");
        $_SESSION['message'] = "تمت إضافة";
        exit(0);
    }
    else
    {
       header("Location: Students_InsertToClass.php?ClassID=$ClassID");
       $_SESSION['message'] = " فشلت العملية";
       exit(0);
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
class DAL {
   public $StudentUID;
   public $RecordStatus;
   public $RecordDate;
   public $RecordTime;
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