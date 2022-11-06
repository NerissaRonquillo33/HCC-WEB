<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['code']) && isset($_POST['description']) && isset($_POST['unit']) && isset($_POST['semester']) && isset($_POST['year'])) {
    if (empty($_POST['code']) || empty($_POST['description']) || empty($_POST['unit']) || empty($_POST['semester']) || empty($_POST['year'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $code = trim(mysqli_real_escape_string($mysqli,$_POST['code']));
        $description = trim(mysqli_real_escape_string($mysqli,$_POST['description']));
        $unit = trim(mysqli_real_escape_string($mysqli,$_POST['unit']));
        $semester = trim(mysqli_real_escape_string($mysqli,$_POST['semester']));
        $year = trim(mysqli_real_escape_string($mysqli,$_POST['year']));

        $sql = "INSERT INTO courses(code,description,unit,semester,year) VALUES('$code','$description',$unit,$semester,$year)";
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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="courses-add.php" method="post">
                    <div class="row"><input type="text" name="code" placeholder="Code" required /></div>
                    <div class="row"><input type="text" name="description" placeholder="Description" required /></div>
                    <div class="row"><input type="number" name="unit" placeholder="Unit" required /></div>
                    <div class="row"><input type="number" name="semester" placeholder="Semester" required /></div>
                    <div class="row"><input type="number" name="year" placeholder="Year" required /></div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <a href="./courses.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a>
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