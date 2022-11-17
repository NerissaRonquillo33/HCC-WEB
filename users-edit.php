<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['id']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['address']) && isset($_POST['contact']) && isset($_POST['year']) && isset($_POST['gender']) && isset($_POST['dob']) && isset($_POST['course'])) {
    if (empty($_POST['id']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['address']) || empty($_POST['contact']) || empty($_POST['year']) || empty($_POST['gender']) || empty($_POST['dob']) || empty($_POST['course'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $id = trim(mysqli_real_escape_string($mysqli,$_POST['id']));
        $action = trim(mysqli_real_escape_string($mysqli,$_POST['action']));
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
        $role = trim(mysqli_real_escape_string($mysqli,$_POST['role']));

        if ($action == "Edit") {
            $sql = "UPDATE users SET firstname='$firstname',middlename='$middlename',lastname='$lastname',address='$address',contact='$contact',gender='$gender',dob='$dob',year='$year',age=$age,course_id=$course,role='$role' WHERE id=$id";
        }
        else if ($action == "Delete") {
            $sql = "DELETE FROM users WHERE id=$id";
        }
        
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
        }

        if ($action == "Delete") {
            header('Location: users.php');
            exit();
        }
        
    }
}
if (isset($_GET['id'])) {
    $mysqli = DB();
    $id = trim(mysqli_real_escape_string($mysqli,$_GET['id']));
    $sql = "SELECT * FROM users WHERE id=".$id;
    $result = mysqli_query($mysqli,$sql);
    $row_user = mysqli_fetch_array($result,MYSQLI_ASSOC);
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
                <form action="users-edit.php?id=<?php echo $_GET['id']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row"><input type="number" name="student_id" placeholder="Student ID" autocomplete="off" value="<?php echo $row_user["student_id"]; ?>" disabled /></div>
                    <div class="row"><input type="text" name="firstname" value="<?php echo $row_user["firstname"]; ?>" placeholder="Firstname" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" required /></div>
                    <div class="row"><input type="text" name="middlename" value="<?php echo $row_user["middlename"]; ?>" placeholder="Middlename" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" /></div>
                    <div class="row"><input type="text" name="lastname" value="<?php echo $row_user["lastname"]; ?>" placeholder="Lastname" pattern="[A-Za-z]+" title="Alphabet only" autocomplete="off" required /></div>
                    <div class="row"><input type="text" name="address" value="<?php echo $row_user["address"]; ?>" placeholder="Address" autocomplete="off" required /></div>
                    <div class="row"><input type="text" pattern="\d*" minlength="11" maxlength="11" title="Numbers only and it should exact 11 numbers" name="contact" value="<?php echo $row_user["contact"]; ?>" placeholder="Contact #" autocomplete="off" required /></div>
                    <div class="row">
                        <select name="gender" required>
                            <option value="Male" <?php echo $row_user["gender"]=='Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $row_user["gender"]=='Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="row"><input type="text" name="dob" value="<?php echo $row_user["dob"]; ?>" placeholder="Date of birth" autocomplete="off" pattern="[0-9-]+" title="Date pattern only" required /></div>
                    <div class="row">
                        <select name="course">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM courses_name");

                            $rows = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows as $row) {
                                echo '<option value="'.$row["id"].'" '.($row_user["course_id"] == $row["id"] ? "selected" : "").'>'.$row["title"].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row">
                        <select name="year" required>
                            <option value="1st Year" <?php echo $row_user["year"]=='1st Year' ? 'selected' : ''; ?>>1st Year</option>
                            <option value="2nd Year" <?php echo $row_user["year"]=='2nd Year' ? 'selected' : ''; ?>>2nd Year</option>
                            <option value="3rd Year" <?php echo $row_user["year"]=='3rd Year' ? 'selected' : ''; ?>>3rd Year</option>
                            <option value="4th Year" <?php echo $row_user["year"]=='4th Year' ? 'selected' : ''; ?>>4th Year</option>
                            <option value="Irregular" <?php echo $row_user["year"]=='Irregular' ? 'selected' : ''; ?>>Irregular</option>
                        </select>
                    </div>
                    <div class="row">
                        <select name="role">
                            <option value="student" <?php echo $row_user["role"] == "student" ? "selected" : ""; ?>>Student</option>
                            <option value="teacher" <?php echo $row_user["role"] == "teacher" ? "selected" : ""; ?>>Teacher</option>
                            <option value="admin" <?php echo $row_user["role"] == "admin" ? "selected" : ""; ?>>Admin</option>
                        </select>
                    </div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Edit" style="width: 100%;"></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Delete" style="width: 100%;"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Update successful.</div>'; ?>
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
                Update successful.
            </div>
        </div>
    </div>
</body>
</html>