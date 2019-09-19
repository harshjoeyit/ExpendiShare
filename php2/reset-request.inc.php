 <?php
 
 include('connect.php');



 if(isset($_POST['reset-request-submit']))
 {
    echo "true";
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = 'localhost/ExpendiShare/php2/create-new-password.php?selector=' . $selector . '&validator' . bin2hex($token);
    $expires = date('U') + 1800;

    $userEmail = $_POST['email'];

    // deleting the existing token because it may have expired 

    $sql = "DELETE FROM pwdreset WHERE pwdResetEmail = ? ";
    $stmt = mysqli_stmt_init($conn);

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



    // see ;
    $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_int($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "Error occured";
        exit();
    }
    else
    {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }


    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    $to = $userEmail;
    $subject = 'Reset your password for ExpendiShare';
    $message = 'the link to reset password is below: ';

    $message .= 'link: ';
    $message .= $url;

    $headers = "From: ExpendiShare <facilityexpendishare@gmail.com>";
    $headers .= "Reply-To: <facilityexpendishare@gmail.com>";
    $headers .= "Content-type: text/html";


    mail($to, $subject, $message, $headers);

    header('location: reset_password.php?reset=Success');
    
 }

 else
 {
     header('location: ../html/login.html');
 }
 
 ?>