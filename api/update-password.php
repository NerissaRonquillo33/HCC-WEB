<?php
include_once(dirname(__FILE__).'/../database/connector.php');
$json = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
if (isset($json["secret_key"]) && isset($json["username"])) {
    $mysqli = DB();
    $secret_key = $json["secret_key"];
    $username = trim(mysqli_real_escape_string($mysqli,$json["username"]));
    $password = trim(mysqli_real_escape_string($mysqli,$json["password"]));
    $sql = "UPDATE users SET password='$password' WHERE username='$username'";
    try {
        if ($mysqli->query($sql)) $status = "success";
        if ($mysqli->errno) $status = "error";
    } catch (mysqli_sql_exception $e) {
        $status = "duplicate";
    }
    echo json_encode(array("status"=>$status));
} else {
    echo json_encode(array("status"=>"none"));
}