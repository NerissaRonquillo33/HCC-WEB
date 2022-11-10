<?php
header('Content-Type: application/json; charset=utf-8');
if (isset($_GET['id'])) {

    if (!empty($_GET['id']) && is_numeric($_GET['id'])) {

        include_once(dirname(__FILE__).'/../../database/connector.php');
        $mysqli = DB();
        $id = $_GET['id'];
        $role = $_GET['role'];
        $sql = "SELECT * FROM users WHERE role='".$role."' AND course_id=".$id;
        $result = $mysqli->query($sql);
        $row = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(array("status"=>"success", "results"=>$row));
        exit();

    }

}
echo json_encode(array("status"=>"none"));