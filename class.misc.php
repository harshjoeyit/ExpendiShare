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
        if($newPassword = "" or strlen($newPassword) < 6) {
            return false;
        }
        try {
            $newPassword = md5($newPassword);
            $this->sql->query = "UPDATE 'login' SET 'password' = '$newPassword', 'password_change_count' = 'password_change_count' + 1 WHERE username = '$username'";
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
        $password = md5($password);
        $username = strtolower($username);

        // !blank errors handling
        if($username == ''){
            $result['status'] = -1;
            $result['errorField'] = 'username';
            $result['errorMsg'] = 'Username cannot be blank'; return $result;
        }
        if($name == ''){
            $result['status'] = -1;
            $result['errorField'] = 'name';
            $result['errorMsg'] = 'Name cannot be blank';
            return $result;
        }
        if($email == ''){
            $result['status'] = -1;
            $result['errorField'] = 'email';
            $result['errorMsg'] = 'Email cannot be blank';
            return $result;
        }
        if($password == ''){
            $result['status'] = -1; 
            $result['errorField'] = 'password';
            $result['errorMsg'] = 'Password cannot be blank'; return $result;
        }

        // !content correctness
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)){
            $result['status'] = -1;
            $result['errorField'] = 'username';
            $result['errorMsg'] = 'Username Invalid';
            return $result;
        }
        if(!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $result['status'] = -1;
            $result['errorField'] = 'name';
            $result['errorMsg'] = 'Only letters and whitespace allowed';
            return $result;
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result['status'] = -1;
            $result['errorField'] = 'email';
            $result['errorMsg'] = 'Email Invalid';
            return $result;
        }
        if(strlen($password) < 6){
            $result['status'] = -1;
            $result['errorField'] = 'password';
            $result['errorMsg'] = 'Must be atleast 6 characters'; return $result;
        }


        $result = $this->checkUsernameAvailability($username);
        if($result['status'] != 1) {
            $result['errorField'] = 'username';
            $result['errorMsg'] = 'Username already taken'; 
            return $result;
        }

        try {
            $this->sql->query = "INSERT INTO `users` (username,name,email) values('$username','$name','$email')";
            $this->sql->process();

            $lastId = $this->sql->getDistinctDatas('id', 'users', 'username', $username);
            $token = sha1($lastId[0]);
            $url = 'http://' . $_SERVER['SERVER_NAME'] .'/ExpendiShare' . '/verify.php?id=' .$lastId[0] . '&token=' .$token;

            $html = '<div>Thanks for registering with ExpendiShare. Please click this link to complete your registration:<br>' .$url. '</div>';
            require 'sendmail.php';
            $mail_feedback = sendmail($email, $html);
            $todays_date = date('Y-m-d');
            $activated = 0;

            $this->sql->query = "INSERT INTO `login` (username,password, activated, token, created_on) values('$username','$password', $activated, '$token','$todays_date')";
            $this->sql->process();
            // $send_mail_check() = $this->sendEmailVerification($username, $email);
            if($mail_feedback['status'] == 0) {
                $result['msg'] = "Sending Mail Failed or Cannot contact your email!";
            }
        } catch(Exception $e) {
            $result['status'] = 0;
            $result['exception'] = $e;
            return $result;
        }

        $result['status'] = 1;
        $result['username'] = $username;
        return $result;

    }

    public function displayFriends($username) {
        $username = $this->sql->escape($username);
        
        $result = $this->sql->getDistinctDatas('friendname', 'friends', 'username', $username);
        // $result2 = $this->sql->getDistinctDatas('username', 'friends', 'friendname', $username);

        // foreach($result2 as &$name) {
        //     array_push($result, $name);
        // }
        return $result;
    }
    
    public function addFriend($username, $friend) {
        $username = $this->sql->escape($username);
        $friend = $this->sql->escape($friend);
        if($username == $friend) {
            $result['status'] = -2;
            $result['errorMsg'] = "You can't be friend of yourself";
            return $result; 
        }

        // !Blank Errors
        if($friend == '') {
            $result['status'] = 0;
            $result['errorMsg'] = "Friend Name cannot be blank";
            return $result;
        }

        //!Correctness checking
        if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $friend)){
            $result['status'] = 0;
            $result['errorMsg'] = 'Invalid Name';
            return $result;
        }
        // !check if friend already exists
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
            $this->sql->query = "INSERT INTO `friends` (username,friendname) values('$friend', '$username')";
            $this->sql->process();

        } catch(Exception $e) {
            $result['status'] = 0;
            return $result;
        }
        
        $result['status'] = 1;
        return $result;
    }

    public function getExpenseCategory() {
        $this->sql->query = "SELECT * FROM category";
        $result = $this->sql->process();
        $rows = mysqli_fetch_all($result);
        return $rows;
    }

    public function addIndividualExpense($username, $friend, $splitType, $amount, $category, $description, $whoPaid) {
        $amount = $this->sql->escape($amount);
        $description = $this->sql->escape($description);
        $todays_date = date('Y-m-d H:i:s');

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

        $owedAmount = $amount;
        if($splitType == 1 || $splitType == 2) {
            $owedAmount = $owedAmount / (count($friend) + 1);
        } else if($splitType == 3) {
            $owedAmount = $owedAmount / count($friend);
        }

        try {
            for($i = 0; $i < count($friend); $i++) {
                $owedBy = $friend[$i];
                if($whoPaid == $friend[$i]) {
                    $owedBy = $username;
                }
                $this->sql->query = "INSERT INTO expense(paidBy,owedBy, paidAmount, owedAmount, category, description, date, type) values ('$whoPaid', '$owedBy', '$amount', '$owedAmount', '$category', '$description', '$todays_date', 1)";
                $this->sql->process();
            }
            // if($whoPaid != $username)

            
        } catch(Exception $e) {
            $result['status'] = -1;
            $result['mg'] = "Some server error!";
            return $result;
        }

        $result['status'] = 1;
        $result['msg'] = "Split Done!";
        return $result;

    }

    public function addIndividualCustomExpense($username, $friend, $splitType, $amountPaid, $owedAmount, $category, $description, $whoPaid) {
        $amountPaid = $this->sql->escape($amountPaid);
        // $owedAmount = $this->sql->escape($owedAmount);
        $description = $this->sql->escape($description);
        $todays_date = date('Y-m-d H:i:s');

        // check amount
        if($amount < 0) {
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

        try {
            for($i = 0; $i < count($friend); $i++) {
                $owedBy = $friend[$i];
                $owed = $owedAmount[$i];
                $this->sql->query = "INSERT INTO expense(paidBy,owedBy, paidAmount, owedAmount, category, description, date, type) values ('$whoPaid', '$owedBy', '$amountPaid', '$owed', '$category', '$description', '$todays_date', 1)";
                $this->sql->process();
            }
            // if($whoPaid != $username)

            
        } catch(Exception $e) {
            $result['status'] = -1;
            $result['mg'] = "Some server error!";
            return $result;
        }

        $result['status'] = 1;
        $result['msg'] = "Split Done!";
        return $result;

    }

    public function addGroup($username, $groupname, $members) {
        // $groupname = $this->sql->escape($groupname);
        if(count($members) == 0) {
            $result['status'] = -1;
            return $result;
        }
        

        try {

            $this->sql->query = "INSERT INTO groups(grp_name, created_by) values('$groupname', '$username')";
            $this->sql->process();

            $groupId = $this->sql->getData('grp_id', 'groups', 'grp_name', $groupname, 'created_by', $username);

            for($i = 0; $i < count($members); $i++) {
                $member = $members[$i];
                $this->sql->query = "INSERT INTO groups_members(grp_id, grp_members) values ('$groupId', '$member')";
                $this->sql->process();
            }
        } catch(Exception $e) {
            $result['status'] = 0;
            return $result;
        }

        $result['groupId'] = $groupId;
        $result['status'] = 1;
        $result['members'] = $members;
        $result['groupname'] = $groupName;
        $result['username'] = $username;

        return $result;


        
    }
    

    
}
?>