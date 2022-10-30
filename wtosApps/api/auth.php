<?php
header('Content-Type: application/json');
include('../../wtosConfig.php'); // load configuration
include('../os.php'); // load wtos Library
global $site, $os;

/*****
 * Login
 */
if($os->get("login")=="OK") {

    $username = $os->get("username");
    $password = $os->get("password");

    $student  = $os->mfa($os->mq("SELECT * FROM student WHERE registerNo='$username' AND otpPass='$password'"));

    $res = [
        "status"=>"FAILED",
        "message"=>"Wrong Username or Password",
        "sql"=>$os->query
    ];
    if($student){
        $res["status"] = "SUCCESS";
        $res["message"] = "Successfully logged in";
        $res["student"] = $student;
    }

    print  json_encode($res);
}
