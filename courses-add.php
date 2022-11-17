<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['code']) && isset($_POST['courses_name']) && isset($_POST['description']) && isset($_POST['unit']) && isset($_POST['semester']) && isset($_POST['year'])) {
    if (empty($_POST['code']) || empty($_POST['courses_name']) || empty($_POST['description']) || empty($_POST['unit']) || empty($_POST['semester']) || empty($_POST['year'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $courses_name = trim(mysqli_real_escape_string($mysqli,$_POST['courses_name']));
        $code = trim(mysqli_real_escape_string($mysqli,$_POST['code']));
        $description = trim(mysqli_real_escape_string($mysqli,$_POST['description']));
        $objectives = trim(mysqli_real_escape_string($mysqli,$_POST['objectives']));
        $schedule = trim(mysqli_real_escape_string($mysqli,$_POST['schedule']));
        $unit = trim(mysqli_real_escape_string($mysqli,$_POST['unit']));
        $semester = trim(mysqli_real_escape_string($mysqli,$_POST['semester']));
        $year = trim(mysqli_real_escape_string($mysqli,$_POST['year']));

        $sql = "INSERT INTO courses(code,description,unit,semester,year,course_name_id,objectives,schedule) VALUES('$code','$description',$unit,$semester,$year,$courses_name,'$objectives','$schedule')";
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
                <div class="table-row"><div class="table-cell-nav-left"><img src="./images/back.png" data-url="./courses.php" style="cursor: pointer;"/></div></div>
            </div>
        </div>
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="courses-add.php" method="post">
                    <div class="row">
                        <select name="courses_name">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM courses_name");

                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                echo '<option value="'.$row["id"].'">'.ucfirst($row["title"]).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row"><input type="text" name="code" placeholder="Code" required /></div>
                    <div class="row"><input type="text" name="description" placeholder="Description" required /></div>
                    <div class="row"><input type="text" name="objectives" placeholder="Objectives" required /></div>
                    <div class="row"><input type="text" name="schedule" placeholder="Schedule" required /></div>
                    <div class="row"><input type="number" name="unit" placeholder="Unit" required /></div>
                    <div class="row"><input type="number" name="semester" placeholder="Semester" required /></div>
                    <div class="row"><input type="number" name="year" placeholder="Year" required /></div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Added successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">Course already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>