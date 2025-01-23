<?php
    session_start();
    require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>محاضرات</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<div class="container mt-4">
    <?php include('message.php'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="code.php" method="POST">
                        <input type="hidden" name="ClassID" value=<?php echo $_GET['ClassID']; ?>>
                        <div class="mb-3">

                            <div class="card-header">
                                <h4 align="right">
                                    <a href="exams.php" class="btn btn-danger"> &#8594; رجوع</a>
                                </h4>
                            </div>

                            <label for="fname"> المحاضرة:</label><br>
                            <input type="text" name="fname"><br>
                        </div>
                        <div class="mb-3">
                            <button method="POST" type="submit" name="savecourses" class="btn btn-dark">إضافة
                                محاضرة</button>
                        </div>
                        <div>
                            <a href="Students_InClass.PHP?ClassID=<?= $_GET['ClassID']; ?>"
                                class="btn btn-info btn-sm">عرض الطلبة</a>
                        </div>
                        </from>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>الرقم</th>
                                        <th>المحاضرة </th>
                                        <th> تاريخ </th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                            if(isset($_GET['ClassID'])){
                            $ClassID =mysqli_real_escape_string($con, $_GET['ClassID']);
                            $query = "SELECT * FROM courses where ClassID_FK= $ClassID";
                            $query_run = mysqli_query($con, $query);
                            
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $student)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $student['CourseiID']; ?></td>
                                        <td><?= $student['CourseName']; ?></td>
                                        <td><?= $student['OpenDate']; ?></td>
                                        <td>
                                            <a href="Course_view.php?ClassID=<?= $_GET['ClassID']; ?>&CourseiID=<?= $student['CourseiID']; ?>"
                                                class="btn btn-info btn-sm">عرض</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "<h5> No Record Found </h5>";
                            }
                        }
                        ?>
                                </tbody>
                            </table>

                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    </body>