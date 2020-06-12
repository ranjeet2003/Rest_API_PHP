<?php
ini_set("display_errors", 1);
    // include headers
    header("Access-Control-Allow-Origin: *"); //it allow all origins like localhost, any domain or any subdomain
    // data which we are getting inside request
    header("Content-type: application/json; charset: UTF-8");

    header("Access-Control-Allow-Methods: POST");
    // include database.php
    include_once("../config/database.php");
    include_once("../classes/student.php");
    // create object for database
    $db = new Database();
    $connection = $db->connect();
    // create object for student
    $student =  new Student($connection);
    if($_SERVER['REQUEST_METHOD']==="POST"){
        $param=json_decode(file_get_contents("php://input"));
        if(!empty($param->id)){
            $student->id=$param->id;
            $student_data=$student->get_single_student();
            // print_r($student_data);
            if(!empty($student_data)){
                http_response_code(200);
                echo json_encode(array(
                    "status"=>1,
                    "data"=> $student_data
                ));
            } else {
                http_response_code(404);
                echo json_encode(array(
                    "status"=>0,
                    "message"=>"Student not found"
                ));
            }
        }

    }
    else{
        http_response_code(503);
        echo json_encode(array(
            "status"=>0,
            "message"=>"Access Denied"
        ));
    }

?>