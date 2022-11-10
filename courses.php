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
                <div class="table-row"><div class="table-cell-nav-bar" data-url="./courses-add.php">ADD COURSE</div></div>
            </div>
        </div>
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="table">
                <div class="table-row"><div class="table-cell-head">Degree</div><div class="table-cell-head">Code</div><div class="table-cell-head">Description</div><div class="table-cell-head">Unit</div><div class="table-cell-head">Semester</div><div class="table-cell-head">Year</div><div class="table-cell"></div></div>
                <?php
                $mysqli = DB();
                $result = $mysqli->query("
                    SELECT 
                    cour.id, 
                    cour.course_name_id, 
                    cour.code, 
                    cour.description, 
                    cour.unit, 
                    cour.semester, 
                    cour.year, 
                    cname.title 
                    FROM courses cour
                    LEFT JOIN courses_name cname ON cour.course_name_id=cname.id");

                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    echo '<div class="table-row"><div class="table-cell">'.$row["title"].'</div><div class=<div class="table-cell">'.$row["code"].'</div><div class="table-cell">'.$row["description"].'</div><div class="table-cell">'.$row["unit"].'</div><div class="table-cell">'.$row["semester"].'</div><div class="table-cell">'.$row["year"].'</div><div class="table-cell-button"><img src="./images/edit.png" style="width: 17px;cursor: pointer;transform: scale(1.5);" onclick="location.href=\'courses-edit.php?id='.$row["id"].'\';"/></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>