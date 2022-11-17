<?php
$status = "";
$info = array();
try {

    include_once(dirname(__FILE__).'/../../database/connector.php');
    $json = json_decode(file_get_contents('php://input'), true);
    if (isset($json["secret_key"]) && isset($json["username"]) && isset($json["id"])) {
        $mysqli = DB();
        $secret_key = $json["secret_key"];
        $id = trim(mysqli_real_escape_string($mysqli,$json["id"]));
        $username = trim(mysqli_real_escape_string($mysqli,$json["username"]));
        $sql = "SELECT * FROM courses WHERE id=".$id;
        $result = mysqli_query($mysqli,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
        if($count > 0) {
            $info = $row;
            $status = "success";
        }else {
            $status = "denied";
        }
    } else {
        $status = "none";
    }

}
catch(Exception $e) {
    $status = "error";
}
catch(Error $e) {
    $status = "error";
}
$info["status"] = $status;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($info);