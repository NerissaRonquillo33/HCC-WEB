<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
if (isset($_POST['id']) && isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname']) && isset($_POST['contact']) && isset($_POST['gender']) && isset($_POST['dob']) && isset($_POST['age']) && isset($_POST['course'])) {
    if (empty($_POST['id']) || empty($_POST['firstname']) || empty($_POST['middlename']) || empty($_POST['lastname']) || empty($_POST['contact']) || empty($_POST['gender']) || empty($_POST['dob']) || empty($_POST['age']) || empty($_POST['course'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $id = trim(mysqli_real_escape_string($mysqli,$_POST['id']));
        $action = trim(mysqli_real_escape_string($mysqli,$_POST['action']));
        $firstname = trim(mysqli_real_escape_string($mysqli,$_POST['firstname']));
        $middlename = trim(mysqli_real_escape_string($mysqli,$_POST['middlename']));
        $lastname = trim(mysqli_real_escape_string($mysqli,$_POST['lastname']));
        $contact = trim(mysqli_real_escape_string($mysqli,$_POST['contact']));
        $gender = trim(mysqli_real_escape_string($mysqli,$_POST['gender']));
        $dob = trim(mysqli_real_escape_string($mysqli,$_POST['dob']));
        $age = trim(mysqli_real_escape_string($mysqli,$_POST['age']));
        $course = trim(mysqli_real_escape_string($mysqli,$_POST['course']));
        $role = trim(mysqli_real_escape_string($mysqli,$_POST['role']));

        if ($action == "Edit") {
            $sql = "UPDATE users SET firstname='$firstname',middlename='$middlename',lastname='$lastname',contact='$contact',gender='$gender',dob='$dob',age=$age,course_id=$course,role='$role' WHERE id=$id";
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
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="./js/jquery.min.js"></script>
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
                    <div class="row"><input type="text" name="firstname" value="<?php echo $row_user["firstname"]; ?>" placeholder="Firstname" required /></div>
                    <div class="row"><input type="text" name="middlename" value="<?php echo $row_user["middlename"]; ?>" placeholder="Middlename" required /></div>
                    <div class="row"><input type="text" name="lastname" value="<?php echo $row_user["lastname"]; ?>" placeholder="Lastname" required /></div>
                    <div class="row"><input type="text" name="contact" value="<?php echo $row_user["contact"]; ?>" placeholder="Contact #" required /></div>
                    <div class="row"><input type="text" name="gender" value="<?php echo $row_user["gender"]; ?>" placeholder="Gender" required /></div>
                    <div class="row"><input type="text" name="dob" value="<?php echo $row_user["dob"]; ?>" placeholder="Date of birth" required /></div>
                    <div class="row"><input type="number" name="age" value="<?php echo $row_user["age"]; ?>" placeholder="Age" required /></div>
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
</body>
</html>