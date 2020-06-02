<?php
    error_reporting(0);
    session_start();
    header('Content-Type: application/json');
    include_once('class.misc.php');
    include_once('class.sql.php');
    $sql = new sql();
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
        } else if($_POST['action'] == 'addFriend') {
            $username = $_POST['username'];
            $friend = $_POST['friend'];

            $check = $misc->addFriend($username, $friend);

            if($check['status'] == 1) {
                $result['status'] = 1;
                $result['msg'] = "Friend added succesfully";
            } else if($check['status'] == 0) {
                $result['status'] = 0;
                $result['msg'] = "Sorry, Could not add friend";
                $result['errorMsg'] = $check['errorMsg'];
            } else if($check['status'] == -1) {
                $result['status'] = -1;
                $result['msg'] = "Friend already added";
            } else {
                $result['status'] = -2;
                $result['msg'] = "You can't be friend of yourself";
            }

            echo json_encode($result);
        } else if($_POST['action'] == 'displaySplitingTypes') {
            $data = $sql->getDatas('spliting_types');
            echo json_encode($data);
        } else if($_POST['action'] == 'addIndividualExpense') {
            $username = $_POST['username'];
            $whoPaid = $_POST['whoPaid'];
            $members = $_POST['members'];
            $splitType = $_POST['splitType'];
            $amount = $_POST['amount'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            

            $check = $misc->addIndividualExpense($username, $members, $splitType, $amount, $category, $description, $whoPaid);


            $result['success'] = $check['status'];
            $result['msg'] = $check['msg'];
            echo json_encode($result);

        } else if($_POST['action'] == 'addIndividualCustomExpense') {
            $username = $_POST['username'];
            $whoPaid = $_POST['whoPaid'];
            $members = $_POST['members'];
            $splitType = $_POST['splitType'];
            $amountPaid = $_POST['amountPaid'];
            $owedAmount = $_POST['owedAmount'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            

            $check = $misc->addIndividualCustomExpense($username, $members, $splitType, $amountPaid, $owedAmount, $category, $description, $whoPaid);


            $result['success'] = $check['status'];
            $result['msg'] = $check['msg'];
            echo json_encode($result);
        } else if($_POST['action'] == 'addGroup') {
            $username = $_POST['username'];
            $groupMembers = $_POST['groupMembers'];
            $groupname = $_POST['groupname'];
            
            $result = $misc->addGroup($username, $groupname, $groupMembers);

            if($result['status'] == -4) {
                $result['msg'] = "You alredy have a group by this name";

            } else if($result['status'] == -3) {
                $result['msg'] = "Group Name Invalid";
            
            } else if($result['status'] == -2) {
                $result['msg'] = "Member name invalid";
            
            } else if($result['status'] == -1) {
                $result['msg'] = "At least one more member required";
            
            } else if($result['status'] == 0) {
                $result['msg'] = "Some database error";
            
            } else {
                $result['msg'] = "Group Added!";
            }

            echo json_encode($result);
        } else if($_POST['action'] == 'groupSearch') {
            $username = $_POST['username'];
            $groupname = $_POST['searchData'];

            $check = $sql->getdatas('groups', 'grp_name', $groupname, 'created_by', $username);
            if(count($check) > 0) {
                $result['status'] = 0;
                $result['msg'] = "Group Already Exist";
            } else {
                $result['status'] = 1;
                $result['msg'] = "Available";
            }

            echo json_encode($result);
        } else if($_POST['action'] == 'displayGroups') {
            $username = $_POST['username'];
            $result = $misc->displayGroups($username);

            echo json_encode($result);
        }
    }

    if(isset($_POST["display"])) {
        $username = $sql->escape($_POST['display']);
        

        $result['friends'] = $misc->displayFriends($username);

        if(count($result['friends']) == 0) {
            $result['msg'] = "Add some friends";
        }

        echo json_encode($result);
    }
    if(isset($_POST['search'])) {
        $search = $sql->escape($_POST["search"]);
        $data = $sql->searchData('users', 'username', 'username', $search);
        if(count($data) == 0) {
            $result['status'] = 0;
            $result['msg'] = "No user found";
        } else {
            $result['status'] = 1;
            $result['users'] = $data;
        }
        echo json_encode($result);

    }

    

?>