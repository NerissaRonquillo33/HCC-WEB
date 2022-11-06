<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname']) && isset($_POST['contact']) && isset($_POST['gender']) && isset($_POST['dob']) && isset($_POST['age']) && isset($_POST['course']) && isset($_POST['username']) && isset($_POST['password'])) {
    if (empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['lastname']) || empty($_POST['contact']) || empty($_POST['gender']) || empty($_POST['dob']) || empty($_POST['age']) || empty($_POST['course']) || empty($_POST['username']) || empty($_POST['password'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $firstname = trim(mysqli_real_escape_string($mysqli,$_POST['firstname']));
        $middlename = trim(mysqli_real_escape_string($mysqli,$_POST['middlename']));
        $lastname = trim(mysqli_real_escape_string($mysqli,$_POST['lastname']));
        $contact = trim(mysqli_real_escape_string($mysqli,$_POST['contact']));
        $gender = trim(mysqli_real_escape_string($mysqli,$_POST['gender']));
        $dob = trim(mysqli_real_escape_string($mysqli,$_POST['dob']));
        $age = trim(mysqli_real_escape_string($mysqli,$_POST['age']));
        $course = trim(mysqli_real_escape_string($mysqli,$_POST['course']));
        $username = trim(mysqli_real_escape_string($mysqli,$_POST['username']));
        $password = trim(mysqli_real_escape_string($mysqli,$_POST['password']));
        $token = bin2hex(random_bytes(20));

        $sql = "INSERT INTO users(firstname,middlename,lastname,contact,gender,dob,age,course,username,password,token) VALUES('$firstname','$middlename','$lastname','$contact','$gender','$dob',$age,'$course','$username','$password','$token')";
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
                <form action="users-add.php" method="post">
                    <div class="row"><input type="text" name="firstname" placeholder="Firstname" required /></div>
                    <div class="row"><input type="text" name="middlename" placeholder="Middlename" required /></div>
                    <div class="row"><input type="text" name="lastname" placeholder="Lastname" required /></div>
                    <div class="row"><input type="text" name="contact" placeholder="Contact #" required /></div>
                    <div class="row"><input type="text" name="gender" placeholder="Gender" required /></div>
                    <div class="row"><input type="text" name="dob" placeholder="Date of birth" required /></div>
                    <div class="row"><input type="number" name="age" placeholder="Age" required /></div>
                    <div class="row"><input type="text" name="course" placeholder="Course" required /></div>
                    <div class="row"><input type="text" name="username" placeholder="Username" required /></div>
                    <div class="row"><input type="text" name="password" placeholder="Password" required /></div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <a href="./users.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Added successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">User already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>