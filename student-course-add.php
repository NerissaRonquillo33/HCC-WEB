<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['course']) && isset($_POST['student']) && isset($_POST['teacher'])) {
    if (empty($_POST['course']) || empty($_POST['student']) || empty($_POST['teacher'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $course = trim(mysqli_real_escape_string($mysqli,$_POST['course']));
        $student = trim(mysqli_real_escape_string($mysqli,$_POST['student']));
        $teacher = trim(mysqli_real_escape_string($mysqli,$_POST['teacher']));

        $sql = "INSERT INTO student_courses(student_id,teacher_id,course_id) VALUES($student,$teacher,$course)";
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
        }
        
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HCC</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="./js/jquery.min.js"></script>
    <script src="./js/main.js"></script>
</head>
<body>
    <div class="container">
        <div class="row header-sub-menu">
            <div class="table">
                <div class="table-row"><div class="table-cell-nav-left"><img src="./images/back.png" data-url="./student-course.php" style="cursor: pointer;"/></div></div>
            </div>
        </div>
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="student-course-add.php" method="post">
                    <div class="row">
                        <select name="courses_name">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM courses_name");

                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row"><select name="course" disabled></select></div>
                    <div class="row"><select name="student" disabled></select></div>
                    <div class="row"><select name="teacher" disabled></select></div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Added successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">Student\'s course already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>