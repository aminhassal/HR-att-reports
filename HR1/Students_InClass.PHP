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
    <title>طلبة المادة</title>
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
                    <div class="card-header">
                        <h4>      
                            <a href="class_view.php?ClassID=<?php echo $_GET['ClassID']; ?>" class="btn btn-danger float-end">رجوع</a>
                            <!-- <a href="class_view.php?ClassID=<?php echo $_GET['ClassID']; ?>" class="btn btn-danger">////////// -->
                        </h4>
                    </div>
                        <div class="mb-3">
                            <label for="fname"> الطلبة :</label><br>
                        </div>
                        <div class="mb-3">
                            <a href="Students_InsertToClass.php?ClassID=<?= $_GET['ClassID']; ?>"
                                class="btn btn-dark float-end">إضافة طالب</a>
                        </div>
                        </from>
                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>الرقم</th>
                                        <th>اسم الطالب </th>
                                        <th> رقم القيد </th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_GET['ClassID'])) {
                                        $ClassID = mysqli_real_escape_string($con, $_GET['ClassID']);
                                        $query = "SELECT * FROM `student_in_class` WHERE ClassID = $ClassID ";
                                        $query_run = mysqli_query($con, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                            foreach ($query_run as $student) {
                                    ?>
                                    <tr>
                                        <td><?= $student['Uid']; ?></td>
                                        <td><?= $student['Name']; ?></td>
                                        <td><?= $student['InRollNumber']; ?></td>
                                        <td>
                                            <form action="code.php" method="POST" class="d-inline">
                                            <button type="submit" name="delete_studentInClassID" value="<?=$student['StudentClassID'];?>" class="btn btn-danger btn-sm">حذف</button>
                                            <input type="hidden" name="ClassID" value="<?=$student['ClassID'];?>" />
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        } else {
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

    <!-- CREATE VIEW Student_In_Class AS
                                 SELECT infostd.Uid,infostd.Name,infostd.InRollNumber,studentclass.ClassID
                                 FROM Class INNER JOIN subjects ON Class.SubjectID_FK = subjects.SubjectID_PK
                                  INNER JOIN studentclass ON Class.ClassID = studentclass.ClassID INNER JOIN 
                                  infostd ON studentclass.StdUid_FK = infostd.Uid ; -->