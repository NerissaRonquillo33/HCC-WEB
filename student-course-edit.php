<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
$row_student_courses = array("student_id"=>"","teacher_id"=>"");
if (isset($_POST['action']) && isset($_POST['id']) && isset($_POST['student']) && isset($_POST['teacher'])) {
    if (empty($_POST['action']) || empty($_POST['id']) || empty($_POST['student']) || empty($_POST['teacher'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $sql = "";
        $id = trim(mysqli_real_escape_string($mysqli,$_POST['id']));
        $action = trim(mysqli_real_escape_string($mysqli,$_POST['action']));
        $student = trim(mysqli_real_escape_string($mysqli,$_POST['student']));
        $teacher = trim(mysqli_real_escape_string($mysqli,$_POST['teacher']));
        if ($action == "Edit") {
            $sql = "UPDATE student_courses SET student_id=$student,teacher_id=$teacher WHERE id=$id";
        }
        else if ($action == "Delete") {
            $sql = "DELETE FROM student_courses WHERE id=$id";
        }
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
        }
        if ($action == "Delete") {
            header('Location: student-course.php');
            exit();
        }
    }
}
if (isset($_GET['id'])) {
    $mysqli = DB();
    $id = trim(mysqli_real_escape_string($mysqli,$_GET['id']));
    $sql = "SELECT * FROM student_courses WHERE id=".$id;
    $result = mysqli_query($mysqli,$sql);
    $row_student_courses = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $sql = "SELECT * FROM courses WHERE id=".$row_student_courses["course_id"];
    $result = mysqli_query($mysqli,$sql);
    $row_courses = mysqli_fetch_array($result,MYSQLI_ASSOC);
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
                <form action="student-course-edit.php?id=<?php echo $_GET['id']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row" style="font-weight: bold;">Course: <?php echo $row_courses["description"]; ?></div>
                    <div class="row">
                        <select name="student">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM users WHERE role='student' AND course_id=".$row_courses["course_name_id"]." ORDER BY lastname");

                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                echo '<option value="'.$row["id"].'" '.($row["id"] == $row_student_courses["student_id"] ? "selected" : "").'>'.$row["lastname"].', '.$row["firstname"].' '.$row["middlename"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <select name="teacher">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM users WHERE role='teacher' AND course_id=".$row_courses["course_name_id"]." ORDER BY lastname");

                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                echo '<option value="'.$row["id"].'" '.($row["id"] == $row_student_courses["teacher_id"] ? "selected" : "").'>'.$row["lastname"].', '.$row["firstname"].' '.$row["middlename"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Edit" style="width: 100%;"></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Delete" style="width: 100%;"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Edit successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">Student\'s course already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>