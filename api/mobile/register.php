<?php
$status = "";
try {

    include_once(dirname(__FILE__).'/../../database/connector.php');
    $json = json_decode(file_get_contents('php://input'), true);
    if (isset($json["secret_key"]) && isset($json["firstname"]) && isset($json["middlename"]) && isset($json["lastname"]) && isset($json["contact"]) && isset($json["gender"]) && isset($json["dob"]) && isset($json["age"]) && isset($json["course"]) && isset($json["username"]) && isset($json["password"])) {
        $mysqli = DB();
        $secret_key = $json["secret_key"];
        $firstname = trim(mysqli_real_escape_string($mysqli,$json["firstname"]));
        $middlename = trim(mysqli_real_escape_string($mysqli,$json["middlename"]));
        $lastname = trim(mysqli_real_escape_string($mysqli,$json["lastname"]));
        $contact = trim(mysqli_real_escape_string($mysqli,$json["contact"]));
        $gender = trim(mysqli_real_escape_string($mysqli,$json["gender"]));
        $dob = trim(mysqli_real_escape_string($mysqli,$json["dob"]));
        $age = trim(mysqli_real_escape_string($mysqli,$json["age"]));
        $course = trim(mysqli_real_escape_string($mysqli,$json["course"]));
        $username = trim(mysqli_real_escape_string($mysqli,$json["username"]));
        $password = trim(mysqli_real_escape_string($mysqli,$json["password"]));
        $token = bin2hex(random_bytes(20));
        $sql = "INSERT INTO users(firstname,middlename,lastname,contact,gender,dob,age,course,username,password,token) VALUES('$firstname','$middlename','$lastname','$contact','$gender','$dob',$age,'$course','$username','$password','$token')";
        try {
            if ($mysqli->query($sql)) $status = "success";
            if ($mysqli->errno) $status = "error";
        } catch (mysqli_sql_exception $e) {
            $status = "duplicate";
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
header('Content-Type: application/json; charset=utf-8');
echo json_encode(array("status" => $status));