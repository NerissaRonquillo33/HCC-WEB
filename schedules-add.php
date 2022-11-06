<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: /' );
    exit();
}
$status = "";
if (isset($_POST['title']) && isset($_POST['description'])) {
    if (empty($_POST['title']) || empty($_POST['description'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $title = trim(mysqli_real_escape_string($mysqli,$_POST['title']));
        $description = trim(mysqli_real_escape_string($mysqli,$_POST['description']));

        $sql = "INSERT INTO schedules(title,description) VALUES('$title','$description')";
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
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo"><img src="/images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="schedules-add.php" method="post">
                    <div class="row"><input type="text" name="title" placeholder="Title" required /></div>
                    <div class="row"><input type="text" name="description" placeholder="Description" required /></div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <a href="/schedules.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a>
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