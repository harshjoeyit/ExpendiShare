<?php

include('connect.php');

if(isset($_POST['reset-password-submit']))
{

    $selector = $_POST['selector'];
    $validator = $_POST['validator'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['pwd-repeat'];

    if(empty($password) || empty($passwordRepeat))
    {
        header('location: create-new-password.php?newpwd=empty');
        exit();
    }
    else if($password != $passwordRepeat)
    {
        header('location: create-new-password.php?newpwd=pwdnotsame');
        exit();
    }

    $currentDate = date('U');

    $sql = "SELECT * pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_int($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "Error occured";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $selector);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result) )
        {
            echo "You need to re-submit reset request";
            exit();
        }
        else
        {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

            if($tokenCheck === false)
            {
                echo "resubmit reset request";
                exit();
            }
            else if( $tokenCheck === true)
            {
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users_info WHERE email = ?; ";
                $stmt = mysqli_stmt_int($conn);

                if(!mysqli_stmt_prepare($stmt, $sql))
                {
                    echo "Error occured";
                    exit();
                }
                else
                {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result) )
                    {
                        echo "there was an error !! ";
                        exit();
                    }
                    else
                    {
                        $sql = "UPDATE users_info SET password=? WHERE email=?";
                        $stmt = mysqli_stmt_int($conn);

                        if(!mysqli_stmt_prepare($stmt, $sql))
                        {
                            echo "Error occured";
                            exit();
                        }
                        else
                        {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ? ";
                            $stmt = mysqli_stmt_int($conn);

                            if(!mysqli_stmt_prepare($stmt, $sql))
                            {
                                echo "Error occured";
                                exit();
                            }
                            else
                            {
                                mysqli_stmt_bind_param($stmt, "s", $userEmail);
                                mysqli_stmt_execute($stmt);
                                header('location: reset_password.php?newpwd=updated');
                            }
                        }
                    }
                }
            }
        }

    }
}
else
{
    header('location: ../html/login.html');
}

?>