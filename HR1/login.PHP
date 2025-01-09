<?php
if($_POST)
{
    include 'config.php';
    $username=$_POST['Username'];
    $password=$_POST['password'];
    $sUser=mysqli_real_escape_string($con,$username);
    $sPass=mysqli_real_escape_string($con,$password);
    // For Security 
    $query="SELECT * From Admins where userName='$sUser' and password='$sPass'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1)
    {
        session_start();
        $_SESSION['anything']='something';
        header('location:OLd_index1.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>الحضور والانصراف</title>
  <link rel='stylesheet' href='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'><link rel="stylesheet" href="./style.css">

</head>
<body id="login_i">
<!-- partial:index.partial.html -->

<div class='login'>
  <div class='login_title'>
    <span>تسجيل الدخول</span>
    <form method="POST">
    <div class='ico'>
      <img src='lock_icon_copy.png'>
    </div>
  </div>
  <div class='login_fields'>
    <div class='login_fields__user'>
      <div class='icon'>
        <img src='user_icon_copy.png'>
      </div>
      <input placeholder='Username' type='text' name='Username'>
        <div class='validation'>
          <img src='tick.png'>
        </div>
      </input>
    </div>
    <div class='login_fields__password'>
      <div class='icon'>
        <img src='lock_icon_copy.png'>
      </div>
      <input placeholder='Password' type='password' name='password'>
      <div class='validation'>
        <img src='tick.png'>
      </div>
    </div>
    <div class='login_fields__submit'>
      <input type='submit' value='تسجيل الدخول'>
      <div class='forgot'>
      </form>
        <a href='#'> هل نسيت كلمة المرور?</a>
      </div>
    </div>
  </div>
<!-- partial -->
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script><script  src="./script.js"></script>

</body>
</html>

