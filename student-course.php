<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
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
                <div class="table-row"><div class="table-cell-nav-left"><img src="./images/back.png" data-url="./dashboard.php" style="cursor: pointer;"/></div><div class="table-cell-nav-right"><img src="./images/menu.png"  style="cursor: pointer;"/></div></div>
            </div>
            <div class="table" id="navbar" style="display: none;">
                <div class="table-row"><div class="table-cell-nav-bar" data-url="./student-course-add.php">ADD STUDENT COURSE</div></div>
            </div>
        </div>
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="table">
                <div class="table-row"><div class="table-cell-head">Degree</div><div class="table-cell-head">Course</div><div class="table-cell-head">Teacher</div><div class="table-cell-head">Student</div><div class="table-cell"></div></div>
                <?php
                $mysqli = DB();
                $result = $mysqli->query("
                    SELECT stud_cour.id, 
                    stud_cour.course_id, 
                    stud_cour.student_id, 
                    stud_cour.teacher_id, 
                    cour.description AS description, 
                    usr.firstname AS fname, 
                    usr.lastname AS lname, 
                    usr.middlename AS mname, 
                    usr_t.firstname AS tfname, 
                    usr_t.lastname AS tlname, 
                    usr_t.middlename AS tmname, 
                    cour_n.title AS courtitle 
                    FROM student_courses stud_cour 
                    LEFT JOIN courses cour ON stud_cour.course_id = cour.id 
                    LEFT JOIN users usr ON stud_cour.student_id = usr.id 
                    LEFT JOIN users usr_t ON stud_cour.teacher_id = usr_t.id
                    LEFT JOIN courses_name cour_n ON cour.course_name_id = cour_n.id
                    ");

                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    echo '<div class="table-row"><div class="table-cell">'.$row["courtitle"].'</div><div class="table-cell">'.$row["description"].'</div><div class="table-cell">'.$row["tlname"].', '.$row["tfname"].' '.$row["tmname"].'</div><div class="table-cell">'.$row["lname"].', '.$row["fname"].' '.$row["mname"].'</div><div class="table-cell-button"><img src="./images/edit.png" style="width: 17px;cursor: pointer;transform: scale(1.5);" onclick="location.href=\'student-course-edit.php?id='.$row["id"].'\';"/></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>