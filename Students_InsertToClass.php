<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" charset=utf-8>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title> إضافة فصل </title>
</head>

<body>
    <div class="container mt-5">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="shadow-lg p-3 mb-5 bg-body rounded">
                    <div class="card-header">
                        <h4> إضافة طالب
                            <a href="Students_InClass.PHP?ClassID=<?php echo $_GET['ClassID'];?>"
                             class="btn btn-danger float-end">رجوع</a>
                        </h4>
                    </div>
                    <div class="card-body" style="text-align:center">
                        <form action="code.php" method="POST">
                            <input type="hidden" name="ClassID" value=<?php echo $_GET['ClassID']; ?>>
                            </input>
                            <?php
                            include 'config.php';
                            $query = "SELECT * FROM `infostd`";
                            $result = $con->query($query);
                            if ($result->num_rows > 0) {
                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            ?>
                            <div class="p-3 mb-2 bg-light text-dark" .bg-light>
                                <h2>قائمة الطلبة </h2>
                                <select name="Uid" class="form-select form-select-lg mb-3"
                                    aria-label=".form-select-lg example" style="text-align:center">
                                    <option>إختر الطالب</option>
                                    <?php
                                    foreach ($options as $option) {
                                    ?>
                                    <option value='<?php echo $option['Uid'] ?>'>
                                        <?php echo $option['Name']; ?>
                                    </option>
                                    <?php
                                                }
                                        ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_StudentInStudentclass"
                                    class="btn btn-primary">إضافة</button>
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