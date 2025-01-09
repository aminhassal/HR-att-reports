<?php
session_start();
require 'config.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title> تـعديل</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>
   <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> تعديل بيانات طالب 
                            <a href="register.php" class="btn btn-danger float-end">رجوع</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['Uid']))
                        {
                            $studentid = mysqli_real_escape_string($con,$_GET['Uid']);
                            $query = "SELECT * FROM infostd WHERE Uid ='$studentid' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="Uid" value="<?= $student['Uid']; ?>">
                                    <div class="mb-3">
                                        <label>أسم الطالب  </label>
                                        <input type="text" name="Name" value="<?=$student['Name'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>رقم الطالب</label>
                                        <input type="text" name="Phone" value="<?=$student['Phone'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>رقم القيد</label>
                                        <input type="text" name="InRollNumber" value="<?=$student['InRollNumber'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="update_student" class="btn btn-primary">
                                            تـعديل
                                        </button>
                                    </div>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>