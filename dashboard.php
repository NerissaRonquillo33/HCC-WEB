<?php
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: /' );
    exit();
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
            <div class="grid-container">
                <div class="grid-item" onclick="location.href='/bills.php';" ><img src="/images/bill.png" style="width: 70px;"><br>Bills</div>
                <div class="grid-item" onclick="location.href='/schedules.php';" ><img src="/images/schedule.svg" style="width: 70px;"><br>Schedules</div>
                <div class="grid-item" onclick="location.href='/grades.php';" ><img src="/images/grades.png" style="width: 70px;"><br>Grades</div>  
                <div class="grid-item" onclick="location.href='/courses.php';" ><img src="/images/course.png" style="width: 70px;"><br>Courses</div>
                <div class="grid-item" onclick="location.href='/users.php';" ><img src="/images/users.png" style="width: 70px;"><br>Users</div>
            </div>
        </div>
        <div class="row" style="margin-top: 30px;margin-bottom: 40px;">
            <button class="btn redlit" onclick="location.href='/logout.php';" >Logout</button>
        </div>
    </div>
</body>
</html>