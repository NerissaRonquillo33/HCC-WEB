<?php
include_once(dirname(__FILE__).'/../database/connector.php');
$json = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
if (isset($json["secret_key"]) && isset($json["username"])) {
    $mysqli = DB();
    $secret_key = $json["secret_key"];
    $username = trim(mysqli_real_escape_string($mysqli,$json["username"]));
    $sql = "SELECT * FROM courses";
    $result = $mysqli->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(array("status"=>"success", "results"=>$row));
} else {
    echo json_encode(array("status"=>"none"));
}