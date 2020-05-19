<?php
    error_reporting(0);
    session_start();
    header('Content-Type: application/json');
    include_once('class.misc.php');
    $misc = new misc();
    $result = [];

    if(isset($_POST['action'])) {
        if($_POST['action'] == 'checkUsernameAvailability') {
            $check = $misc->checkUsernameAvailability($_POST['username']);
            if($check['status'] == 1){
                $result['success'] = true;
                $result['msg'] = 'Available';
            }
            elseif($check['status'] == 0){
                $result['success'] = false;
                $result['msg'] = "Username already exists";
            }
            elseif($check['status'] == -1){
                $result['success'] = false;
                $result['msg'] = "Username Cannot Be Blank";
            }
            elseif($check['status'] == -2){
                $result['success'] = false;
                $result['msg'] = "Username Invalid, Special Characters used";
            }
            echo json_encode($result);
        } elseif($_POST['action'] == 'makeAccount') {
            $username = $_POST['username'];
            $check = $misc->checkUsernameAvailability($username);
            if($check['status'] != 1) {
                $result['success'] = false;
                $result['msg'] = "Check for errors in your form!";
            }
            
            $check = $misc->makeAccount($username, $_POST['name'], $_POST['email'], $_POST['password']); 
            if($check['status'] == 1) {
                $result['status'] = 1;
                $result['msg'] = "Please verify your account";
                // $_SESSION['user'] = $check['username'];
                // $_SESSION['usertype'] = $check['usertype'];
                // $_SESSION['password_change_count'] = $logged['password_change_count'];
            
            } elseif($check['status'] == 0) {
                $result['success'] = 0;
                $result['msg'] = "Some error caused, please contact team";
                $result['exception'] = $check['exception'];
            
            } elseif($check['status'] == -1) {
                $result['success'] = -1;
                $result['msg'] = "Please fill the form properly";
                $result['errorField'] = $check['errorField'];
                $result['errorMsg'] = $check['errorMsg'];
            }
            echo json_encode($result);
        } else if($_POST['action'] == 'login') {
            $logged = $misc->checkLogin($_POST['username'], $_POST['password']);

            if($logged['status'] == 1) {
                $result['success'] = true;
                $result['msg'] = "Welcom ".$logged['name'];
                $_SESSION['user'] = $logged['username'];

                // If password chang count is change logout
                $result['password_change_count'] = $logged['password_change_count'];
                $_SESSION['password_change_count'] = $logged['password_change_count'];
            }  elseif($logged['status'] == 0) {
                $result['success'] = false;
                $result['msg'] = "Username and Password do not Match";
                
            } elseif($logged['status'] == -1) {
                $result['success'] = false;
                $result['msg'] = "User Id not Registered";
                
            } elseif($logged['status'] == -2) {
                $result['success'] = false;
                $result['msg'] = "Username cannot be blank";
                
            } elseif($logged['status'] == -3) {
                $result['success'] = false;
                $result['msg'] = "Username Invalid";
            }
            echo json_encode($result);
        }
    }

    

?>