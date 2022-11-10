<?php
include_once(dirname(__FILE__).'/../database/connector.php');
$json = json_decode(file_get_contents('php://input'), true);
header('Content-Type: application/json; charset=utf-8');
if (isset($json["secret_key"]) && isset($json["username"])) {
    $mysqli = DB();
    $secret_key = $json["secret_key"];
    $username = trim(mysqli_real_escape_string($mysqli,$json["username"]));
    $result = mysqli_query($mysqli,"SELECT id FROM users WHERE username='".$username."'");
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $sql = "SELECT student_courses.id,student_courses.student_id,student_courses.teacher_id,courses.course_name_id,courses.code,courses.description,courses.unit,courses.semester,courses.year FROM student_courses 
    LEFT JOIN courses
    ON student_courses.course_id = courses.id
    WHERE student_courses.student_id=".$row["id"];
    $result = $mysqli->query($sql);
    $row = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(array("status"=>"success", "results"=>$row));
} else {
    echo json_encode(array("status"=>"none"));
}