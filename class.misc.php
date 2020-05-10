<?php
class misc {
    protected $sql;
    public function __construct() {
        include_once('class.config.php');
        $config = new config();
		$base = $config->baseServer; 
        require_once($_SERVER['DOCUMENT_ROOT'].$base.'class.sql.php');
        $this->sql = new sql();
    }
    public function getUser($username) {
        $username = $this->sql->escape($username);
        return $this->sql->getDataOnlyOne('users', 'username', $username);
    }
    public function checkPassword($username, $password) {
        $username = $this->sql->escape($username);
        $password = $this->sql->escape($password);
        $password = md5($password);
        if($password == $this->sql->getData('password', 'login', 'username', $username )) {
            return true;
        }
        return false;
    }
    public function checkIfUserValid($username) {
        $username = $this->sql->escape($username);
        if($this->sql->countData('users', 'username', $username) == 1) {
            return true;
        }
        return false;
    }
    public function getPasswordChangeCount($username) {
        $username = $this->sql->escape($username);
        if($this->checkIfUserValid($username)) {
            return $this->sql->getData('password_change_count', 'login', 'username', $username);
        }
        return false;
    }
    public function setPassword($username, $newPassword) {
        $username = $this->sql->escape($username);
        $newPassword = $this->sql->escape($newPassword);
        if($newPassword == "" or strlen($newPassword) < 6) {
            return false;
        } 
        try {
            $newPassword = md5($newPassword);
            $this->sql->query = "UPDATE `login` SET `password` = '$newPassword', `password_change_count` = `password_change_count` + 1 WHERE username = '$username' ";
            $this->sql->process();
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function checkLogin($username, $password) {
        $username = $this->sql->escape($username);
        $password = $this->sql->escape($password);
        if($username == "") {
            $result['status'] = -2;
        }
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
            $result['status'] = -3;

        } elseif($this->sql->countData('users', 'username', $username) == 1) {
            $password = md5($password);
            
            if($this->sql->countData('login', 'username', $username, 'password', $password) == 1) {
                $result = $this->sql->getDataOnlyOne('users', 'username', $username);
                $result['status'] = 1;
            
            } else {
                $result['status'] = 0;
            }
        } else {
            $result['status'] = -1;
        }
        return $result;
    }

    public function checkUsernameAvailability($username) {
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)) {
            $result['status'] = -2;
            return $result;
        } elseif($username == '') {
            $result['status'] = -1;
            return $result;
        } 
        
        $username = $this->sql->escape($username);
        if($this->sql->countData('users', 'username', $username) == 1) {
            $result['status'] = 0;
        } else {
            $result['status'] = 1;
        }
        return $result;
    }

    public function makeAccount($username, $name, $email, $password) {
        $username = $this->sql->escape($username);
        $name = $this->sql->escape($name);
        $email = $this->sql->escape($email);
        $password = $this->sql->escape($password);
        // $PIN = $this->generatePIN();
        $password = md5($password);
        $username = strtolower($username);

        // blank errors handling
        if($username == ''){$result['status'] = -1; $result['errorField'] = 'username';$result['errorMsg'] = 'Username cannot be blank'; return $result;}
        if($name == ''){$result['status'] = -1; $result['errorField'] = 'name';$result['errorMsg'] = 'Name cannot be blank'; return $result;}
        if($email == ''){$result['status'] = -1; $result['errorField'] = 'email';$result['errorMsg'] = 'Email cannot be blank'; return $result;}
        if($password == ''){$result['status'] = -1; $result['errorField'] = 'password';$result['errorMsg'] = 'Password cannot be blank'; return $result;}

        // content correctness
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)){$result['status'] = -1;$result['errorField'] = 'username';$result['errorMsg'] = 'Username Invalid'; return $result;}
        if(!preg_match("/^[a-zA-Z ]*$/",$name)) {$result['status'] = -1;$result['errorField'] = 'name';$result['errorMsg'] = 'Only letters and whitespace allowed'; return $result;}
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){$result['status'] = -1; $result['errorField'] = 'email';$result['errorMsg'] = 'Email Invalid'; return $result;}
        if(strlen($password) < 6){$result['status'] = -1; $result['errorField'] = 'password';$result['errorMsg'] = 'Must be atleast 6 characters'; return $result;}

        $result = $this->checkUsernameAvailability($username);
        if($result['status'] != 1) {
            $result['errorField'] = 'username';
            $result['errorMsg'] = 'Username already taken'; 
            return $result;
        }

        try {
            $this->sql->query = "INSERT INTO `users` (username,name,email) values('$username','$name','$email')";
            $this->sql->process();
            $this->sql->query = "INSERT INTO `login` (username,password) values('$username','$password')";
            $this->sql->process();
            // $send_mail_check() = $this->sendEmailVerification($username, $email);
            // if($send_mail_check == -1) {
            //     $result['msg'] = "Sending Mail Failed or Cannot contact your email!";
            // }
        } catch(Exception $e) {
            $result['status'] = 0;
            $result['exception'] = $e;
            return $result;
        }

        $result['status'] = 1;
        $result['username'] = $username;
        return $result;
    }


    public function addFriend($username, $friend) {
        $username = $this->sql->escape($username);
        $friend = $this->sql->escape($friend);

        // blank errors 
        if($friend == ''){$result['status'] = 0; $result['errorMsg'] = 'Friend Name cannot be blank'; return $result;}
        // correctness checking
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $friend)){$result['status'] = 0; $result['errorMsg'] = 'Invalid Name'; return $result;}
    
        // check if friend already exists
        if($this->sql->countData('friends', 'username', $username, 'friendname', $friend) == 1) {
            $result['status'] = -1;
            return $result;
        }
        if($this->sql->countData('friends', 'username', $friend, 'friendname', $username) == 1) {
            $result['status'] = -1;
            return $result;
        }

        try {
            $this->sql->query = "INSERT INTO `friends` (username,friendname) values('$username', '$friend')";
            $this->sql->process();
        } catch(Exception $e) {
            $result['status'] = 0;
            return $result;
        }
        
        $result['status'] = 1;
        return $result;
    }
    

    public function displayFriends($username) {
        $username = $this->sql->escape($username);
        
        $result = $this->sql->getDistinctDatas('friendname', 'friends', 'username', $username);
        $result2 = $this->sql->getDistinctDatas('username', 'friends', 'friendname', $username);

        foreach($result2 as &$name) {
            array_push($result, $name);
        }
        return $result;
    }

    
    public function addExpense($username, $with, $splittype, $amount, $category, $description) {
        $username = $this->sql->escape($username);
        $with = $this->sql->escape($with);
        $splittype = $this->sql->escape($splittype);
        $paidAmount = $this->sql->escape($amount);
        $category = $this->sql->escape($category);
        $description = $this->sql->escape($description);
        $dateToday = date('Y-m-d H:i:s');

        // check with value
        $allfriends = $this->displayFriends($username);
        $found = 0;
        foreach($allfriends as &$friend) {
            if(strcmp($with, $friend) == 0) {
                $found = 1;
                break;
            }
        }
        if($found == 0) {
            $result['status'] = -1;
            $result['msg'] = "Friend not found, You must add Friend first!";
            return $result;
        }
        // check splittype
        if(strcmp($splittype, "none") == 0) {
            $result['status'] = -1;
            $result['msg'] = "Choose a type to split Amount!";
            return $result;
        }
        // check amount
        if($amount <= 0) {
            $result['status'] = -1;
            $result['msg'] = "Amount is improper!";
            return $result;
        }
        // add check for invalid characters 
        // category and description
        if(strcmp($category, "") == 0 || strcmp($description, "") == 0) {
            $result['status'] = -1;
            $result['msg'] = "Category or description not filled!";
            return $result;
        }

        // segregation
        if(strcmp($splittype, "youpaidsplitequally") == 0) {
            $paidBy = $username;
            $owedBy = $with;
            $owedAmount = $paidAmount/2;

        } else if(strcmp($splittype, "friendpaidsplitequally") == 0) {
            $paidBy = $with;
            $owedBy = $username;
            $owedAmount = $paidAmount/2;

        } else if(strcmp($splittype, "friendowecomplete") == 0) {
            $paidBy = $username;
            $owedBy = $with;
            $owedAmount = $paidAmount;

        } else {        // youowecomplete
            $paidBy = $with;
            $owedBy = $username;
            $owedAmount = $paidAmount;
        }

        // insert data
        try {
            $this->sql->query = "INSERT INTO `expense` (paidBy, owedBy, paidAmount, owedAmount, category ,description ,date) values('$paidBy', '$owedBy', '$paidAmount', '$owedAmount', '$category', '$description', '$dateToday')";
            $this->sql->process();
        } catch(Exception $e) {
            $result['status'] = -1;
            $result['msg'] = "Some server error!";
            return $result;
        }

        // everthing goes ok, then
        $result['status'] = 1;
        $result['msg'] = "Split Done!";
        return $result;
    }


    public function showExpensesForSelectedFriend($username, $friend) {
        $username = $this->sql->escape($username);
        $friend = $this->sql->escape($friend);

        $rows1 = $this->sql->getDatas('expense', 'paidBy', $username, 'owedBy', $friend);
        $rows2 = $this->sql->getDatas('expense', 'paidBy', $friend, 'owedBy', $username);
        foreach($rows2 as &$item) {
            array_push($rows1, $item);
        }
        return $rows1;
    }
}
?>