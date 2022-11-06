<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if ( !isset( $_SESSION['username'] ) ) {
    header( 'Location: ./' );
    exit();
}
$status = "";
$row = array("title"=>"","description"=>"");
if (isset($_POST['action']) && isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description'])) {
    if (empty($_POST['action']) || empty($_POST['id']) || empty($_POST['title']) || empty($_POST['description'])) {
        $status = "none";
    } else {
        $mysqli = DB();
        $sql = "";
        $id = trim(mysqli_real_escape_string($mysqli,$_POST['id']));
        $action = trim(mysqli_real_escape_string($mysqli,$_POST['action']));
        $title = trim(mysqli_real_escape_string($mysqli,$_POST['title']));
        $description = trim(mysqli_real_escape_string($mysqli,$_POST['description']));
        if ($action == "Edit") {
            $sql = "UPDATE schedules SET title='$title',description='$description' WHERE id=$id";
        }
        else if ($action == "Delete") {
            $sql = "DELETE FROM schedules WHERE id=$id";
        }
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
        }
        if ($action == "Delete") {
            header('Location: schedules.php');
            exit();
        }
    }
}
if (isset($_GET['id'])) {
    $mysqli = DB();
    $id = trim(mysqli_real_escape_string($mysqli,$_GET['id']));
    $sql = "SELECT * FROM schedules WHERE id=".$id;
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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="logo"><img src="./images/logo.png"/></div>
        </div>
        <div class="row">
            <div class="forms">
                <form action="schedules-edit.php?id=<?php echo $_GET['id']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row"><input type="text" name="title" value="<?php echo $row["title"]; ?>" placeholder="Title" required /></div>
                    <div class="row"><input type="text" name="description" value="<?php echo $row["description"]; ?>" placeholder="Description" required /></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Edit" style="width: 100%;"></div>
                    <div class="row"><input class="primary" type="submit" name="action" value="Delete" style="width: 100%;"></div>
                    <a href="./schedules.php" style="color: blue;text-decoration: none;">&lt;&lt; Back</a>
                    <?php if ($status == "none") echo '<div class="row" style="color: red;">Please fill the textboxes.</div>'; ?>
                    <?php if ($status == "success") echo '<div class="row" style="color: green;">Edit successful.</div>'; ?>
                    <?php if ($status == "error") echo '<div class="row" style="color: red;">Errors during insert.</div>'; ?>
                    <?php if ($status == "duplicate") echo '<div class="row" style="color: red;">Schedules already in database.</div>'; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>