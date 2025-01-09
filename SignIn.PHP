<?php
if ($_POST) {
    include 'config.php';
    $username = $_POST['Username'];
    $password = $_POST['password'];

    // تأمين البيانات المدخلة
    $sUser = mysqli_real_escape_string($con, $username);
    $sPass = mysqli_real_escape_string($con, $password);

    // التحقق من أن المستخدم غير موجود بالفعل
    $checkQuery = "SELECT * FROM Admins WHERE userName='$sUser'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // إضافة المستخدم الجديد
        $insertQuery = "INSERT INTO Admins (userName, password) VALUES ('$sUser', '$sPass')";
        if (mysqli_query($con, $insertQuery)) {
            // إعادة التوجيه للصفحة الرئيسية بعد التسجيل
            header('location: login.php');
        } else {
            echo "خطأ في إضافة الحساب: " . mysqli_error($con);
        }
    } else {
        echo "اسم المستخدم موجود بالفعل.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد</title>
    <link rel='stylesheet' href='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="./style.css">
</head>
<body id="login_i">

<div class='login'>
    <div class='login_title'>
        <span>إنشاء حساب جديد</span>
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
                <input placeholder='اسم المستخدم' type='text' name='Username' required>
                <div class='validation'>
                    <img src='tick.png'>
                </div>
            </div>
            <div class='login_fields__password'>
                <div class='icon'>
                    <img src='lock_icon_copy.png'>
                </div>
                <input placeholder='كلمة المرور' type='password' name='password' required>
                <div class='validation'>
                    <img src='tick.png'>
                </div>
            </div>
            <div class='login_fields__submitto'> 
                <div> <input type='submit' value='إنشاء حساب'> </div>
                <div class='forgot'>
                    <a href='login.php'>هل لديك حساب مسبق؟ تسجيل الدخول</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
<script src="./script.js"></script>

</body>
</html>