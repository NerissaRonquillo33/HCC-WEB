<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['student_id']) && isset($_POST['firstname']) && isset($_POST['address']) && isset($_POST['lastname']) && isset($_POST['contact']) && isset($_POST['year']) && isset($_POST['gender']) && isset($_POST['dob']) && isset($_POST['course']) && isset($_POST['password'])) {
    if (empty($_POST['student_id']) || empty($_POST['firstname']) || empty($_POST['address']) || empty($_POST['lastname']) && isset($_POST['contact']) && isset($_POST['year']) || empty($_POST['gender']) || empty($_POST['dob']) || empty($_POST['course']) || empty($_POST['password'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $student_id = trim(mysqli_real_escape_string($mysqli,$_POST['student_id']));
        $firstname = trim(mysqli_real_escape_string($mysqli,$_POST['firstname']));
        $middlename = trim(mysqli_real_escape_string($mysqli,$_POST['middlename']));
        $lastname = trim(mysqli_real_escape_string($mysqli,$_POST['lastname']));
        $address = trim(mysqli_real_escape_string($mysqli,$_POST['address']));
        $contact = trim(mysqli_real_escape_string($mysqli,$_POST['contact']));
        $gender = trim(mysqli_real_escape_string($mysqli,$_POST['gender']));
        $dob = trim(mysqli_real_escape_string($mysqli,$_POST['dob']));
        $year = trim(mysqli_real_escape_string($mysqli,$_POST['year']));
        $date1 = new DateTime($dob);
        $date2 = new DateTime(date("Y-m-d"));
        $days  = $date2->diff($date1)->format('%a');
        $age = $days / 365;
        $age = (int)$age;
        $course = trim(mysqli_real_escape_string($mysqli,$_POST['course']));
        $username = $student_id;
        $password = "rODeCOLEDgEN";
        $role = trim(mysqli_real_escape_string($mysqli,$_POST['role']));
        $token = bin2hex(random_bytes(20));

        $sql = "INSERT INTO users(student_id,firstname,middlename,lastname,contact,gender,dob,age,course_id,username,password,token,role,year,address) VALUES($student_id,'$firstname','$middlename','$lastname','$contact','$gender','$dob',$age,$course,'$username','$password','$token','$role','$year','$address')";
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
    <link rel="stylesheet" type="text/css" href="./css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="./js/jquery.min.js"></script>
    <script src="./js/jquery-ui.min.js"></script>
    <script src="./js/main.js"></script>
</head>
<body>
    <div class="container">
        <div class="row header-sub-menu">
            <div class="table">
                <div class="table-row"><div class="table-cell-nav-left"><img src="./images/back.png" data-url="./users.php" style="cursor: pointer;"/></div></div>
            </div>
        </div>
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="users-add.php" method="post">
                    <div class="row"><input type="number" name="student_id" placeholder="Student ID" autocomplete="off" required /></div>
                    <div class="row"><input type="text" name="firstname" placeholder="Firstname" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" required /></div>
                    <div class="row"><input type="text" name="middlename" placeholder="Middlename" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" /></div>
                    <div class="row"><input type="text" name="lastname" placeholder="Lastname" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" required /></div>
                    <div class="row"><input type="text" name="address" placeholder="Address" autocomplete="off" required /></div>
                    <div class="row"><input type="text" pattern="\d*" minlength="11" maxlength="11" title="Numbers only and it should exact 11 numbers" name="contact" placeholder="Contact #" autocomplete="off" required /></div>
                    <div class="row">
                        <select name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="row"><input type="text" name="dob" placeholder="Date of birth" autocomplete="off" pattern="[0-9-]+" title="Date pattern only" required /></div>
                    <div class="row">
                        <select name="course">
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
                    <div class="row">
                        <select name="year" required>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="Irregular">Irregular</option>
                        </select>
                    </div>
                    <div class="row"><input type="text" name="password" placeholder="Password" autocomplete="off" value="rODeCOLEDgEN" readonly="readonly" /></div>
                    <div class="row">
                        <select name="role">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="row"><input class="primary" type="submit" value="Add"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Added successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">User already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
    <div id="popup" class="overlay  <?php if ($status != "success") echo 'overlay-hidden'; ?>">
        <div class="popup">
            <h2 style="color: green;">Success</h2>
            <a class="close" href="#">&times;</a>
            <div class="content" style="font-style: italic;">
                Added successful.
            </div>
        </div>
    </div>
</body>
</html>