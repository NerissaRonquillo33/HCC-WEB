<?php
include_once(dirname(__FILE__).'/database/connector.php');
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    die();
}
if (!isset($_POST['username']) && !isset($_POST['password'])) {
    header('Location: index.php?status=none');
    die();
}
if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: index.php?status=none');
    die();
}
$mysqli = DB();
$username = trim(mysqli_real_escape_string($mysqli,$_POST['username']));
$password = trim(mysqli_real_escape_string($mysqli,$_POST['password']));

$sql = "SELECT id FROM users WHERE username = '$username' and password = '$password'";
$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if($count > 0) {
    $_SESSION['username'] = $username;
    header("location: dashboard.php");
}else {
    header("location: index.php?status=denied");
}