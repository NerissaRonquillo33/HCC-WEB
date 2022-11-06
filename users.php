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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <a href="./dashboard.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a><br><br>
            <button class="btn greenie" onclick="location.href='./users-add.php';" >ADD USER</button>
        </div>
        <div class="row">
            <div class="table">
                <?php
                $mysqli = DB();
                $result = $mysqli->query("SELECT * FROM users WHERE role='user'");

                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    echo '<div class="table-row"><div class="table-cell">'.$row["lastname"].", ".$row["firstname"]." ".$row["middlename"].'</div></div>';
                    echo '<div class="table-row-down" style="display: none;"><div class="table-cell-down"><button class="cell-delete">Delete</button></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>