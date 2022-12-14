<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
$row = array("code"=>"","description"=>"","objectives"=>"","schedule"=>"","unit"=>"","semester"=>"","year"=>"");
if (isset($_POST['action']) && isset($_POST['id']) && isset($_POST['code']) && isset($_POST['courses_name']) && isset($_POST['description']) && isset($_POST['unit']) && isset($_POST['semester']) && isset($_POST['year'])) {
    if (empty($_POST['action']) || empty($_POST['id']) || empty($_POST['code']) || empty($_POST['courses_name']) || empty($_POST['description']) || empty($_POST['unit']) || empty($_POST['semester']) || empty($_POST['year'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $sql = "";
        $id = trim(mysqli_real_escape_string($mysqli,$_POST['id']));
        $action = trim(mysqli_real_escape_string($mysqli,$_POST['action']));
        $courses_name = trim(mysqli_real_escape_string($mysqli,$_POST['courses_name']));
        $code = trim(mysqli_real_escape_string($mysqli,$_POST['code']));
        $description = trim(mysqli_real_escape_string($mysqli,$_POST['description']));
        $objectives = trim(mysqli_real_escape_string($mysqli,$_POST['objectives']));
        $schedule = trim(mysqli_real_escape_string($mysqli,$_POST['schedule']));
        $unit = trim(mysqli_real_escape_string($mysqli,$_POST['unit']));
        $semester = trim(mysqli_real_escape_string($mysqli,$_POST['semester']));
        $year = trim(mysqli_real_escape_string($mysqli,$_POST['year']));
        if ($action == "Edit") {
            $sql = "UPDATE courses SET code='$code',description='$description',unit=$unit,semester=$semester,year=$year,course_name_id=$courses_name,objectives='$objectives',schedule='$schedule' WHERE id=$id";
        }
        else if ($action == "Delete") {
            $sql = "DELETE FROM courses WHERE id=$id";
        }
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
        }
        if ($action == "Delete") {
            header('Location: courses.php');
            exit();
        }
    }
}
if (isset($_GET['id'])) {
    $mysqli = DB();
    $id = trim(mysqli_real_escape_string($mysqli,$_GET['id']));
    $sql = "SELECT * FROM courses WHERE id=".$id;
    $result = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
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
                <form action="courses-edit.php?id=<?php echo $_GET['id']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row">
                        <select name="courses_name">
                            <?php
                            $mysqli = DB();
                            $result = $mysqli->query("SELECT * FROM courses_name");

                            $rows_cn = $result->fetch_all(MYSQLI_ASSOC);
                            foreach ($rows_cn as $row_cn) {
                                echo '<option value="'.$row_cn["id"].'" '.($row_cn["id"]==$row['course_name_id'] ? "selected" : "").'>'.ucfirst($row_cn["title"]).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row"><input type="text" name="code" value="<?php echo $row["code"]; ?>" placeholder="Code" required /></div>
                    <div class="row"><input type="text" name="description" value="<?php echo $row["description"]; ?>" placeholder="Description" required /></div>
                    <div class="row"><input type="text" name="objectives" value="<?php echo $row["objectives"]; ?>" placeholder="Objectives" required /></div>
                    <div class="row"><input type="text" name="schedule" value="<?php echo $row["schedule"]; ?>" placeholder="Schedule" required /></div>
                    <div class="row"><input type="number" name="unit" value="<?php echo $row["unit"]; ?>" placeholder="Unit" required /></div>
                    <div class="row"><input type="number" name="semester" value="<?php echo $row["semester"]; ?>" placeholder="Semester" required /></div>
                    <div class="row"><input type="number" name="year" value="<?php echo $row["year"]; ?>" placeholder="Year" required /></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Edit" style="width: 100%;"></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Delete" style="width: 100%;"></div>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Edit successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">Course already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>