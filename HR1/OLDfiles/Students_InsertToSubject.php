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
                <div class="card">
                    <div class="card-header">
                        <h4> إضافة طالب
                            <a href="Subjects.php" class="btn btn-danger float-end">رجوع</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <input type="hidden" name="SubjectID_PK" value=<?php echo $_GET['SubjectID_PK']; ?>>
                            </input>
                            <?php
                            include 'config.php';
                            $query = "SELECT * FROM `infostd`";
                            $result = $con->query($query);
                            if ($result->num_rows > 0) {
                                $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            ?>
                            <div class="mb-3">
                                <label>إسم الطالب </label>
                                <select name="Uid">
                                    <option>إختر المادة</option>
                                    <?php
                                    foreach ($options as $option) {
                                    ?>
                                        <option value='<?php echo $option['Uid'] ?>'>
                                            <?php echo $option['Name']; ?>
                                        </option><?php
                                                }
                                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_StudentInSubSTD" class="btn btn-primary">إضافة</button>
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