<?php
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title> تسجيل طالب </title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>إضافة طالب
                            <a href="register.PHP" class="btn btn-danger float-end">رجوع</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">

                            <div class="mb-3">
                                <label>إسم الطالب</label>
                                <input type="text" name="Name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>رقم الطالب</label>
                                <input type="text" name="Phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>رقم القيد</label>
                                <input type="text" name="InRollNumber" class="form-control">
                            </div>
                            <label> كلمة المرور </label>
                                <input type="text" name="Password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_student" class="btn btn-dark">تسجيل</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>