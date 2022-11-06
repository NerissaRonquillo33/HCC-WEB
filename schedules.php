<?php
include_once(dirname(__FILE__).'/database/connector.php');
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
            <a href="/dashboard.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a><br><br>
            <button class="btn greenie" onclick="location.href='/schedules-add.php';" >ADD SCHEDULE</button>
        </div>
        <div class="row">
            <div class="table">
                <?php
                $mysqli = DB();
                $result = $mysqli->query("SELECT * FROM schedules");

                $rows = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($rows as $row) {
                    echo '<div class="table-row"><div class="table-cell">'.$row["title"].'</div><div class="table-cell">'.$row["description"].'</div><div class="table-cell-button"><img src="/images/edit.png" style="width: 17px;cursor: pointer;transform: scale(1.5);" onclick="location.href=\'schedules-edit.php?id='.$row["id"].'\';"/></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>