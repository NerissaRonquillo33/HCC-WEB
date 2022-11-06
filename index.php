<?php
session_start();
if ( isset( $_SESSION['username'] ) ) {
    header( 'Location: dashboard.php' );
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
            <div class="forms">
                <form action="login.php" method="post">
                    <div class="row"><input type="text" name="username" placeholder="Username" required /></div>
                    <div class="row"><input type="password" name="password" placeholder="Password" required /></div>
                    <div class="row"><input class="primary" type="submit" value="Login"></div>
                    <?php if (isset($_GET['status']) && $_GET['status'] == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if (isset($_GET['status']) && $_GET['status'] == "denied") echo '<div class="row" style="color: red;">Access denied.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>