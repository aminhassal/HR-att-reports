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
                            <input type="hidden" name="ClassID" value="<?php echo $_GET['ClassID']; ?>">

                            <?php
        include 'config.php';
        $query = "SELECT * FROM `infostd`";
        $result = $con->query($query);
        if ($result->num_rows > 0) {
            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        ?>

                            <div class="p-3 mb-2 bg-light text-dark">
                                <h2>قائمة الطلبة</h2>
                                <input type="text" id="searchInput" class="form-control form-control-lg mb-3"
                                    placeholder="ابحث عن الطالب..." onkeyup="filterStudents()"
                                    style="text-align:center">

                                <ul id="studentList" class="list-group">
                                    <?php
                foreach ($options as $option) {
                ?>
                                    <li class="list-group-item student-item" data-uid="<?php echo $option['Uid']; ?>"
                                        style="cursor: pointer;">
                                        <?php echo $option['Name']; ?>
                                    </li>
                                    <?php
                }
                ?>
                                </ul>
                            </div>

                            <input type="hidden" name="Uid" id="selectedUid">

                            <div class="mb-3">
                                <button type="submit" name="save_StudentInStudentclass"
                                    class="btn btn-primary">إضافة</button>
                            </div>
                        </form>
                    </div>

                    <script>
                    function filterStudents() {
                        const input = document.getElementById('searchInput');
                        const filter = input.value.toLowerCase();
                        const students = document.getElementsByClassName('student-item');

                        for (let i = 0; i < students.length; i++) {
                            const studentName = students[i].textContent || students[i].innerText;
                            if (studentName.toLowerCase().includes(filter)) {
                                students[i].style.display = '';
                            } else {
                                students[i].style.display = 'none';
                            }
                        }
                    }

                    document.querySelectorAll('.student-item').forEach(item => {
                        item.addEventListener('click', function() {
                            document.getElementById('searchInput').value = this.innerText;
                            document.getElementById('selectedUid').value = this.getAttribute(
                            'data-uid');
                            document.getElementById('studentList').style.display =
                            'none';
                        });
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>